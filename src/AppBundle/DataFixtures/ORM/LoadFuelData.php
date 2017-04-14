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

        $electric = new Fuel();
        $electric->setDenomination('Électrique');
        $manager->persist($electric);

        $hybrid = new Fuel();
        $hybrid->setDenomination('Hybride');
        $manager->persist($hybrid);

        $manager->flush();

        $this->addReference('gasoline', $gasoline);
        $this->addReference('diesel', $diesel);
        $this->addReference('electric', $electric);
        $this->addReference('hybrid', $hybrid);
    }

    public function getOrder()
    {
        return 2;
    }

}
