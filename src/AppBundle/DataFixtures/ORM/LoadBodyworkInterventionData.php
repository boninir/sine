<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Intervention;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBodyworkInterventionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $type = $this->getReference('bodywork');

        $intervention1 = (new Intervention())
            ->setDenomination('PC AV')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Raccord gauche',
                'Raccord droit',
                'Tôlerie',
                'Peinture pc',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention1);

        $intervention2 = (new Intervention())
            ->setDenomination('PC AR')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Raccord gauche',
                'Raccord droit',
                'Tôlerie',
                'Peinture pc',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention2);

        $intervention3 = (new Intervention())
            ->setDenomination('Capôt')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Tôlerie',
                'Peinture',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention3);

        $intervention4 = (new Intervention())
            ->setDenomination('Aile AV gauche')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Raccord',
                'Tôlerie',
                'Peinture',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention4);


        $intervention5 = (new Intervention())
            ->setDenomination('Aile AV droite')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Raccord',
                'Tôlerie',
                'Peinture',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention5);

        $intervention6 = (new Intervention())
            ->setDenomination('Porte AV gauche')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Raccord',
                'Tôlerie',
                'Peinture',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention6);

        $intervention7 = (new Intervention())
            ->setDenomination('Porte AV droite')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Raccord',
                'Tôlerie',
                'Peinture',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention7);

        $intervention8 = (new Intervention())
            ->setDenomination('Aile AR gauche')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Raccord',
                'Tôlerie',
                'Peinture',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention8);

        $intervention9 = (new Intervention())
            ->setDenomination('Aile AR droite')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Raccord',
                'Tôlerie',
                'Peinture',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention9);

        $intervention10 = (new Intervention())
            ->setDenomination('Porte AR gauche')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Raccord',
                'Tôlerie',
                'Peinture',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention10);

        $intervention11 = (new Intervention())
            ->setDenomination('Porte AR droite')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Raccord',
                'Tôlerie',
                'Peinture',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention11);

        $intervention12 = (new Intervention())
            ->setDenomination('Coffre')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Raccord',
                'Tôlerie',
                'Peinture',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention12);

        $intervention13 = (new Intervention())
            ->setDenomination('Toit')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Raccord',
                'Tôlerie',
                'Peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention13);

        $intervention14 = (new Intervention())
            ->setDenomination('Bas de caisse gauche')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Tôlerie',
                'Peinture',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention14);

        $intervention15 = (new Intervention())
            ->setDenomination('Bas de caisse droit')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Tôlerie',
                'Peinture',
                'Redressage + peinture',
                'Changer + peinture',
                'Non',
            ])
        ;
        $manager->persist($intervention15);

        $intervention16 = (new Intervention())
            ->setDenomination('Optique AV')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Gauche OK',
                'Gauche à changer',
                'Droit OK',
                'Droit à changer',
            ])
        ;
        $manager->persist($intervention16);

        $intervention17 = (new Intervention())
            ->setDenomination('Optique AR')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'Gauche OK',
                'Gauche à changer',
                'Droit OK',
                'Droit à changer',
            ])
        ;
        $manager->persist($intervention17);

        $intervention18 = (new Intervention())
            ->setDenomination('Bas de caisse droit')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'OK',
                'Réparation impact',
                'À changer',
            ])
        ;
        $manager->persist($intervention18);

        $intervention19 = (new Intervention())
            ->setDenomination('Réparation jante alu')
            ->setTypeIntervention($type)
            ->setRequired(1)
            ->setAnswers([
                'AV droite',
                'AV gauche',
                'AR droit',
                'AR gauche',
            ])
        ;
        $manager->persist($intervention19);

        $manager->flush();
    }

    public function getOrder()
    {
        return 4;
    }
}
