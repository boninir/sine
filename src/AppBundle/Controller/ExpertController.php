<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Intervention;
use AppBundle\Entity\Picture;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\VehicleIntervention;
use AppBundle\Form\ExpertiseType;
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
        $interventions = $this->getDoctrine()
            ->getRepository('AppBundle:Intervention')
            ->findBy(array('required' => 1));

        $formIntervention = $this->createForm(
            ExpertiseType::class,
            ['interventions' => $interventions],
            ['vehicle' => $vehicle]
        );
        $em = $this->getDoctrine()->getManager();

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

            $em->flush();


            $this->addFlash(
                'notice',
                'L\'expertise à bien été enregistrée.'
            );

            return $this->redirectToRoute('expertise', array('id' => $vehicle->getId()));
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $vehicle = $form->getData();

            $em->persist($vehicle);
            $em->flush();

            $this->addFlash(
                'notice',
                'Les informations ont bien été mises à jour.'
            );

            return $this->redirectToRoute('expertise', array('id' => $vehicle->getId()));
        }

        $pictures = $em->getRepository(Picture::class)
            ->findByVehicle($vehicle);

        return $this->render('AppBundle:Expert:processExpertise.html.twig', array(
            'vehicle' => $vehicle,
            'interventions' => $interventions,
            'form' => $form->createView(),
            'formIntervention' => $formIntervention->createView(),
            'pictures' => $pictures,
        ));
    }
}
