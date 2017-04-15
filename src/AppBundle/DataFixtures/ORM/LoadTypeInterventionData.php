<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\TypeIntervention;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadTypeInterventionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $mechanical = new TypeIntervention();
        $mechanical->setDenomination('Mécanique');
        $manager->persist($mechanical);

        $body = new TypeIntervention();
        $body->setDenomination('Carrosserie');
        $manager->persist($body);

        $inside = new TypeIntervention();
        $inside->setDenomination('Intérieur');
        $manager->persist($inside);

        $cleaning = new TypeIntervention();
        $cleaning->setDenomination('Nettoyage');
        $manager->persist($cleaning);

        $manager->flush();

        $this->addReference('mechanical', $mechanical);
        $this->addReference('body', $body);
        $this->addReference('inside', $inside);
        $this->addReference('cleaning', $cleaning);
    }

    public function getOrder()
    {
        return 1;
    }
}
