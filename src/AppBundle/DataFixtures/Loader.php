<?php

namespace AppBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bridge\Doctrine\Tests\Fixtures\ContainerAwareFixture;

class Loader extends ContainerAwareFixture implements ORMFixtureInterface
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

        $loader = $this->container->get('fidry_alice_data_fixtures.loader.doctrine');
        $loader->load($this->getFiles());
    }

    /**
     * @return array
     */
    protected function getFiles()
    {
        $pattern = $this->fixturesDir . '/%s.yml';

        return array_reverse([
            sprintf($pattern, 'condition/condition_without_criteria'),
            sprintf($pattern, 'condition/condition_with_criteria'),
        ]);
    }
}
