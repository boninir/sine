<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractFixture implements ContainerAwareInterface
{
    private $container;

    public function load(ObjectManager $manager)
    {
        $encoder = $this->container->get('security.password_encoder');

        $user = new User();
        $user->setUsername('user');
        $user->setPassword($encoder->encodePassword($user, 'user'));
        $user->setMail('user@sineo.fr');
        $user->setRoles([User::ROLE_USER]);

        $expert = new User();
        $expert->setUsername('expert');
        $expert->setPassword($encoder->encodePassword($expert, 'expert'));
        $expert->setMail('expert@sineo.fr');
        $expert->setRoles([User::ROLE_EXPERT]);

        $subcontractor = new User();
        $subcontractor->setUsername('subcontractor');
        $subcontractor->setPassword($encoder->encodePassword($subcontractor, 'subcontractor'));
        $subcontractor->setMail('subcontractor@sineo.fr');
        $subcontractor->setRoles([User::ROLE_SUBCONTRACTOR]);

        $mechanician = new User();
        $mechanician->setUsername('mechanician');
        $mechanician->setPassword($encoder->encodePassword($mechanician, 'mechanician'));
        $mechanician->setMail('mechanician@sineo.fr');
        $mechanician->setRoles([User::ROLE_MECHANICIAN]);

        $bodybuilder = new User();
        $bodybuilder->setUsername('bodybuilder');
        $bodybuilder->setPassword($encoder->encodePassword($bodybuilder, 'bodybuilder'));
        $bodybuilder->setMail('bodybuilder@sineo.fr');
        $bodybuilder->setRoles([User::ROLE_BODYBUILDER]);

        $painter = new User();
        $painter->setUsername('painter');
        $painter->setPassword($encoder->encodePassword($painter, 'painter'));
        $painter->setMail('painter@sineo.fr');
        $painter->setRoles([User::ROLE_PAINTER]);

        $cleaner = new User();
        $cleaner->setUsername('cleaner');
        $cleaner->setPassword($encoder->encodePassword($cleaner, 'cleaner'));
        $cleaner->setMail('cleaner@sineo.fr');
        $cleaner->setRoles([User::ROLE_CLEANER]);

        $admin = new User();
        $admin->setUsername('admin');
        $admin->setPassword($encoder->encodePassword($admin, 'admin'));
        $admin->setMail('admin@sineo.fr');
        $admin->setRoles([User::ROLE_ADMIN]);

        $manager->persist($user);
        $manager->persist($expert);
        $manager->persist($subcontractor);
        $manager->persist($mechanician);
        $manager->persist($bodybuilder);
        $manager->persist($painter);
        $manager->persist($cleaner);
        $manager->persist($admin);

        $manager->flush();
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
}
