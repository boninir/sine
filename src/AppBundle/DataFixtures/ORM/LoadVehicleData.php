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
            ->setRegistration('XR-404-ERR')
            ->setMark('Peugeot')
            ->setModel('307')
            ->setType('VO 0 KM')
            ->setCv(75)
            ->setFrame('AX100')
            ->setColor('Vert')
            ->setReleaseDate(new \DateTime('2016-08-08 00:00:00'))
            ->setKilometerTraveled(0)
            ->setKilometerOnCounter(0)
            ->setState("expertise")
        ;

        $manager->persist($vehicle);

        $manager->flush();

        $vehicle = (new Vehicle())
            ->setFuel($this->getReference('diesel'))
            ->setRegistration('XX420XX')
            ->setMark('Peugeot')
            ->setModel('3008')
            ->setType('VO 0 KM')
            ->setCv(130)
            ->setFrame('1xxxxxxxxxxxxxxxx1')
            ->setColor('Noir')
            ->setReleaseDate(new \DateTime('2016-08-08 00:00:00'))
            ->setKilometerTraveled(110)
            ->setKilometerOnCounter(110)
        ;

        $manager->persist($vehicle);

        $manager->flush();

        $vehicle = (new Vehicle())
            ->setFuel($this->getReference('gasoline'))
            ->setRegistration('XX421XX')
            ->setMark('Peugeot')
            ->setModel('308')
            ->setType('VO 0 KM')
            ->setCv(136)
            ->setFrame('1xxxxxxxaaxxxxxxx1')
            ->setColor('Noir')
            ->setReleaseDate(new \DateTime('2016-08-08 00:00:00'))
            ->setKilometerTraveled(1120)
            ->setKilometerOnCounter(1120)
            ->setState("validate")

        ;

        $manager->persist($vehicle);

        $manager->flush();

        $vehicle = (new Vehicle())
            ->setFuel($this->getReference('gasoline'))
            ->setRegistration('XX423XX')
            ->setMark('Peugeot')
            ->setModel('206')
            ->setType('VO 0 KM')
            ->setCv(90)
            ->setFrame('1xxxxxxxaaxxxxxxx1')
            ->setColor('Gris')
            ->setReleaseDate(new \DateTime('2016-08-08 00:00:00'))
            ->setKilometerTraveled(30000)
            ->setKilometerOnCounter(30000)
            ->setState("validate")
        ;

        $manager->persist($vehicle);

        $manager->flush();

        $vehicle = (new Vehicle())
            ->setFuel($this->getReference('gasoline'))
            ->setRegistration('XX424XX')
            ->setMark('Peugeot')
            ->setModel('RCZ')
            ->setType('VO 0 KM')
            ->setCv(250)
            ->setFrame('1xxxxxxxaaxxxxxxx1')
            ->setColor('Rouge')
            ->setReleaseDate(new \DateTime('2016-08-08 00:00:00'))
            ->setKilometerTraveled(500)
            ->setKilometerOnCounter(500)
        ;

        $manager->persist($vehicle);

        $manager->flush();

        $vehicle = (new Vehicle())
            ->setFuel($this->getReference('diesel'))
            ->setRegistration('XX412XX')
            ->setMark('Citroën')
            ->setModel('C4 Picasso')
            ->setType('VO 0 KM')
            ->setCv(110)
            ->setFrame('1xxxxxxxaaxxxxxxx1')
            ->setColor('Noir')
            ->setReleaseDate(new \DateTime('2016-08-08 00:00:00'))
            ->setKilometerTraveled(11200)
            ->setKilometerOnCounter(11200)
            ->setState("validate")
        ;

        $manager->persist($vehicle);

        $manager->flush();

        $vehicle = (new Vehicle())
            ->setFuel($this->getReference('diesel'))
            ->setRegistration('XX427XX')
            ->setMark('Citroën')
            ->setModel('C3')
            ->setType('VO 0 KM')
            ->setCv(110)
            ->setFrame('1xxxxxxxaaxxxxxxx1')
            ->setColor('Noir')
            ->setReleaseDate(new \DateTime('2016-08-08 00:00:00'))
            ->setKilometerTraveled(11200)
            ->setKilometerOnCounter(11200)
            ->setState("expertise")
        ;

        $manager->persist($vehicle);

        $manager->flush();

        $vehicle = (new Vehicle())
            ->setFuel($this->getReference('diesel'))
            ->setRegistration('XX426XX')
            ->setMark('Citroën')
            ->setModel('DS')
            ->setType('VO 0 KM')
            ->setCv(150)
            ->setFrame('1xxxxxxxaaxxxxxxx1')
            ->setColor('Noir')
            ->setReleaseDate(new \DateTime('2016-08-08 00:00:00'))
            ->setKilometerTraveled(1000)
            ->setKilometerOnCounter(1000)
            ->setState("expertise")
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
