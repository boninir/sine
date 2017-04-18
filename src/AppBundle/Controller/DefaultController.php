<?php

namespace AppBundle\Controller;

use AppBundle\Form\SearchVehicleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="index")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $searchForm = $this->createForm(SearchVehicleType::class);
        $em = $this->getDoctrine()->getRepository('AppBundle:Vehicle');
        $emIntervention = $this->getDoctrine()->getRepository('AppBundle:VehicleIntervention');

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {

            $search = $searchForm->getData();

            if ($search['registration'] !== null && $search['frame'] !== null) {
                $vehicle = $em->findOneBy(array('registration' => $search['registration'], 'frame' => $search['frame']));
            } else if ($search['frame'] === null) {
                $vehicle = $em->findOneByRegistration($search['registration']);
            } else {
                $vehicle = $em->findOneByFrame($search['frame']);
            }

            if (!$vehicle) {
                $this->addFlash(
                    'notice',
                    'Le véhicule que vous recherchez n\'existe pas'
                );

                return $this->render('AppBundle:Home:index.html.twig', array(
                    'form' => $searchForm->createView(),
                    'vehicle' => null,
                    'progress' => 0,
                ));
            }

            if ($vehicle->getInterventions()->count() == 0) {
                $this->addFlash(
                    'warning',
                    'Le véhicule est en cours d\'expertise.
                    Son suivi sera disponible une fois le contrôle d\'entrée effectué'
                );

                return $this->render('AppBundle:Home:index.html.twig', array(
                    'form' => $searchForm->createView(),
                    'vehicle' => null,
                    'progress' => 0,
                ));
            }

            $finish = count($emIntervention->findBy(array('vehicle' => $vehicle, 'state' => 'terminé')));
            $totalIntervention = $vehicle->getInterventions()->count() == 0 ? 1 : $vehicle->getInterventions()->count();

            $progress = ($finish / $totalIntervention) * 100;

            return $this->render('AppBundle:Home:index.html.twig', array(
                'form' => $searchForm->createView(),
                'vehicle' => $vehicle,
                'progress' => $progress,
            ));
        }

        return $this->render('AppBundle:Home:index.html.twig', array(
            'form' => $searchForm->createView(),
            'vehicle' => null,
            'progress' => 0,
        ));
    }

}
