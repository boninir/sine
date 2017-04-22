<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Intervention;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\VehicleIntervention;
use AppBundle\Form\ExpertiseType;
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
            return $this->redirectToRoute('photo');
        }

        return $this->render('AppBundle:Process:vehiclePhoto.html.twig', array(
            'vehicle' => $vehicle,
        ));
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
            return $this->redirectToRoute($type);
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