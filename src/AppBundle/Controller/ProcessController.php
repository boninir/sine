<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Intervention;
use AppBundle\Entity\Picture;
use AppBundle\Entity\Transport;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\VehicleIntervention;
use AppBundle\Form\ExpertiseType;
use AppBundle\Form\PictureType;
use AppBundle\Form\RegisterType;
use AppBundle\Repository\PictureRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\PictureController;
use AppBundle\Repository\TransportRepository;


class ProcessController extends Controller
{
    /**
     * @Route("/{type}/process", name="process")
     */
    public function indexAction($type)
    {
        $userId = $this->getUser();

        if($type === 'transport') {
            $transport = $this->getDoctrine()
                ->getRepository(Transport::class)
                ->findOneBy(['state' => 'onRoad',
                    'user' => $this->getUser()]);

            if (isset($transport)) {
                $vehicles = $transport->getAllVehicle();
                $type="onRoad";
            }
        }

        $vehicleTransitions=[];

        if($type === 'change'){
            $vehicles = $this->getDoctrine()
                ->getRepository(Vehicle::class)
                ->findBy(['state' => ['"mechanical"','"cosmetic"','"cleaning"','"bodywork"','"photo"']]);
            $vehicleIdToRedirect=[];
            foreach ($vehicles as $vehicle){
                $transitions = $this->getDoctrine()->getRepository('AppBundle:VehicleIntervention')->findTransitionByVehicle($vehicle);
                $vehicleId = $vehicle->getId();

                $trans = [];
                foreach ($transitions as $transition){
                    if($vehicle->getState() != str_replace('to_','',$transition['transition'])){
                        array_push($trans,str_replace('to_','',$transition['transition']));
                    }
                }
                if($trans != null){
                    $vehicleTransitions[$vehicleId]=$trans;
                    array_push($vehicleIdToRedirect, $vehicleId);
                }
            }
            $vehicles = $this->getDoctrine()
                ->getRepository(Vehicle::class)
                ->findBy(['id' => $vehicleIdToRedirect]);
        } else {
            $vehicles = $this->getDoctrine()
                ->getRepository(Vehicle::class)
                ->findByState($type);
        }

        return $this->render('AppBundle:Process:index.html.twig', [
            'userId' => $userId,
            'route' => 'process-vehicle',
            'authorizeCreation' => $type === Vehicle::STATE_EXPERTISE,
            'type' => $type,
            'transitions' => $vehicleTransitions,
            'vehicles' => $vehicles,
        ]);
    }

    /**
     * @param string  $type
     * @param Vehicle $vehicle
     *
     * @Route("/{type}/process/{id}", name="process-vehicle")
     */
    public function processVehicleAction($type, Vehicle $vehicle, Request $request)
    {

        if($type == "photo"){
            $em = $this->getDoctrine()->getManager();
            $p = $em->getRepository('AppBundle:Picture');
            $pictures = $p->findBy(['vehicle'=>$vehicle]);
            
            return $this->render('AppBundle:Process:vehiclePhoto.html.twig', array(
                'pictures' => $pictures,
                'vehicle' => $vehicle,
            ));
        }


        if ($vehicle->getState() !== $type) {
            return $this->redirectToRoute($type);
        }

        if($vehicle->getInWorkDate()==null){
            $em = $this->getDoctrine()->getManager();

            $vehicle->setInWorkDate(new \DateTime());

            $em->persist($vehicle);
            $em->flush();
        }

        $interventions = $this->getDoctrine()
            ->getRepository(VehicleIntervention::class)
            ->findByTypeInterventionTransition('to_' . $type, $vehicle->getId());

        return $this->render('AppBundle:Process:vehicle.html.twig', [
            'type' => $type,
            'vehicle' => $vehicle,
            'interventions' => $interventions,
        ]);
    }

    /**
     * @param Request $request
     * @Route("/redirect", name="redirect-vehicle")
     */
    public function redirectVehicleAction(Request $request)
    {
        $idToRedirect = explode('/',$_POST['idAndPlace'])[0];
        $whereToGo = explode('/',$_POST['idAndPlace'])[1];

        $em = $this->getDoctrine()->getManager();

        $vehicle = $em->getRepository(Vehicle::class)->find($idToRedirect);

        $machine = $this->container->get('state_machine.vehicle');

        $machine->can($vehicle, $whereToGo);
        $machine->apply($vehicle, $whereToGo);

        $em->flush();

        return new Response('',200);
    }

    /**
     * @Route("/transport/create", name="process-transport")
     */
    public function createTransportAction(){
        $tabIdVehicleTransport = explode(',',$_POST['tabIdTransport']);
        $numVehicle = 1;

        $em = $this->getDoctrine()->getManager();

        $vehicleRepository = $em->getRepository('AppBundle:Vehicle');
        $machine = $this->container->get('state_machine.vehicle');

        $transport = new Transport();

        $transport->setUser($this->getUser());

        foreach ($tabIdVehicleTransport as $idVehicle){
            $vehicle = $vehicleRepository->find($idVehicle);
            $nomFonction = "setVehicle".$numVehicle;
            $transport->$nomFonction($vehicle);

            $vehicle->setSendDate(new \DateTime());

            $machine->can($vehicle, 'transported');
            $machine->apply($vehicle, 'transported');

            $em->persist($vehicle);

            $numVehicle++;
        }

        $em->persist($transport);
        $em->flush();

        return new Response('', 200);
    }

    /**
     * @Route("/transport/validate/{userId}", name="validate-transport")
     */
    public function validateTransportAction($userId){
        $em = $this->getDoctrine()->getManager();
        $transportRepository = $em->getRepository('AppBundle:Transport');
        $transport = $transportRepository->findOneBy(['user'=>$userId, 'state'=>'onRoad']);
        $vehicles = $transport->getAllVehicle();
        $machine = $this->container->get('state_machine.vehicle');


        foreach ($vehicles as $vehicle){
            $vehicle->setReceiveDate(new \DateTime());

            echo $vehicle->getState();

            $machine->can($vehicle, 'arrived');
            $machine->apply($vehicle, 'arrived');

            $em->persist($vehicle);
        }

        $transport->setState('arrived');
        $em->persist($transport);

        $em->flush();

        return new Response('', 200);
    }
}