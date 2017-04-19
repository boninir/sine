<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Intervention;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\VehicleIntervention;
use AppBundle\Form\ExpertiseType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WorkshopController extends Controller
{
    /**
     * @Route("/mechanical", name="mechanical")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mechanicalAction()
    {
        $vehicles = $this->getDoctrine()
            ->getRepository(Vehicle::class)
            ->findByState('mechanical');

        return $this->render('AppBundle:Workshop:mechanical.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }

    /**
     * @param Vehicle $vehicle
     * @param Request $request
     *
     * @Route("/process-mechanical/{id}", name="process-mechanical")
     */
    public function processMechanical(Vehicle $vehicle, Request $request)
    {
        $workflow = $this->get('workflow.intervention');
        $em = $this->getDoctrine()->getManager();

        $interventions = $this->getDoctrine()
            ->getRepository(Intervention::class)
            ->findByTypeInterventionTransition('to_mechanical');

        $formIntervention = $this->createForm(
            ExpertiseType::class,
            ['interventions' => $interventions],
            ['vehicle' => $vehicle]
        );

        $formIntervention->handleRequest($request);

        // if ($formIntervention->isSubmitted() && $formIntervention->isValid()) {

        //     $interventionsToSave = $formIntervention->get('interventions');

        //     foreach ($interventionsToSave as $interventionToSave) {
        //         $vehicleIntervention = $em->getRepository(VehicleIntervention::class)
        //             ->findOneBy([
        //                 'vehicle' => $vehicle,
        //                 'intervention' => $interventionToSave->getData()
        //             ]);

        //         if (!$interventionToSave['select']->getData() && $vehicleIntervention !== null) {
        //             $em->remove($vehicleIntervention);
        //         } elseif ($vehicleIntervention !== null) {
        //             $vehicleIntervention
        //                 ->setComment($interventionToSave['comment']->getData())
        //                 ->setAnswers($interventionToSave['select']->getData())
        //             ;
        //         } elseif ($interventionToSave['select']->getData()) {
        //             $vehicleIntervention = (new VehicleIntervention())
        //                 ->setVehicle($vehicle)
        //                 ->addIntervention($interventionToSave->getData())
        //                 ->setComment($interventionToSave['comment']->getData())
        //                 ->setAnswers($interventionToSave['select']->getData())
        //             ;

        //             $em->persist($vehicleIntervention);
        //         }
        //     }

        //     $workflow = $this->container->get('workflow.vehicle');
        //     $workflow->can($vehicle, 'expertised');
        //     $workflow->apply($vehicle, 'expertised');

        //     $em->flush();

        //     $this->addFlash(
        //         'notice',
        //         'L\'expertise à bien été enregistrée.'
        //     );

        //     return $this->redirectToRoute('expert');
        // }

        return $this->render('AppBundle:Workshop:processMechanical.html.twig', array(
            'vehicle' => $vehicle,
            'interventions' => $interventions,
            'formIntervention' => $formIntervention->createView()
        ));
    }

    /**
     * @Route("/bodywork", name="bodywork")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function bodyworkAction()
    {
        $vehicles = $this->getDoctrine()
            ->getRepository(Vehicle::class)
            ->findByState('bodywork');

        return $this->render('AppBundle:Workshop:bodywork.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }

    /**
     * @Route("/cosmetic", name="cosmetic")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cosmeticAction()
    {
        $vehicles = $this->getDoctrine()
            ->getRepository(Vehicle::class)
            ->findByState('cosmetic');

        return $this->render('AppBundle:Workshop:cosmetic.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }

    /**
     * @Route("/cleaning", name="cleaning")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cleaningAction()
    {
        $vehicles = $this->getDoctrine()
            ->getRepository(Vehicle::class)
            ->findByState('cleaning');

        return $this->render('AppBundle:Workshop:cleaning.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }

    /**
     * @Route("/photo", name="photo")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function photoAction()
    {
        $vehicles = $this->getDoctrine()
            ->getRepository(Vehicle::class)
            ->findByState('photo');

        return $this->render('AppBundle:Workshop:photo.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }
}