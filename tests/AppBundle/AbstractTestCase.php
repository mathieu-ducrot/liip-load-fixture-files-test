<?php

namespace Tests\AppBundle;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Fidry\AliceDataFixtures\LoaderInterface;
use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    /**
     * @var \AppKernel
     */
    protected $kernel;

    /**
     * @var LoaderInterface
     */
    protected $loader;

    /**
     * @var Registry
     */
    protected $doctrine;

    /**
     * @inheritdoc
     */
    public function setUp()
    {
        $this->kernel = new \AppKernel('test', true);
        $this->kernel->boot();

        $this->loader = $this->kernel->getContainer()->get('fidry_alice_data_fixtures.loader.doctrine');
        $this->doctrine = $this->kernel->getContainer()->get('doctrine');

        $connection = $this->doctrine->getConnection();

        // With MySQL:
        $connection->executeQuery('ALTER TABLE conditions AUTO_INCREMENT = 1');

        // Related to the possible failures - see the comment above, you might want to empty some tables here as well.
        // Maybe by using the purger like in the example above? Up to you.
        // It is also a good practice to clear all the repositories. How you collect all of the repositories: leveraging
        // the framework or manually is up to you.

        $connection->beginTransaction();
    }

    public function tearDown()
    {
        $this->doctrine->getConnection('default')->rollBack();

        $this->kernel->shutdown();
        $this->kernel = null;
    }

    protected function loadFixtureFiles(array $files)
    {
        $this->loader->load($files);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    protected function getEntityManager()
    {
        return $this->doctrine->getManager();
    }

    protected function getContainer()
    {
        return $this->kernel->getContainer();
    }
}
