<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Vehicle
 *
 * @ORM\Table(name="vehicle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\VehicleRepository")
 */
class Vehicle
{
    const STATE_EXPERTISE = 'expertise';
    const STATE_CONTROL = 'control';

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
     * @ORM\Column(name="registration", type="string", length=20, unique=true)
     */
    private $registration;

    /**
     * @var string
     *
     * @ORM\Column(name="mark", type="string", length=50)
     */
    private $mark;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=50)
     */
    private $model;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="cv", type="integer", nullable=true)
     */
    private $cv;

    /**
     * @var string
     *
     * @ORM\Column(name="frame", type="string", length=30, nullable=true)
     */
    private $frame;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=50, nullable=true)
     */
    private $color;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="releaseDate", type="datetime", nullable=true)
     */
    private $releaseDate;

    /**
     * @var int
     *
     * @ORM\Column(name="kilometerTraveled", type="integer", nullable=true)
     */
    private $kilometerTraveled;

    /**
     * @var int
     *
     * @ORM\Column(name="kilometerOnCounter", type="integer", nullable=true)
     */
    private $kilometerOnCounter;

    /**
     * @var int
     *
     * @ORM\Column(name="sapVoucher", type="integer", nullable=true)
     */
    private $sapVoucher;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="json_array", nullable=true)
     */
    private $state;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Fuel")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fuel;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\VehicleIntervention", mappedBy="vehicle")
     * @ORM\JoinColumn(nullable=false)
     */
    private $interventions;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Picture", mappedBy="vehicle")
     * @ORM\JoinColumn(nullable=false)
     */
    private $pictures;


    public function __construct()
    {
        $this->creationDate = new \Datetime();
        $this->state = self::STATE_EXPERTISE;
        $this->interventions = new ArrayCollection();
        $this->pictures = new ArrayCollection();
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
     * Set registration
     *
     * @param string $registration
     *
     * @return Vehicle
     */
    public function setRegistration($registration)
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * Get registration
     *
     * @return string
     */
    public function getRegistration()
    {
        return $this->registration;
    }

    /**
     * Set mark
     *
     * @param string $mark
     *
     * @return Vehicle
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return string
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Vehicle
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Vehicle
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set cv
     *
     * @param integer $cv
     *
     * @return Vehicle
     */
    public function setCv($cv)
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * Get cv
     *
     * @return int
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * Set frame
     *
     * @param string $frame
     *
     * @return Vehicle
     */
    public function setFrame($frame)
    {
        $this->frame = $frame;

        return $this;
    }

    /**
     * Get frame
     *
     * @return string
     */
    public function getFrame()
    {
        return $this->frame;
    }

    /**
     * Set color
     *
     * @param string $color
     *
     * @return Vehicle
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Vehicle
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set kilometerTraveled
     *
     * @param integer $kilometerTraveled
     *
     * @return Vehicle
     */
    public function setKilometerTraveled($kilometerTraveled)
    {
        $this->kilometerTraveled = $kilometerTraveled;

        return $this;
    }

    /**
     * Get kilometerTraveled
     *
     * @return int
     */
    public function getKilometerTraveled()
    {
        return $this->kilometerTraveled;
    }

    /**
     * Set kilometerOnCounter
     *
     * @param integer $kilometerOnCounter
     *
     * @return Vehicle
     */
    public function setKilometerOnCounter($kilometerOnCounter)
    {
        $this->kilometerOnCounter = $kilometerOnCounter;

        return $this;
    }

    /**
     * Get kilometerOnCounter
     *
     * @return int
     */
    public function getKilometerOnCounter()
    {
        return $this->kilometerOnCounter;
    }

    /**
     * Set sapVoucher
     *
     * @param integer $sapVoucher
     *
     * @return Vehicle
     */
    public function setSapVoucher($sapVoucher)
    {
        $this->sapVoucher = $sapVoucher;

        return $this;
    }

    /**
     * Get sapVoucher
     *
     * @return int
     */
    public function getSapVoucher()
    {
        return $this->sapVoucher;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFuel()
    {
        return $this->fuel;
    }

    /**
     * @param mixed $fuel
     *
     * @return Vehicle
     */
    public function setFuel($fuel)
    {
        $this->fuel = $fuel;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getInterventions()
    {
        return $this->interventions;
    }

    /**
     * @return mixed
     */
    public function setInterventions($interventions)
    {
        $this->interventions = $interventions;
    }

    /**
     * @param Intervention $intervention
     *
     * @return mixed
     */
    public function addIntervention(Intervention $intervention)
    {
        $this->interventions[] = $intervention;

        return $this;
    }

    /**
     * @param Intervention $intervention
     *
     * @return mixed
     */
    public function removeIntervention(Intervention $intervention)
    {
        $this->interventions->removeElement($intervention);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPictures()
    {
        return $this->pictures;
    }

    /**
     * @return mixed
     */
    public function setPictures($pictures)
    {
        $this->pictures = $pictures;
    }

    /**
     * @param Picture $picture
     *
     * @return mixed
     */
    public function addPicture(Picture $picture)
    {
        $this->pictures[] = $picture;

        return $this;
    }

    /**
     * @param Picture $picture
     *
     * @return mixed
     */
    public function removePicture(Picture $picture)
    {
        $this->pictures->removeElement($picture);

        return $this;
    }
}
