<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\RegisterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/users", name="users")
     * @Template
     */
    public function usersAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)
            ->findBy([], ['username' => 'ASC']);

        return ['users' => $users];
    }

    /**
     * @Route("/delete-user/{id}", name="delete-user")
     */
    public function deleteUserAction($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $user = $manager->getRepository(User::class)
            ->find($id);

        $manager->remove($user);
        $manager->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            "Le compte a bien été supprimé."
        );

        return $this->redirectToRoute('users');
    }

    /**
     * @Route("/add-user", name="add-user")
     * @Template
     */
    public function addUserAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                "Le compte a bien été créé."
            );

            return $this->redirect($this->generateUrl('users'));
        }

        return ['form' => $form->createView()];
    }
}
