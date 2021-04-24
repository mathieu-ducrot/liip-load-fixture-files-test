<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="criteria_in_condition")
 * @ORM\Entity()
 */
class CriteriaInCondition
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_cc", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="operator", type="string", length=2, nullable=true)
     */
    private $operator;

    /**
     * @var float
     *
     * @ORM\Column(name="value", type="float", precision=10, scale=0, nullable=true)
     */
    private $value;

    /**
     * @var Condition
     *
     * @ORM\ManyToOne(targetEntity="Condition", inversedBy="criteriaInCondition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_condition", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $condition;

    /**
     * @var Criteria
     *
     * @ORM\ManyToOne(targetEntity="Criteria", inversedBy="criteriaInCondition")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_critere", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     * })
     */
    private $criteria;

    /**
     * @return Criteria
     */
    public function getCriteria()
    {
        return $this->criteria;
    }

    /**
     * @param Criteria $criteria
     */
    public function setCriteria($criteria)
    {
        $this->criteria = $criteria;
    }

    /**
     * @return Condition
     */
    public function getCondition(): Condition
    {
        return $this->condition;
    }

    /**
     * @param Condition $condition
     */
    public function setCondition(Condition $condition): void
    {
        $condition->addCriteriaInCondition($this);
        $this->condition = $condition;
    }
}
