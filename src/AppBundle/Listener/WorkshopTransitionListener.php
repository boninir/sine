<?php

namespace AppBundle\Listener;

use AppBundle\Entity\VehicleIntervention;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\GuardEvent;

class BlogPostReviewListener implements EventSubscriberInterface
{
    public function applyVehicleTransition(GuardEvent $event)
    {
        $intervention = $event->getSubject();
        $type = $intervention->getIntervention()->getTypeIntervention();
        $interventionType = [];

        foreach ($intervention->getVehicle()->getInterventions() as $vehicleIntervention) {
            if ($vehicleIntervention->getState() === VehicleIntervention::STATE_DONE) {
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

            if ($priority < $type->getPriority()) {
                $priority = $type->getPriority();
                $typeToLaunch = $type;
            }
        }

        $workflow->apply($vehicle, $typeToLaunch->getTransition());
    }

    public static function getSubscribedEvents()
    {
        return array(
            'workflow.intervention.enter.finished' => array('applyVehicleTransition'),
        );
    }
}