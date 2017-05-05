<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Intervention;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCleaningInterventionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $type = $this->getReference('cleaning');

        $intervention1 = new Intervention();
        $intervention1
            ->setDenomination('Shampoing des tissus')
            ->setTypeIntervention($type)
            ->setRequired(1);
        $manager->persist($intervention1);

        $intervention2 = new Intervention();
        $intervention2
            ->setDenomination('Traitement du cuir')
            ->setTypeIntervention($type)
            ->setRequired(1);
        $manager->persist($intervention2);

        $intervention3 = new Intervention();
        $intervention3
            ->setDenomination('Complet')
            ->setTypeIntervention($type)
            ->setRequired(1);

        $manager->persist($intervention3);

        $intervention4 = new Intervention();
        $intervention4
            ->setDenomination('Polish')
            ->setTypeIntervention($type)
            ->setRequired(1);

        $manager->persist($intervention4);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
