<?php

namespace App\Console;

use MongoDB\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SetupCommand
 * @package App\Console
 */
class SetupCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:setup')
            ->setDescription('App Setup')
            ;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $db = new Client(getenv('MONGODB_URL'));
        $db->dropDatabase(getenv('MONGODB_DB'));

        $this->getApplication()->find('app:load:stations')->run($input, $output);
        $this->getApplication()->find('app:load:sections')->run($input, $output);

        $output->writeln('<info>Setup completed</info>');
    }
}