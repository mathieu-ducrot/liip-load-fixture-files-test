<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $criteriaInConditions;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->criteriaInConditions = new ArrayCollection();
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
     * @return Collection
     */
    public function getCriteriaInConditions(): Collection
    {
        return $this->criteriaInConditions;
    }

    /**
     * @param ArrayCollection $criteriaInConditions
     */
    public function setCriteriaInConditions(ArrayCollection $criteriaInConditions): void
    {
        $this->criteriaInConditions = $criteriaInConditions;
    }

    public function addCriteriaInCondition(CriteriaInCondition $criteriaInCondition)
    {
        if (!$this->criteriaInConditions->contains($criteriaInCondition)) {
            $this->criteriaInConditions->add($criteriaInCondition);
        }
    }
}
