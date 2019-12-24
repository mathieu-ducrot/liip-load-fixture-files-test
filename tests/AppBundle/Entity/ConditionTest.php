<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Condition;
use Doctrine\ORM\EntityManager;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Test Condition method
 *
 * vendor/bin/phpunit tests/AppBundle/Entity/ConditionTest.php
 */
class ConditionsTest extends KernelTestCase
{
    /** @var EntityManager */
    private $entityManager;

    use FixturesTrait;

    /**
     * @return string
     */
    protected function getFixtureDir()
    {
        return 'tests/AppBundle/fixtures';
    }

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        $kernel = self::bootKernel();

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->loadFixtureFiles(array_reverse([
            $this->getFixtureDir() . '/condition/condition_without_criteria.yml',
            $this->getFixtureDir() . '/condition/condition_with_criteria.yml',
        ]));
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }

    public function testDummyLoadToCheckPurgeIdOnNextTest()
    {
        $repository = $this->entityManager->getRepository(Condition::class);
        $conditions = $repository->findAll();
        $this->assertEquals(3, count($conditions));
    }

    public function testGetCriteriaInCondition()
    {
        $repository = $this->entityManager->getRepository(Condition::class);
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
