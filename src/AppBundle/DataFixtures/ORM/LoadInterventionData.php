<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Intervention;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadInterventionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $mechanical = $this->getReference('mechanical');

        $intervention1 = new Intervention();
        $intervention1
            ->setDenomination('Vidange - filtres')
            ->setTypeIntervention($mechanical)
            ->setRequired(1);
        $manager->persist($intervention1);

        $intervention2 = new Intervention();
        $intervention2
            ->setDenomination('Disques de frein AV')
            ->setTypeIntervention($mechanical)
            ->setRequired(1);
        $manager->persist($intervention2);

        $intervention3 = new Intervention();
        $intervention3
            ->setDenomination('Disques de frein AR')
            ->setTypeIntervention($mechanical)
            ->setRequired(1);
        $manager->persist($intervention3);

        $intervention4 = new Intervention();
        $intervention4
            ->setDenomination('Plaquettes AV')
            ->setTypeIntervention($mechanical)
            ->setRequired(1);
        $manager->persist($intervention4);


        $intervention5 = new Intervention();
        $intervention5
            ->setDenomination('Plaquettes AR')
            ->setTypeIntervention($mechanical)
            ->setRequired(1);
        $manager->persist($intervention5);

        $intervention6 = new Intervention();
        $intervention6
            ->setDenomination('Pneumatiques AV')
            ->setTypeIntervention($mechanical)
            ->setRequired(1);
        $manager->persist($intervention6);

        $intervention7 = new Intervention();
        $intervention7
            ->setDenomination('Pneumatiques AV')
            ->setTypeIntervention($mechanical)
            ->setRequired(1);
        $manager->persist($intervention7);

        $intervention8 = new Intervention();
        $intervention8
            ->setDenomination('Distribution')
            ->setTypeIntervention($mechanical)
            ->setRequired(1);
        $manager->persist($intervention8);

        $intervention9 = new Intervention();
        $intervention9
            ->setDenomination('100 points de contrôle')
            ->setTypeIntervention($mechanical)
            ->setRequired(1);
        $manager->persist($intervention9);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}
