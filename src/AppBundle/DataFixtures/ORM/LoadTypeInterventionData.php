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
        $mechanical = (new TypeIntervention())
            ->setDenomination('Mécanique')
            ->setPriority(1)
            ->setTransition('to_mechanical');
        $manager->persist($mechanical);

        $bodywork = (new TypeIntervention())
            ->setDenomination('Carrosserie')
            ->setPriority(2)
            ->setTransition('to_bodywork');
        $manager->persist($bodywork);

        $cosmetic = (new TypeIntervention())
            ->setDenomination('Intérieur')
            ->setPriority(3)
            ->setTransition('to_cosmetic');
        $manager->persist($cosmetic);

        $cleaning = (new TypeIntervention())
            ->setDenomination('Nettoyage')
            ->setPriority(4)
            ->setTransition('to_cleaning');
        $manager->persist($cleaning);

        $manager->flush();

        $this->addReference('mechanical', $mechanical);
        $this->addReference('bodywork', $bodywork);
        $this->addReference('cosmetic', $cosmetic);
        $this->addReference('cleaning', $cleaning);
    }

    public function getOrder()
    {
        return 1;
    }
}
