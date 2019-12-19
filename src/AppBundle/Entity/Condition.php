<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="conditions")
 * @ORM\Entity()
 */
class Condition
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="CriteriaInCondition", mappedBy="condition")
     */
    private $criteriaInCondition;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->criteriaInCondition = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return ArrayCollection
     */
    public function getCriteriaInCondition()
    {
        return $this->criteriaInCondition;
    }

    /**
     * @param ArrayCollection $criteriaInCondition
     */
    public function setCriteriaInCondition($criteriaInCondition)
    {
        $this->criteriaInCondition = $criteriaInCondition;
    }
}