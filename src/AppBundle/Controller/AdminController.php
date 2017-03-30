<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/users", name="users")
     */
    public function usersAction()
    {
        $users = $this->getDoctrine()->getRepository(User::class)
            ->findBy([], ['username' => 'ASC']);

        return $this->render('AppBundle:Admin:users.html.twig', [
            'users' => $users
        ]);
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

        return $this->redirectToRoute('users');
    }

    /**
     * @Route("/add-user", name="add-user")
     */
    public function addUserAction(Request $request)
    {
        return $this->render('AppBundle:Admin:add_user.html.twig');
    }
}
