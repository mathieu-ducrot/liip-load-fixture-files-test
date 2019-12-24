<?php

namespace Tests\AppBundle\Entity;

use AppBundle\DataFixtures\Tests\Loader;
use AppBundle\Entity\Condition;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Test Condition method
 *
 * vendor/bin/phpunit tests/AppBundle/Entity/ConditionTest.php
 */
class ConditionsTest extends WebTestCase
{
    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->loadFixtures([Loader::class], null, 'doctrine', ORMPurger::PURGE_MODE_TRUNCATE);
    }

    public function testGetCriteriaInCondition()
    {
        $repository = $this->getContainer()->get('doctrine')->getRepository(Condition::class);
        $conditions = $repository->findAll();
        $this->assertEquals(3, count($conditions));
        $firstCondition = $conditions[0];
        $this->assertEquals(1, $firstCondition->getId());

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
