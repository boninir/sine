<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Intervention;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCosmeticInterventionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $type = $this->getReference('cosmetic');

        $intervention1 = (new Intervention())
            ->setDenomination('Réparation tableau de bord')
            ->setTypeIntervention($type)
            ->setRequired(1)
        ;
        $manager->persist($intervention1);

        $intervention2 = (new Intervention())
            ->setDenomination('Réparation intérieur de porte')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'AV conducteur',
                'AV passager',
                'AR droit',
                'AR gauche',
            ])
        ;
        $manager->persist($intervention2);

        $intervention3 = (new Intervention())
            ->setDenomination('Réparation sellerie')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Assise AV conducteur',
                'Dossier AV conducteur',
                'Assise AV passager',
                'Dossier AV passager',
                'Dossier banquette AR',
                'Dossier banquette AR',
            ])
        ;
        $manager->persist($intervention3);

        $intervention4 = (new Intervention())
            ->setDenomination('Réparation moquette de sol')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'AV conducteur',
                'AV passager',
                'AR',
                'Coffre',
            ])
        ;
        $manager->persist($intervention4);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
