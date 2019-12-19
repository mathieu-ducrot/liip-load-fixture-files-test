<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="criteria")
 * @ORM\Entity()
 */
class Criteria
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
     * @ORM\Column(name="data", type="string", length=255, nullable=false)
     */
    private $data;

    /**
     * @ORM\OneToMany(targetEntity="CriteriaInCondition", mappedBy="criteria")
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
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     */
    public function setData($data)
    {
        $this->data = $data;
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