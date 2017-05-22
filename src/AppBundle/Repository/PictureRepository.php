<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Vehicle;

/**
 * PictureRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PictureRepository extends \Doctrine\ORM\EntityRepository
{
    public function findForVehicle(Vehicle $vehicle)
    {
        return $this->createQueryBuilder('p')
            ->select('v.name')
            ->where('p.vehicle = :vehicle ')
            ->setParameter('vehicle', $vehicle)
            ->orderBy('p.id')
            ->getQuery()
            ->execute();
    }
}
