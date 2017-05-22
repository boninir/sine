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
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Workflow\Exception\LogicException;
use Symfony\Component\HttpFoundation\Response;

class DateController extends Controller
{
    /**
     * @Route("/update/DateSend/{idVehicle}", name="update-date-send")
     */
    public function updateDateSendAction($idVehicle)
    {
        $this->getDoctrine()
            ->getRepository(Vehicle::class)
            ->setSendDate($idVehicle);

        return new Response('ok', 200);
    }

    /**
     * @Route("/update/DateExpertise/{idVehicle}", name="update-date-expertise")
     */
    public function updateDateExpertiseAction($idVehicle)
    {
        $this->getDoctrine()
            ->getRepository(Vehicle::class)
            ->setSendDate($idVehicle);
        
        return new Response('ok', 200);
    }

}
