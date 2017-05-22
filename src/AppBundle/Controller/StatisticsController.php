<?php

namespace AppBundle\Controller;

use AppBundle\AppBundle;
use AppBundle\Entity\Intervention;
use AppBundle\Entity\Vehicle;
use AppBundle\Entity\VehicleIntervention;
use AppBundle\Form\ExpertiseType;
use Doctrine\ORM\Query\AST\Functions\CurrentDateFunction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;

class StatisticsController extends Controller
{
    /**
     * @Route("/statistics", name="statistics")
     */
    public function indexAction()
    {
        
        //EN BORDEL, valeurs brutes pour la présentation
        $test='';
        for($mois = 0; $mois < 6; $mois++) {
            $date = getdate(strtotime('-'.$mois.' month'));
            $cptEnregistrement = $date['mon'];
            $moisRecherche = $date['year'].'-'.$date['mon'].'-'.$date['mday'].' '.$date['hours'].'-'.$date['minutes'].'-'.$date['seconds'];
            $date = getdate(strtotime('-'.($mois-1).' month'));
            $moisSuivant = $date['year'].'-'.$date['mon'].'-'.$date['mday'].' '.$date['hours'].'-'.$date['minutes'].'-'.$date['seconds'];
            
            $searchInterval = [$moisRecherche,$moisSuivant];
            $factureMois1 = array(
                'Nb entrées' => 0,
                'Nb sorties' => 0,
                'repartitionAteliers' => [
                    '% Mécanique' => 0,
                    '% Carrosserie' => 0,
                    '% Intérieur' => 0,
                    '% Nettoyage' => 0,
                ],
                'durationAteliers' => [
                    'Temps moyen voiture dans atelier' => 0,
                    'less5d' => 0,
                    'between5and10d' => 0,
                    'more10d' => 0,
                ],
                'durationCircuits' => [
                    'totalDuration' => 0,
                    'expertToControl' => 0,
                    'controlToWorkshop' => 0,
                    'inWorkshop' => 0,
                    'workshopToValidate' => 0,
                    'validateToDelivry' => 0
                ],
                'workshopItems' => [
                    'nbItems' => 0,
                    'itemsToPay' => 0,
                    'itemsFree' => 0,
                    'raccords' => 0,
                    'retroviseurs' => 0,
                    'jantes' => 0,
                    'petitesToleries' => 0,
                    'heuresCarrosserie' => 0,
                ],
                'mechanicalItems' => [
                    'nbItems' => 0,
                    'vidange' => 0,
                    'trainsDePneus' => 0,
                    'disques' => 0,
                    'plaquettes' => 0,
                    'geometrie' => 0,
                    'heuresMecanique' => 0,
                ]
            );
            $factureMois2 = array(
                'Nb entrées' => 189,
                'Nb sorties' => 201,
                'repartitionAteliers' => [
                    '% Mécanique' => 83,
                    '% Carrosserie' => 42,
                    '% Intérieur' => 94,
                    '% Nettoyage' => 92,
                ],
                'durationAteliers' => [
                    'Temps moyen voiture dans atelier' => 3,8,
                    'less5d' => 72,
                    'between5and10d' => 23,
                    'more10d' => 4,
                ],
                'durationCircuits' => [
                    'totalDuration' => 13,8,
                    'expertToControl' => 0,
                    'controlToWorkshop' => 0,
                    'inWorkshop' => 0,
                    'workshopToValidate' => 0,
                    'validateToDelivry' => 0
                ],
                'workshopItems' => [
                    'nbItems' => 129,
                    'itemsToPay' => 123,
                    'itemsFree' => 6,
                    'raccords' => 13,
                    'retroviseurs' => 6,
                    'jantes' => 0,
                    'petitesToleries' => 77,
                    'heuresCarrosserie' => 60.67,
                ],
                'mechanicalItems' => [
                    'nbItems' => 184,
                    'vidange' => 122,
                    'trainsDePneus' => 17,
                    'disques' => 2,
                    'plaquettes' => 6,
                    'geometrie' => 1,
                    'heuresMecanique' => 18.07,
                ]
            );
            $factureMois3 = array(
                'Nb entrées' => 313,
                'Nb sorties' => 247,
                'repartitionAteliers' => [
                    '% Mécanique' => 89,
                    '% Carrosserie' => 35,
                    '% Intérieur' => 95,
                    '% Nettoyage' => 84,
                ],
                'durationAteliers' => [
                    'Temps moyen voiture dans atelier' => 5.1,
                    'less5d' => 77,
                    'between5and10d' => 11,
                    'more10d' => 12,
                ],
                'durationCircuits' => [
                    'totalDuration' => 11.5,
                    'expertToControl' => 0,
                    'controlToWorkshop' => 0,
                    'inWorkshop' => 0,
                    'workshopToValidate' => 0,
                    'validateToDelivry' => 0
                ],
                'workshopItems' => [
                    'nbItems' => 131,
                    'itemsToPay' => 120,
                    'itemsFree' => 11,
                    'raccords' => 18,
                    'retroviseurs' => 15,
                    'jantes' => 0,
                    'petitesToleries' => 102,
                    'heuresCarrosserie' => 24.92,
                ],
                'mechanicalItems' => [
                    'nbItems' => 221,
                    'vidange' => 204,
                    'trainsDePneus' => 43,
                    'disques' => 21,
                    'plaquettes' => 25,
                    'geometrie' => 0,
                    'heuresMecanique' => 38.62,
                ]
            );
            $factureMois4 = array(
                'Nb entrées' => 192,
                'Nb sorties' => 251,
                'repartitionAteliers' => [
                    '% Mécanique' => 89,
                    '% Carrosserie' => 35,
                    '% Intérieur' => 94,
                    '% Nettoyage' => 79,
                ],
                'durationAteliers' => [
                    'Temps moyen voiture dans atelier' => 6.9,
                    'less5d' => 72,
                    'between5and10d' => 9,
                    'more10d' => 19,
                ],
                'durationCircuits' => [
                    'totalDuration' => 16.2,
                    'expertToControl' => 0,
                    'controlToWorkshop' => 0,
                    'inWorkshop' => 0,
                    'workshopToValidate' => 0,
                    'validateToDelivry' => 0
                ],
                'workshopItems' => [
                    'nbItems' => 234,
                    'itemsToPay' => 182,
                    'itemsFree' => 14,
                    'raccords' => 22,
                    'retroviseurs' => 14,
                    'jantes' => 4,
                    'petitesToleries' => 67,
                    'heuresCarrosserie' => 50.8,
                ],
                'mechanicalItems' => [
                    'nbItems' => 243,
                    'vidange' => 210,
                    'trainsDePneus' =>67,
                    'disques' => 26,
                    'plaquettes' => 45,
                    'geometrie' => 2,
                    'heuresMecanique' => 45.74,
                ]
            );
            $factureMois5 = array(
                'Nb entrées' => 216,
                'Nb sorties' => 196,
                'repartitionAteliers' => [
                    '% Mécanique' => 94,
                    '% Carrosserie' => 30,
                    '% Intérieur' => 93,
                    '% Nettoyage' => 77,
                ],
                'durationAteliers' => [
                    'Temps moyen voiture dans atelier' => 6.2,
                    'less5d' => 75,
                    'between5and10d' => 12,
                    'more10d' => 13,
                ],
                'durationCircuits' => [
                    'totalDuration' => 16.4,
                    'expertToControl' => 0,
                    'controlToWorkshop' => 0,
                    'inWorkshop' => 0,
                    'workshopToValidate' => 0,
                    'validateToDelivry' => 0
                ],
                'workshopItems' => [
                    'nbItems' => 115,
                    'itemsToPay' => 107,
                    'itemsFree' => 8,
                    'raccords' => 14,
                    'retroviseurs' => 7,
                    'jantes' => 1,
                    'petitesToleries' => 49,
                    'heuresCarrosserie' => 15.58,
                ],
                'mechanicalItems' => [
                    'nbItems' => 203,
                    'vidange' => 171,
                    'trainsDePneus' => 66,
                    'disques' => 20,
                    'plaquettes' => 33,
                    'geometrie' => 1,
                    'heuresMecanique' => 36.95,
                ]
            );
            $factureMois6 = array(
                'Nb entrées' => 223,
                'Nb sorties' => 204,
                'repartitionAteliers' => [
                    '% Mécanique' => 90,
                    '% Carrosserie' => 33,
                    '% Intérieur' => 91,
                    '% Nettoyage' => 69,
                ],
                'durationAteliers' => [
                    'Temps moyen voiture dans atelier' => 6.7,
                    'less5d' => 60,
                    'between5and10d' => 17,
                    'more10d' => 23,
                ],
                'durationCircuits' => [
                    'totalDuration' => 14.9,
                    'expertToControl' => 0,
                    'controlToWorkshop' => 0,
                    'inWorkshop' => 0,
                    'workshopToValidate' => 0,
                    'validateToDelivry' => 0
                ],
                'workshopItems' => [
                    'nbItems' => 143,
                    'itemsToPay' => 124,
                    'itemsFree' => 19,
                    'raccords' => 14,
                    'retroviseurs' => 15,
                    'jantes' => 19,
                    'petitesToleries' => 35,
                    'heuresCarrosserie' => 15.5,
                ],
                'mechanicalItems' => [
                    'nbItems' => 212,
                    'vidange' => 160,
                    'trainsDePneus' => 89,
                    'disques' => 32,
                    'plaquettes' => 58,
                    'geometrie' => 1,
                    'heuresMecanique' => 58.66,
                ]
            );
            $facture[5] = $factureMois1;
            $facture[4] = $factureMois2;
            $facture[3] = $factureMois3;
            $facture[2] = $factureMois4;
            $facture[1] = $factureMois5;
            $facture[12] = $factureMois6;
/*
            $em = $this->getDoctrine()->getManager();

            $vi = $em->getRepository('AppBundle:VehicleIntervention');

            $v = $em->getRepository('AppBundle:Vehicle');

            $factureMois['Nb entrées'] = $v->getNbVehicles();

            $factureMois['Nb sorties'] = $v->getNbSorties();

            $nbTotalInterventions = $vi->getNbInterventions($searchInterval);

            if ($nbTotalInterventions != 0) {
                $factureMois['repartitionAteliers']['% Mécanique'] = $vi->getNbTypeIntervention('Mécanique',$searchInterval) / $nbTotalInterventions * 100;
                $factureMois['repartitionAteliers']['% Carrosserie'] = $vi->getNbTypeIntervention('Carrosserie',$searchInterval) / $nbTotalInterventions * 100;
                $factureMois['repartitionAteliers']['% Intérieur'] = $vi->getNbTypeIntervention('Intérieur',$searchInterval) / $nbTotalInterventions * 100;
                $factureMois['repartitionAteliers']['% Nettoyage'] = $vi->getNbTypeIntervention('Nettoyage',$searchInterval) / $nbTotalInterventions * 100;
            }

            $resultAvg = $vi->getAvgDurationInWorkshop($searchInterval);
            $allDurationInWorkshop = array();
            foreach ($resultAvg as $tabMoy) {
                if ($tabMoy[1] > 0) {
                    array_push($allDurationInWorkshop, $tabMoy[1]);
                    if ($tabMoy[1] < 5) {
                        $factureMois['durationAteliers']['less5d']++;
                    } elseif ($tabMoy[1] > 10) {
                        $factureMois['durationAteliers']['more10d']++;
                    } else {
                        $factureMois['durationAteliers']['between5and10d']++;
                    }
                }
            }

            if (count($allDurationInWorkshop) != 0) {
                $factureMois['durationAteliers']['Temps moyen voiture dans atelier'] = (array_sum($allDurationInWorkshop) / count($allDurationInWorkshop));
                $factureMois['durationCircuits']['inWorkshop'] = $factureMois['durationAteliers']['Temps moyen voiture dans atelier'];
                $factureMois['durationAteliers']['less5d'] = $factureMois['durationAteliers']['less5d'] / count($allDurationInWorkshop) * 100;
                $factureMois['durationAteliers']['between5and10d'] = $factureMois['durationAteliers']['between5and10d'] / count($allDurationInWorkshop) * 100;
                $factureMois['durationAteliers']['more10d'] = $factureMois['durationAteliers']['more10d'] / count($allDurationInWorkshop) * 100;
            }

            $factureMois['workshopItems']['nbItems'] = $vi->getNbTypeIntervention('Carrosserie',$searchInterval);
            //$factureMois['workshopItems']['itemsToPay']=;
            //$factureMois['workshopItems']['itemsFree']=;
            $factureMois['workshopItems']['raccords'] = $vi->getNbVehicleInterBySearchAnswers('raccord',$searchInterval);
            $factureMois['workshopItems']['retroviseurs'] = $vi->getNbVehicleInterBySearchDenomination('retroviseur',$searchInterval);
            $factureMois['workshopItems']['jantes'] = $vi->getNbVehicleInterBySearchDenomination('jante',$searchInterval);
            $factureMois['workshopItems']['petitesToleries'] = $vi->getNbVehicleInterBySearchAnswers('tolerie',$searchInterval);
            //$factureMois['workshopItems']['heuresCarrosserie']=;

            $factureMois['mechanicalItems']['nbItems'] = $vi->getNbTypeIntervention('Mécanique',$searchInterval);
            $factureMois['mechanicalItems']['vidange'] = $vi->getNbVehicleInterBySearchDenomination('vidange',$searchInterval);
            $factureMois['mechanicalItems']['trainsDePneus'] = $vi->getNbVehicleInterBySearchDenomination('pneu',$searchInterval);
            $factureMois['mechanicalItems']['disques'] = $vi->getNbVehicleInterBySearchDenomination('disque',$searchInterval);
            $factureMois['mechanicalItems']['plaquettes'] = $vi->getNbVehicleInterBySearchDenomination('plaquette',$searchInterval);
            //$factureMois['mechanicalItems']['geometrie']=;
            //$factureMois['mechanicalItems']['heuresMecanique']=;

            $facture[$cptEnregistrement]=$factureMois;*/
        }
        
        return $this->render('AppBundle:Statistics:statistics.html.twig', [
            'facture' => $facture,
            'moisDeLAnnee' => [1=>'Janvier',2=>'Février',3=>'Mars',4=>'Avril',5=>'Mai',6=>'Juin',7=>'Juillet',8=>'Août',9=>'Septembre',10=>'Octobre',11=>'Novembre',12=>'Décembre']
        ]);
    }
    
}