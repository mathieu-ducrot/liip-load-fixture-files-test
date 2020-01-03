<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Condition;
use AppBundle\Entity\CriteriaInCondition;
use Tests\AppBundle\AbstractTestCase;

/**
 * Test Condition method
 *
 * vendor/bin/phpunit tests/AppBundle/Entity/ConditionTest.php
 */
class ConditionsTest extends AbstractTestCase
{
    public function testDummyLoadToCheckPurgeIdOnNextTest()
    {
        $this->loadFixtureFiles([
            __DIR__ . '/../fixtures/condition/condition_without_criteria.yml',
            __DIR__ . '/../fixtures/condition/condition_with_criteria.yml',
        ]);

        $em = $this->getEntityManager();
        $repository = $em->getRepository(Condition::class);
        $conditions = $repository->findAll();
        $this->assertEquals(3, count($conditions));
    }

    public function testGetCriteriaInCondition()
    {
        $this->loadFixtureFiles([
            __DIR__ . '/../fixtures/condition/condition_without_criteria.yml',
            __DIR__ . '/../fixtures/condition/condition_with_criteria.yml',
        ]);

        $em = $this->getEntityManager();
        $repository = $em->getRepository(Condition::class);
        /** @var Condition[] $conditions */
        $conditions = $repository->findAll();
        $this->assertEquals(3, count($conditions));
        $firstCondition = $conditions[0];
        $this->assertEquals(1, $firstCondition->getId());
        $this->assertEquals(3, count($em->getRepository(CriteriaInCondition::class)->findAll()));

        $expectedNbCriteria = 0;
        foreach ($conditions as $condition) {
            echo("\n");
            $nbCriteria = count($condition->getCriteriaInCondition());
            echo(sprintf(" - condition %s with %d criteria", $condition->getName(), $nbCriteria));
            if ($nbCriteria > 0) {
                foreach ($condition->getCriteriaInCondition() as $criteriaInCondition) {
                    echo(sprintf("\n -- criteria %s", $criteriaInCondition->getCriteria()->getData()));
                }
            }
            $this->assertEquals($expectedNbCriteria, $nbCriteria);
            $expectedNbCriteria++;
        }
    }
}
