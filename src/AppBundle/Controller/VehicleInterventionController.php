<?php

namespace AppBundle\Controller;

use AppBundle\Entity\VehicleIntervention;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VehicleInterventionController extends Controller
{
    /**
     * @param VehicleIntervention $intervention
     *
     * @Route("/vehicle-intervention/update-state/{id}", name="update_vehicle_intervention_state")
     */
    public function updateStateAction(VehicleIntervention $intervention, Request $request)
    {
        $currentVehicleState = $intervention->getVehicle()->getState();
        $machine = $this->container->get('state_machine.intervention');
        $state = $request->request->get('state');

        if ($state === VehicleIntervention::STATE_IN_PROGRESS && $intervention->getStartDate() === null) {
            $machine->apply($intervention, 'started');
            $intervention->setStartDate(new \DateTime());
        } elseif (
            $state === VehicleIntervention::STATE_DONE
            && $intervention->getStartDate() !== null
            && $intervention->getEndDate() === null
        ) {
            $machine->apply($intervention, 'finished');
            $intervention->setEndDate(new \DateTime());
        } else {
            return new Response('', 400);
        }

        $this->getDoctrine()
            ->getManager()
            ->flush();

        if ($currentVehicleState !== $intervention->getVehicle()->getState()) {
            return new Response('allDone');
        }

        return new Response();
    }

    /**
     * @param VehicleIntervention $intervention
     *
     * @Route("/vehicle-intervention/update-comment/{id}", name="update_vehicle_intervention_comment")
     */
    public function updateCommentAction(VehicleIntervention $intervention, Request $request)
    {
        var_dump("toto");
        $intervention->setComment($request->request->get('comment'));

        $this->getDoctrine()
            ->getManager()
            ->flush();

        return new Response();
    }
}