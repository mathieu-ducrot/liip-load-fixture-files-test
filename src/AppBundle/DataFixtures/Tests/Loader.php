<?php

namespace AppBundle\DataFixtures\Tests;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
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

        $this->container->get('fidry_alice_data_fixtures.loader.doctrine')->load($this->getFiles());
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
