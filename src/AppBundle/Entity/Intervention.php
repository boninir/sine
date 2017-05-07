<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Intervention
 *
 * @ORM\Table(name="intervention")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\InterventionRepository")
 */
class Intervention
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
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\TypeIntervention")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeIntervention;

    /**
     * @var string
     *
     * @ORM\Column(name="denomination", type="string", length=255)
     */
    private $denomination;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     */
    private $creationDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="required", type="boolean")
     */
    private $required;

    /**
     * @var array
     *
     * @ORM\Column(name="answers", type="array", nullable=true)
     */
    private $answers;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\VehicleIntervention", mappedBy="intervention")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicleInterventions;


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
    public function getTypeIntervention()
    {
        return $this->typeIntervention;
    }

    /**
     * @param mixed $typeIntervention
     *
     * @return Intervention
     */
    public function setTypeIntervention($typeIntervention)
    {
        $this->typeIntervention = $typeIntervention;

        return $this;
    }

    /**
     * Set denomination
     *
     * @param string $denomination
     *
     * @return Intervention
     */
    public function setDenomination($denomination)
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * Get denomination
     *
     * @return string
     */
    public function getDenomination()
    {
        return $this->denomination;
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

        return $this;
    }

    /**
     * @return boolean
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param boolean $required
     */
    public function setRequired($required)
    {
        $this->required = $required;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * @param mixed $answers
     *
     * @return VehicleIntervention
     */
    public function setAnswers($answers)
    {
        $this->answers = $answers;

        return $this;
    }
}

