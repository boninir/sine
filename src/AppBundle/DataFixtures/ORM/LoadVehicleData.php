<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Vehicle;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadVehicleData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $vehicle = (new Vehicle())
            ->setFuel($this->getReference('electric'))
            ->setRegistration('DB666GT')
            ->setMark('Tesla')
            ->setModel('P100D')
            ->setType('VO 0 KM')
            ->setCv(30)
            ->setFrame('AX100')
            ->setColor('Rouge')
            ->setReleaseDate(new \DateTime('2016-08-08 00:00:00'))
            ->setKilometerTraveled(0)
            ->setKilometerOnCounter(0)
        ;

        $manager->persist($vehicle);

        $manager->flush();

        $this->addReference('vehicle', $vehicle);
    }

    public function getOrder()
    {
        return 5;
    }
}
