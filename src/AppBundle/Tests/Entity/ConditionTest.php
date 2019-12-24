<?php

namespace AppBundle\Tests\Entity;

use AppBundle\DataFixtures\Tests\Loader;
use AppBundle\Entity\Condition;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Doctrine\ORM\Tools\SchemaTool;
use Liip\FunctionalTestBundle\Test\WebTestCase;

/**
 * Test Condition method
 *
 * bin/phpunit -c app/ src/AppBundle/Tests/Entity/ConditionTest.php
 */
class ConditionsTest extends WebTestCase
{
    /** @var SchemaTool */
    protected $schemaTool = null;
    /** @var ClassMetadata[]|null */
    protected $metadatas = null;

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
        if ($this->schemaTool == null) {
            $em = $this->getContainer()->get('doctrine')->getManager();
            $this->metadatas = $em->getMetadataFactory()->getAllMetadata();
            $this->schemaTool = new SchemaTool($em);
        }

        $this->schemaTool->dropDatabase();
        $this->schemaTool->createSchema($this->metadatas);
        $this->postFixtureSetup();

        $this->loadFixtures([Loader::class]);
    }

    public function testDummyLoadToCheckPurgeIdOnNextTest()
    {
        $repository = $this->getContainer()->get('doctrine')->getRepository(Condition::class);
        $conditions = $repository->findAll();
        $this->assertEquals(3, count($conditions));
    }

    public function testGetCriteriaInCondition()
    {
        $repository = $this->getContainer()->get('doctrine')->getRepository(Condition::class);
        /** @var Condition[] $conditions */
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
