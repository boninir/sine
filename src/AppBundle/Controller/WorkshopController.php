<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WorkshopController extends Controller
{
    /**
     * @Route("/mechanical", name="mechanical")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function mechanicalAction()
    {
        $vehicleInterventions = $this->getDoctrine()
            ->getRepository('AppBundle:VehicleIntervention')
            ->findAll();

        return $this->render('AppBundle:Workshop:mechanical.html.twig', array(
            'vehicleInterventions' => $vehicleInterventions,
        ));
    }

    /**
     * @Route("/bodywork", name="bodywork")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function bodyworkAction()
    {
        $vehicleInterventions = $this->getDoctrine()
            ->getRepository('AppBundle:VehicleIntervention')
            ->findAll();

        return $this->render('AppBundle:Workshop:bodywork.html.twig', array(
            'vehicleInterventions' => $vehicleInterventions,
        ));
    }

    /**
     * @Route("/cosmetic", name="cosmetic")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cosmeticAction()
    {
        $vehicleInterventions = $this->getDoctrine()
            ->getRepository('AppBundle:VehicleIntervention')
            ->findAll();

        return $this->render('AppBundle:Workshop:cosmetic.html.twig', array(
            'vehicleInterventions' => $vehicleInterventions,
        ));
    }

    /**
     * @Route("/cleaning", name="cleaning")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function cleaningAction()
    {
        $vehicleInterventions = $this->getDoctrine()
            ->getRepository('AppBundle:VehicleIntervention')
            ->findAll();

        return $this->render('AppBundle:Workshop:cleaning.html.twig', array(
            'vehicleInterventions' => $vehicleInterventions,
        ));
    }

    /**
     * @Route("/photo", name="photo")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function photoAction()
    {
        $vehicleInterventions = $this->getDoctrine()
            ->getRepository('AppBundle:VehicleIntervention')
            ->findAll();

        return $this->render('AppBundle:Workshop:photo.html.twig', array(
            'vehicleInterventions' => $vehicleInterventions,
        ));
    }
}