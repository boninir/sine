<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Fuel;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFuelData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $gasoline = new Fuel();
        $gasoline->setDenomination('Essence');
        $manager->persist($gasoline);

        $diesel = new Fuel();
        $diesel->setDenomination('Diesel');
        $manager->persist($diesel);

        $electricity = new Fuel();
        $electricity->setDenomination('Électricité');
        $manager->persist($electricity);

        $hybride = new Fuel();
        $hybride->setDenomination('Hybride');
        $manager->persist($hybride);

        $manager->flush();
    }
    public function getOrder()
    {
        return 2;
    }

}
