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
        //On récupère les transitions afin de savoir de rediriger la voiture vers d'autres ateliers
        //Exporter la méthode vers les Repository
        $transitions = array();
        foreach ($vehicles as $vehicle){
            $intervVehicle = $vehicle->getInterventions();
            $transVehicle = array();
            foreach ($intervVehicle as $interv){
                //On conserve les transitions vers les ateliers != atelier courant (ici mechanical)
                if(str_replace("to_","",$interv->getIntervention()->getTypeIntervention()->getTransition())!=$vehicle->getState()){
                    array_push($transVehicle,str_replace("to_","",$interv->getIntervention()->getTypeIntervention()->getTransition()));
                }
            }
            $transitions[$vehicle->getId()] = array_unique($transVehicle);
        }
        return $this->render('AppBundle:Workshop:mechanical.html.twig', array(
            'vehicles' => $vehicles,
            'transitions' => $transitions,
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
        //On récupère les transitions afin de savoir de rediriger la voiture vers d'autres ateliers
        $transitions = array();
        foreach ($vehicles as $vehicle){
            $intervVehicle = $vehicle->getInterventions();
            $transVehicle = array();
            foreach ($intervVehicle as $interv){
                //On conserve les transitions vers les ateliers != atelier courant
                if(str_replace("to_","",$interv->getIntervention()->getTypeIntervention()->getTransition())!=$vehicle->getState()){
                    array_push($transVehicle,str_replace("to_","",$interv->getIntervention()->getTypeIntervention()->getTransition()));
                }
            }
            $transitions[$vehicle->getId()] = array_unique($transVehicle);
        }
        return $this->render('AppBundle:Workshop:bodywork.html.twig', array(
            'vehicles' => $vehicles,
            'transitions' => $transitions,
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
        //On récupère les transitions afin de savoir de rediriger la voiture vers d'autres ateliers
        $transitions = array();
        foreach ($vehicles as $vehicle){
            $intervVehicle = $vehicle->getInterventions();
            $transVehicle = array();
            foreach ($intervVehicle as $interv){
                //On conserve les transitions vers les ateliers != atelier courant
                if(str_replace("to_","",$interv->getIntervention()->getTypeIntervention()->getTransition())!=$vehicle->getState()){
                    array_push($transVehicle,str_replace("to_","",$interv->getIntervention()->getTypeIntervention()->getTransition()));
                }
            }
            $transitions[$vehicle->getId()] = array_unique($transVehicle);
        }
        return $this->render('AppBundle:Workshop:cosmetic.html.twig', array(
            'vehicles' => $vehicles,
            'transitions' => $transitions,
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
        //On récupère les transitions afin de savoir de rediriger la voiture vers d'autres ateliers
        $transition = array();
        foreach ($vehicles as $vehicle){
            $intervVehicle = $vehicle->getInterventions();
            $transVehicle = array();
            foreach ($intervVehicle as $interv){
                //On conserve les transitions vers les ateliers != atelier courant
                if(str_replace("to_","",$interv->getIntervention()->getTypeIntervention()->getTransition())!=$vehicle->getState()){
                    array_push($transVehicle,str_replace("to_","",$interv->getIntervention()->getTypeIntervention()->getTransition()));
                }
            }
            $transition[$vehicle->getId()] = array_unique($transVehicle);
        }
        return $this->render('AppBundle:Workshop:cleaning.html.twig', array(
            'vehicles' => $vehicles,
            'transitions' => $transition,
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
     * @param Vehicle $vehicle
     *
     * @Route("/redirect-cosmetic/{id}", name="redirect-cosmetic")
     */
    public function redirectCosmeticAction(Vehicle $vehicle){
        $vehicle->setState("cosmetic");
        $this->getDoctrine()
            ->getManager()
            ->flush();
        return $this->redirectToRoute('cosmetic');
    }

    /**
     * @param Vehicle $vehicle
     *
     * @Route("/redirect-mechanical/{id}", name="redirect-mechanical")
     */
    public function redirectMechanicalAction(Vehicle $vehicle){
        $vehicle->setState("mechanical");
        $this->getDoctrine()
            ->getManager()
            ->flush();
        return $this->redirectToRoute('mechanical');
    }

    /**
     * @param Vehicle $vehicle
     *
     * @Route("/redirect-bodywork/{id}", name="redirect-bodywork")
     */
    public function redirectBodyworkAction(Vehicle $vehicle){
        $vehicle->setState("bodywork");
        $this->getDoctrine()
            ->getManager()
            ->flush();
        return $this->redirectToRoute('bodywork');
    }

    /**
     * @param Vehicle $vehicle
     *
     * @Route("/redirect-cleaning/{id}", name="redirect-cleaning")
     */
    public function redirectCleaningAction(Vehicle $vehicle){
        $vehicle->setState("cleaning");
        $this->getDoctrine()
            ->getManager()
            ->flush();
        return $this->redirectToRoute('cleaning');
    }
}