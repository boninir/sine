<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Picture;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\VehicleIntervention;
use AppBundle\Form\ExpertiseType;
use AppBundle\Form\VehicleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class EntranceController extends Controller
{
    /**
     * @Route("/entrance", name="entrance")
     * @Template
     */
    public function indexAction()
    {
        $vehicles = $this->getDoctrine()
            ->getRepository('AppBundle:Vehicle')
            ->findByState(Vehicle::STATE_CONTROL);

        return ['vehicles' => $vehicles];
    }

    /**
     * @Route("/control/{id}", name="control")
     * @Template
     */
    public function controlAction(Vehicle $vehicle, Request $request)
    {
        if ($vehicle->getState() !== Vehicle::STATE_CONTROL) {
            return $this->redirectToRoute('entrance');
        }

        $form = $this->createForm(VehicleType::class, $vehicle);
        $interventions = $this->getDoctrine()
            ->getRepository('AppBundle:Intervention')
            ->findBy(array('required' => 1));

        $formIntervention = $this->createForm(
            ExpertiseType::class,
            ['interventions' => $interventions],
            ['vehicle' => $vehicle]
        );
        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $vehicle = $form->getData();

            $em->persist($vehicle);
            $em->flush();

            $this->addFlash(
                'notice',
                'Les informations ont bien été mises à jour.'
            );

            return $this->redirectToRoute('control', array('id' => $vehicle->getId()));
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
                        ->setState('à lancer')
                        ->setComment($interventionToSave['comment']->getData())
                        ->setAnswers($interventionToSave['select']->getData())
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

            $workflow = $this->container->get('workflow.vehicle');
            $workflow->can($vehicle, 'controled');
            $workflow->apply($vehicle, 'controled');

            $em->flush();

            $this->addFlash(
                'notice',
                'L\'expertise à bien été enregistrée.'
            );

            return $this->redirectToRoute('entrance');
        }

        $pictures = $em->getRepository(Picture::class)
            ->findByVehicle($vehicle);

        return [
            'vehicle' => $vehicle,
            'interventions' => $interventions,
            'form' => $form->createView(),
            'formIntervention' => $formIntervention->createView(),
            'pictures' => $pictures,
        ];
    }
}