<?php

namespace AppBundle\Tests\Entity;

use AppBundle\Entity\Condition;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Test Condition method
 *
 * bin/phpunit -c app/ src/AppBundle/Tests/Entity/ConditionTest.php
 */
class ConditionsTest extends WebTestCase
{
    /**
     * @return string
     */
    protected function getFixtureDir()
    {
        return 'src/AppBundle/Tests/fixtures';
    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $this->loadFixtureFiles(
            [
                $this->getFixtureDir() . '/condition/condition_without_criteria.yml',
                $this->getFixtureDir() . '/condition/condition_with_criteria.yml',
            ],
            false,
            null,
            'doctrine',
            ORMPurger::PURGE_MODE_TRUNCATE
        );
    }

    public function testGetCriteriaInCondition()
    {
        $repository = $this->getContainer()->get('doctrine')->getRepository(Condition::class);
        $conditions = $repository->findAll();
        $this->assertEquals(3, count($conditions));

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
