<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Picture
 *
 * @ORM\Table(name="picture")
 * @ORM\Entity
 */
class Picture
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeIntervention")
     */
    private $typeIntervention;

    public function __construct()
    {
        $this->creationDate = new \Datetime();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     *
     * @return mixed
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
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
     *
     * @return mixed
     */
    public function setVehicle($vehicle)
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypeIntervention()
    {
        return $this->typeIntervention;
    }

    /**
     * @param mixed $typeIntervention
     *
     * @return mixed
     */
    public function setTypeIntervention($typeIntervention)
    {
        $this->typeIntervention = $typeIntervention;

        return $this;
    }
}
