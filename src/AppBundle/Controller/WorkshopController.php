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
        if ($vehicle->getState() !== 'mechanical') {
            return $this->redirectToRoute('mechanical');
        }

        $interventions = $this->getDoctrine()
            ->getRepository(VehicleIntervention::class)
            ->findByTypeInterventionTransition('to_mechanical');

        return $this->render('AppBundle:Workshop:processMechanical.html.twig', [
            'vehicle' => $vehicle,
            'interventions' => $interventions,
        ]);
    }

    /**
     * @Route("/bodywork", name="bodywork")
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
     * @param Vehicle $vehicle
     * @param Request $request
     *
     * @Route("/process-bodywork/{id}", name="process-bodywork")
     */
    public function processBodywork(Vehicle $vehicle, Request $request)
    {
        if ($vehicle->getState() !== 'bodywork') {
            return $this->redirectToRoute('bodywork');
        }

        $interventions = $this->getDoctrine()
            ->getRepository(VehicleIntervention::class)
            ->findByTypeInterventionTransition('to_bodywork');

        return $this->render('AppBundle:Workshop:processBodywork.html.twig', [
            'vehicle' => $vehicle,
            'interventions' => $interventions,
        ]);
    }

    /**
     * @Route("/cosmetic", name="cosmetic")
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
     * @param Vehicle $vehicle
     * @param Request $request
     *
     * @Route("/process-cosmetic/{id}", name="process-cosmetic")
     */
    public function processCosmetic(Vehicle $vehicle, Request $request)
    {
        if ($vehicle->getState() !== 'cosmetic') {
            return $this->redirectToRoute('cosmetic');
        }

        $interventions = $this->getDoctrine()
            ->getRepository(VehicleIntervention::class)
            ->findByTypeInterventionTransition('to_cosmetic');

        return $this->render('AppBundle:Workshop:processCosmetic.html.twig', [
            'vehicle' => $vehicle,
            'interventions' => $interventions,
        ]);
    }

    /**
     * @Route("/cleaning", name="cleaning")
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
     * @param Vehicle $vehicle
     * @param Request $request
     *
     * @Route("/process-cleaning/{id}", name="process-cleaning")
     */
    public function processCleaning(Vehicle $vehicle, Request $request)
    {
        if ($vehicle->getState() !== 'cleaning') {
            return $this->redirectToRoute('cleaning');
        }

        $interventions = $this->getDoctrine()
            ->getRepository(VehicleIntervention::class)
            ->findByTypeInterventionTransition('to_cleaning');

        return $this->render('AppBundle:Workshop:processCleaning.html.twig', [
            'vehicle' => $vehicle,
            'interventions' => $interventions,
        ]);
    }

    /**
     * @Route("/photo", name="photo")
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

    /**
     * @Route("/process-photo/{id}", name="process-photo")
     */
    public function processPhotoAction(Vehicle $vehicle)
    {
        if ($vehicle->getState() !== 'photo') {
            return $this->redirectToRoute('photo');
        }

        return $this->render('AppBundle:Workshop:processPhoto.html.twig', array(
            'vehicle' => $vehicle,
        ));
    }
}