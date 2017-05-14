<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Intervention;
use AppBundle\Entity\Picture;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\VehicleIntervention;
use AppBundle\Form\ExpertiseType;
use AppBundle\Form\PhotoType;
use AppBundle\Form\ValidationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProcessController extends Controller
{
    /**
     * @Route("/{type}/process", name="process")
     */
    public function indexAction($type)
    {
        $vehicles = $this->getDoctrine()
            ->getRepository(Vehicle::class)
            ->findByState($type);

        return $this->render('AppBundle:Process:index.html.twig', [
            'route' => 'process-vehicle',
            'authorizeCreation' => $type === Vehicle::STATE_EXPERTISE,
            'type' => $type,
            'vehicles' => $vehicles,
        ]);
    }

    /**
     * @param Vehicle $vehicle
     * @param Request $request
     *
     * @Route("/photo/process/{id}", name="process-vehicle-photo")
     */
    public function processVehiclePhotoAction(Vehicle $vehicle, Request $request)
    {
        if ($vehicle->getState() !== 'photo') {
            return $this->redirectToRoute('process', ['type' => 'photo']);
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(PhotoType::class);
        $form->handleRequest($request);

        if ($form->isValid()) {
            foreach ($form->get('pictures')->getData() as $file) {
                if ($file === null) {
                    continue;
                }

                $picture = (new Picture())
                    ->setName(sprintf('%s.%s', md5(uniqid()), $file->guessExtension()))
                    ->setVehicle($vehicle);

                $em->persist($picture);

                $file->move(
                    sprintf('vehicle-pictures/%d', $vehicle->getId()),
                    $picture->getName()
                );
            }

            $machine = $this->container->get('state_machine.vehicle');
            $machine->can($vehicle, 'validate');
            $machine->apply($vehicle, 'validate');

            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Félicitation, les photos de ce véhicule ont bien été enregistrées'
            );

            return $this->redirectToRoute('process', ['type' => 'photo']);
        }

        return $this->render('AppBundle:Process:vehiclePhoto.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
            'type' => 'photo',
        ]);
    }

    /**
     * @param Vehicle $vehicle
     * @param Request $request
     *
     * @Route("/validation/process/{id}", name="process-vehicle-validation")
     */
    public function processVehicleValidationAction(Vehicle $vehicle, Request $request)
    {
        if ($vehicle->getState() !== 'validation') {
            return $this->redirectToRoute('process', ['type' => 'validation']);
        }

        $em = $this->getDoctrine()->getManager();
        $vehicleInterventions = $this->getDoctrine()
            ->getRepository(VehicleIntervention::class)
            ->findByVehicle($vehicle);

        $pictures = $em->getRepository(Picture::class)
            ->findByVehicle($vehicle);

        $form = $this->createForm(
            ValidationType::class,
            ['vehicleInterventions' => $vehicleInterventions]
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $machine = $this->container->get('state_machine.vehicle');
            $machine->can($vehicle, 'terminated');
            $machine->apply($vehicle, 'terminated');

            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Félicitation, ce véhicule a bien été validé pour sa sortie'
            );

            return $this->redirectToRoute('process', ['type' => 'validation']);
        }

        return $this->render('AppBundle:Process:vehicleValidation.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView(),
            'pictures' => $pictures,
            'type' => 'validation',
        ]);
    }

    /**
     * @param string  $type
     * @param Vehicle $vehicle
     * @param Request $request
     *
     * @Route("/{type}/process/{id}", name="process-vehicle")
     */
    public function processVehicleAction($type, Vehicle $vehicle, Request $request)
    {
        if ($vehicle->getState() !== $type) {
            return $this->redirectToRoute('process', ['type' => $type]);
        }

        $interventions = $this->getDoctrine()
            ->getRepository(VehicleIntervention::class)
            ->findByTypeInterventionTransition('to_' . $type);

        return $this->render('AppBundle:Process:vehicle.html.twig', [
            'type' => $type,
            'vehicle' => $vehicle,
            'interventions' => $interventions,
        ]);
    }
}