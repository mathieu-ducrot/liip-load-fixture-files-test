<?php

namespace AppBundle\Command;

use AppBundle\Entity\Condition;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * app/console entity:test
 */
class EntityTestCommand extends ContainerAwareCommand
{
    const NB_CONDITION_FROM_FIXTURES = 3;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('entity:test')
            ->setDescription('Test entity association')
        ;
    }

    /**
     * @return ObjectManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Test entity association</info>\n");

        $conditions = $this->getManager()->getRepository(Condition::class)->findAll();
        $nbConditions = count($conditions);
        if ($nbConditions != self::NB_CONDITION_FROM_FIXTURES) {
            $output->writeln("<error>You forget to run make orm.load-test</error>\n");
            exit;
        }
        $output->writeln(sprintf("%d conditions loaded\n", $nbConditions));
        foreach ($conditions as $condition) {
            $nbCriteria = count($condition->getCriteriaInConditions());
            $output->writeln(sprintf(" - condition %s with %d criteria", $condition->getName(), $nbCriteria));
            if ($nbCriteria > 0) {
                foreach ($condition->getCriteriaInConditions() as $criteriaInCondition) {
                    $output->writeln(sprintf(" -- criteria %s", $criteriaInCondition->getCriteria()->getData()));
                }
            }
            $output->writeln('');
        }
    }
}
