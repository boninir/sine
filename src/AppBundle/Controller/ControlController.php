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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ControlController extends Controller
{
    /**
     * @Route("/control/process/{id}", name="process-vehicle-control")
     */
    public function vehicleAction(Vehicle $vehicle, Request $request)
    {
        if ($vehicle->getState() !== Vehicle::STATE_CONTROL) {
            return $this->redirectToRoute('process', ['type' => 'control']);
        }

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(VehicleType::class, $vehicle);

        $interventions = $this->getDoctrine()
            ->getRepository(Intervention::class)
            ->findForVehicle($vehicle);

        $formIntervention = $this->createForm(
            ExpertiseType::class,
            ['interventions' => $interventions],
            ['vehicle' => $vehicle]
        );

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('notice', 'Les informations ont bien été mises à jour.');

            return $this->redirectToRoute('process-vehicle-control', ['id' => $vehicle->getId()]);
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
                    $intervention = $interventionToSave->getData();

                    $vehicleIntervention = (new VehicleIntervention())
                        ->setVehicle($vehicle)
                        ->addIntervention($intervention)
                        ->setComment($interventionToSave['comment']->getData())
                        ->setAnswers($interventionToSave['select']->getData())
                        ->setTime(
                            UnitOfWork::STATE_MANAGED !== $em->getUnitOfWork()->getEntityState($intervention)
                            ? $interventionToSave['time']->getData()
                            : null
                        )
                    ;

                    $em->persist($vehicleIntervention);
                }
            }

            $interventionType = [];

            foreach ($vehicle->getInterventions() as $vehicleIntervention) {
                if ($vehicleIntervention->getState() === VehicleIntervention::STATE_DONE) {
                    continue;
                }

                $typeIntervention = $vehicleIntervention->getIntervention()->getTypeIntervention();

                if (!in_array($typeIntervention, $interventionType)) {
                    $interventionType[] = $typeIntervention;
                }
            }

            $typeToLaunch = null;
            foreach ($interventionType as $type) {
                if ($typeToLaunch === null) {
                    $priority = $type->getPriority();
                    $typeToLaunch = $type;

                    continue;
                }

                if ($priority > $type->getPriority()) {
                    $priority = $type->getPriority();
                    $typeToLaunch = $type;
                }
            }

            $machine = $this->container->get('state_machine.vehicle');
            $machine->can($vehicle, $typeToLaunch->getTransition());
            $machine->apply($vehicle, $typeToLaunch->getTransition());

            $em->flush();
            $this->addFlash('notice', 'Le contrôle à bien été enregistré.');

            return $this->redirectToRoute('process', ['type' => 'control']);
        }

        return $this->render('AppBundle:Process:fullVehicle.html.twig', [
            'vehicle' => $vehicle,
            'interventions' => $interventions,
            'form' => $form->createView(),
            'formIntervention' => $formIntervention->createView(),
            'type' => 'control',
        ]);
    }
}