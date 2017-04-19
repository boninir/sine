<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypeIntervention
 *
 * @ORM\Table(name="type_intervention")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TypeInterventionRepository")
 */
class TypeIntervention
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
     * @ORM\Column(name="denomination", type="string", length=100, unique=true)
     */
    private $denomination;

    /**
     * @var priority
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority;

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
     * Set denomination
     *
     * @param string $denomination
     *
     * @return TypeIntervention
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
     * @return priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param priority $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }
}

