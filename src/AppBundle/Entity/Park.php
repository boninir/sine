<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="park")
 */
class Park
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var int
     *
     * @ORM\Column(name="ligne", type="integer", nullable=true)
     */
    private $ligne;

    /**
     * @var int
     *
     * @ORM\Column(name="colonne", type="integer", nullable=true)
     */
    private $colonne;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle")
     * @ORM\JoinColumn(nullable=true)
     */
    private $vehicle;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getLigne()
    {
        return $this->ligne;
    }

    /**
     * @param int $ligne
     */
    public function setLigne($ligne)
    {
        $this->ligne = $ligne;
    }

    /**
     * @return int
     */
    public function getColonne()
    {
        return $this->colonne;
    }

    /**
     * @param int $colonne
     */
    public function setColonne($colonne)
    {
        $this->colonne = $colonne;
    }

    /**
     * @return mixed
     */
    public function getVehicle()
    {
        return $this->vehicle;
    }

    /**
     * @param mixed $vehicle
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;
    }
    
    
}