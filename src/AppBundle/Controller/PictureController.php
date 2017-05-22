<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Picture;
use AppBundle\Repository\PictureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
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
    
    /**
     * @Route(path="/add-picture/{id}", name="add-picture")
     */
    public function addAction(){
        $em = $this -> getDoctrine() -> getManager() -> getRepository(Picture::class);

       $picture = (new Picture())
            ->setName(sprintf('%s.%s', md5(uniqid()), $file->guessExtension()))
            ->setVehicle($vehicle);

        $em->persist($picture);

        $file->move(
            sprintf('vehicle-pictures/%d', $vehicle->getId()),
            $picture->getName()
        );
        return new response('', 200);
    }
}