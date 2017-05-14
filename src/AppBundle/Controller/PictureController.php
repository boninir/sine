<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends Controller
{
    /**
     * @Route(path="/delete-picture/{id}", name="delete-picture")
     */
    public function deleteAction(Picture $picture)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($picture);
        $em->flush();

        $this->addFlash(
            'notice',
            'La photo a bien été supprimée'
        );

        return $this->redirectToRoute('expertise', ['id' => $picture->getVehicle()->getId()]);
    }
}