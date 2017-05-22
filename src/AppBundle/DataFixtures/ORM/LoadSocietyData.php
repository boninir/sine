<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Society;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSocietyData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $society = (new Society())->setNom('Citroën')->setVille('Hellemes');
        $manager->persist($society);
        $manager->flush();

        $society = (new Society())->setNom('Citroën')->setVille('Roncq');
        $manager->persist($society);
        $manager->flush();

        $society = (new Society())->setNom('Citroën')->setVille('Fâches');
        $manager->persist($society);
        $manager->flush();

        $society = (new Society())->setNom('Citroën')->setVille('Lomme');
        $manager->persist($society);
        $manager->flush();

        $society = (new Society())->setNom('Peugeot')->setVille('Villeneuve D\'Ascq');
        $manager->persist($society);
        $manager->flush();

        $society = (new Society())->setNom('Peugeot')->setVille('Fâches');
        $manager->persist($society);
        $manager->flush();

        $society = (new Society())->setNom('Peugeot')->setVille('Roubaix');
        $manager->persist($society);
        $manager->flush();

        $society = (new Society())->setNom('Peugeot')->setVille('Roncq');
        $manager->persist($society);
        $manager->flush();
    }
    public function getOrder()
    {
        return 3;
    }



}
