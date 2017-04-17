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
     */
    public function indexAction(Request $request)
    {
        $searchForm = $this->createForm(SearchVehicleType::class);

        $searchForm->handleRequest($request);

        if ($searchForm->isSubmitted() && $searchForm->isValid()) {

            $search = $searchForm->getData();

            $vehicle = $this->getDoctrine()
                ->getRepository('AppBundle:Vehicle')
                ->findOneBy(array('registration' => $search['registration'], 'frame' => $search['frame']));

            if (!$vehicle) {
                $this->addFlash(
                    'notice',
                    'Le véhicule que vous recherchez n\'existe pas'
                );
            }


            return $this->render('AppBundle:Home:index.html.twig', array(
                'form' => $searchForm->createView(),
                'vehicle' => $vehicle,
            ));
        }

        return $this->render('AppBundle:Home:index.html.twig', array(
            'form' => $searchForm->createView(),
            'vehicle' => null,
        ));
    }

}
