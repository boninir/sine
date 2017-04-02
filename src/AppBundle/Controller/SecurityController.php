<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\LoginType;
use AppBundle\Form\RegisterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends Controller
{
    /**
     * @Route(path="/register", name="register")
     * @Template
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles([User::ROLE_USER]);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            $this->get('session')->getFlashBag()->add('notice', "Votre compte a bien été créé");

            return $this->redirect($this->generateUrl('login'));
        }

        return ['form' => $form->createView()];
    }

    /**
     * @Route(path="/login", name="login")
     * @Template
     */
    public function loginAction(Request $request)
    {
        return [
            'form' => $this->createForm(LoginType::class)->createView(),
            'error' => $this->get('security.authentication_utils')->getLastAuthenticationError(),
        ];
    }
}
