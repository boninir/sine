<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Vehicle;
use AppBundle\Form\VehicleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ExpertController extends Controller
{
    /**
     * @Route("/expert", name="expert")
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function expertIndexAction()
    {
        $vehicles = $this->getDoctrine()
            ->getRepository('AppBundle:Vehicle')
            ->findAll();

        return $this->render('AppBundle:Expert:expert.html.twig', array(
            'vehicles' => $vehicles,
        ));
    }

    /**
     * @Route("/expert/addVehicle", name="add-vehicle")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
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

            return $this->redirectToRoute('expert');
        }

        return $this->render('AppBundle:Expert:addVehicle.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/expertise/{id}", name="expertise")
     * @param Vehicle $vehicle
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function processExpertiseAction(Vehicle $vehicle, Request $request)
    {
        $form = $this->createForm(VehicleType::class, $vehicle);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $vehicle = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($vehicle);
            $em->flush();

            $this->addFlash(
                'notice',
                'Les informations ont bien été mises à jour.'
            );

            return $this->redirectToRoute('expertise', array('id' => $vehicle->getId()));
        }

        return $this->render('AppBundle:Expert:processExpertise.html.twig', array(
            'vehicle' => $vehicle,
            'form' => $form->createView(),
        ));
    }
}
