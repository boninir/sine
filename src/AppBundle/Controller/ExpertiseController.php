<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Intervention;
use AppBundle\Entity\Picture;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\VehicleIntervention;
use AppBundle\Form\ExpertiseType;
use AppBundle\Form\VehicleType;
use Doctrine\ORM\UnitOfWork;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Workflow\Exception\LogicException;

class ExpertiseController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/expertise/addVehicle", name="add-vehicle")
     */
    public function addVehicleAction(Request $request)
    {
        $vehicle = new Vehicle();
        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $vehicle = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicle);
            $em->flush();

            $this->addFlash(
                'notice',
                'Le véhicule a bien été enregistré.'
            );

            return $this->redirectToRoute('process', ['type' => 'expertise']);
        }

        return $this->render('AppBundle:Expertise:addVehicle.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Vehicle $vehicle
     * @param Request $request
     *
     * @Route("/expertise/process/{id}", name="process-vehicle-expertise")
     */
    public function processAction(Vehicle $vehicle, Request $request)
    {
        if ($vehicle->getState() !== Vehicle::STATE_EXPERTISE) {
            return $this->redirectToRoute('process', ['type' => 'expertise']);
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(VehicleType::class, $vehicle);

        $interventions = $this->getDoctrine()
            ->getRepository('AppBundle:Intervention')
            ->findBy(array('required' => 1));

        $formIntervention = $this->createForm(
            ExpertiseType::class,
            ['interventions' => $interventions],
            ['vehicle' => $vehicle]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('notice', 'Les informations ont bien été mises à jour.');

            return $this->redirectToRoute('process-vehicle-expertise', ['id' => $vehicle->getId()]);
        }

        $formIntervention->handleRequest($request);

        if ($formIntervention->isSubmitted() && $formIntervention->isValid()) {
            $interventionsToSave = $formIntervention->get('interventions');

            foreach ($interventionsToSave as $interventionToSave) {
                $vehicleIntervention = $em
                    ->getRepository(VehicleIntervention::class)
                    ->findOneBy([
                        'vehicle' => $vehicle,
                        'intervention' => $interventionToSave->getData()
                    ]);

                if (!$interventionToSave['select']->getData() && $vehicleIntervention !== null) {
                    $em->remove($vehicleIntervention);
                } elseif ($vehicleIntervention !== null) {
                    $vehicleIntervention
                        ->setComment($interventionToSave['comment']->getData())
                        ->setAnswers($interventionToSave['select']->getData())
                    ;
                } elseif ($interventionToSave['select']->getData()) {
                    $vehicleIntervention = (new VehicleIntervention())
                        ->setVehicle($vehicle)
                        ->addIntervention($interventionToSave->getData())
                        ->setComment($interventionToSave['comment']->getData())
                        ->setAnswers($interventionToSave['select']->getData())
                        ->setTime($interventionToSave['time']->getData())
                    ;

                    $em->persist($vehicleIntervention);
                }
            }

            foreach ($formIntervention->get('pictures')->getData() as $file) {
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
            $machine->can($vehicle, 'expertised');
            $machine->apply($vehicle, 'expertised');

            $em->flush();
            $this->addFlash('notice', "L'expertise à bien été enregistrée.");

            return $this->redirectToRoute('process', ['type' => 'expertise']);
        }

        $pictures = $em->getRepository(Picture::class)
            ->findByVehicle($vehicle);

        return $this->render('AppBundle:Process:fullVehicle.html.twig', [
            'vehicle' => $vehicle,
            'interventions' => $interventions,
            'form' => $form->createView(),
            'formIntervention' => $formIntervention->createView(),
            'pictures' => $pictures,
        ]);
    }
}
