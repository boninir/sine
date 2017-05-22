<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="transport")
 */

class Transport
{
    const STATE_ON_ROAD = 'onRoad';
    const STATE_ARRIVED = 'arrived';
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle")
     * @ORM\JoinColumn(name="vehicle1", nullable=true)
     */
    private $vehicle1;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle")
     * @ORM\JoinColumn(name="vehicle2", nullable=true)
     */
    private $vehicle2;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle")
     * @ORM\JoinColumn(name="vehicle3", nullable=true)
     */
    private $vehicle3;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle")
     * @ORM\JoinColumn(name="vehicle4", nullable=true)
     */
    private $vehicle4;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle")
     * @ORM\JoinColumn(name="vehicle5", nullable=true)
     */
    private $vehicle5;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle")
     * @ORM\JoinColumn(name="vehicle6", nullable=true)
     */
    private $vehicle6;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle")
     * @ORM\JoinColumn(name="vehicle7", nullable=true)
     */
    private $vehicle7;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle")
     * @ORM\JoinColumn(name="vehicle8", nullable=true)
     */
    private $vehicle8;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Vehicle")
     * @ORM\JoinColumn(name="vehicle9", nullable=true)
     */
    private $vehicle9;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=42)
     */
    private $state;

    public function __construct()
    {
        $this->state = self::STATE_ON_ROAD;
    }

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
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getVehicle1()
    {
        return $this->vehicle1;
    }

    /**
     * @param mixed $vehicle1
     */
    public function setVehicle1($vehicle1)
    {
        $this->vehicle1 = $vehicle1;
    }

    /**
     * @return mixed
     */
    public function getVehicle2()
    {
        return $this->vehicle2;
    }

    /**
     * @param mixed $vehicle2
     */
    public function setVehicle2($vehicle2)
    {
        $this->vehicle2 = $vehicle2;
    }

    /**
     * @return mixed
     */
    public function getVehicle3()
    {
        return $this->vehicle3;
    }

    /**
     * @param mixed $vehicle3
     */
    public function setVehicle3($vehicle3)
    {
        $this->vehicle3 = $vehicle3;
    }

    /**
     * @return mixed
     */
    public function getVehicle4()
    {
        return $this->vehicle4;
    }

    /**
     * @param mixed $vehicle4
     */
    public function setVehicle4($vehicle4)
    {
        $this->vehicle4 = $vehicle4;
    }

    /**
     * @return mixed
     */
    public function getVehicle5()
    {
        return $this->vehicle5;
    }

    /**
     * @param mixed $vehicle5
     */
    public function setVehicle5($vehicle5)
    {
        $this->vehicle5 = $vehicle5;
    }

    /**
     * @return mixed
     */
    public function getVehicle6()
    {
        return $this->vehicle6;
    }

    /**
     * @param mixed $vehicle6
     */
    public function setVehicle6($vehicle6)
    {
        $this->vehicle6 = $vehicle6;
    }

    /**
     * @return mixed
     */
    public function getVehicle7()
    {
        return $this->vehicle7;
    }

    /**
     * @param mixed $vehicle7
     */
    public function setVehicle7($vehicle7)
    {
        $this->vehicle7 = $vehicle7;
    }

    /**
     * @return mixed
     */
    public function getVehicle8()
    {
        return $this->vehicle8;
    }

    /**
     * @param mixed $vehicle8
     */
    public function setVehicle8($vehicle8)
    {
        $this->vehicle8 = $vehicle8;
    }

    /**
     * @return mixed
     */
    public function getVehicle9()
    {
        return $this->vehicle9;
    }

    /**
     * @param mixed $vehicle9
     */
    public function setVehicle9($vehicle9)
    {
        $this->vehicle9 = $vehicle9;
    }

    /**
     * @return mixed
     */
    public function getAllVehicle()
    {
        $tabVehicle = [];
        for($i=1;$i<9;$i++){
            if(isset($this->{'vehicle'.$i})){
                array_push($tabVehicle, $this->{'vehicle'.$i});
            }
        }
        return $tabVehicle;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }
    
}