<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Society;
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
        $form = $this->createForm(RegisterType::class);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            $user = new User();
            $society = new Society();

            $passwordEncoded = $this->get('security.password_encoder')->encodePassword($user, $data['plainPassword']);

            $society->setNom($data['societyName'])->setVille($data['societyCity']);

            $user->setUsername($data['username'])->setMail($data['mail'])->setRoles($data['roles'])->setSociety($society)->setPassword($passwordEncoded);

            $em = $this->getDoctrine()->getManager();
            $em->persist($society);
            $em->persist($user);
            $em->flush();

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
