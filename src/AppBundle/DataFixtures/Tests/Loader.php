<?php

namespace AppBundle\DataFixtures\Tests;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;
use Symfony\Bridge\Doctrine\Tests\Fixtures\ContainerAwareFixture;

class Loader extends ContainerAwareFixture implements FixtureInterface
{
    /**
     * @var string
     */
    private $fixturesDir;

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->fixturesDir = 'tests/AppBundle/fixtures';

        Fixtures::load($this->getFiles(), $manager);
    }

    /**
     * @return array
     */
    protected function getFiles()
    {
        $pattern = $this->fixturesDir . '/%s.yml';

        return [
            sprintf($pattern, 'condition/condition_without_criteria'),
            sprintf($pattern, 'condition/condition_with_criteria'),
        ];
    }
}
