<?php

namespace AppBundle\Listener;

use AppBundle\Entity\VehicleIntervention;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;

class InterventionTransitionListener implements EventSubscriberInterface
{
    private $machine;
    private $session;

    public function __construct($machine, $session)
    {
        $this->machine = $machine;
        $this->session = $session;
    }

    public function applyVehicleTransition(Event $event)
    {
        $intervention = $event->getSubject();
        $type = $intervention->getIntervention()->getTypeIntervention();
        $interventionType = [];

        foreach ($intervention->getVehicle()->getInterventions() as $vehicleIntervention) {
            if ($vehicleIntervention->getState() === VehicleIntervention::STATE_DONE
                || $intervention->getId() === $vehicleIntervention->getId()) {
                continue;
            }

            $typeIntervention = $vehicleIntervention->getIntervention()->getTypeIntervention();

            if ($type === $typeIntervention) {
                return;
            }

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

        $this->session->getFlashBag()->add(
            'notice',
            'Félicitation, toutes les interventions de ce véhicule sont terminées'
        );

        if ($typeToLaunch !== null) {
            $this->machine->apply($intervention->getVehicle(), $typeToLaunch->getTransition());
        } else {
            $this->machine->apply($intervention->getVehicle(), 'to_photo');
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            'workflow.intervention.enter.done' => array('applyVehicleTransition'),
        );
    }
}