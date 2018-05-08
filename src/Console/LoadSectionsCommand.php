<?php

namespace App\Console;

use App\Command\CreateSection;
use Broadway\CommandHandling\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class LoadSectionsCommand
 * @package App\Console
 */
class LoadSectionsCommand extends Command
{
    /**
     * @var array
     */
    const SECTIONS = [
        'SA-MI' => [
            'name'     => 'Salerno/Milano Centrale',
            'stations' => ['SA', 'NA', 'RM', 'FI', 'BO', 'MI'],
        ],
        'MI-SA' => [
            'name'     => 'Milano Centrale/Salerno',
            'stations' => ['MI', 'BO', 'FI', 'RM', 'NA', 'SA'],
        ],
        'VE-TO' => [
            'name'     => 'Venezia Mestre/Torino Porta Nuova',
            'stations' => ['VE', 'PD', 'VR', 'MI', 'TO'],
        ],
        'TO-VE' => [
            'name'     => 'Torino Porta Nuova/Venezia Mestre',
            'stations' => ['TO', 'MI', 'VR', 'PD', 'VE'],
        ],
        'BA-NA' => [
            'name'     => 'Bari Centrale/Napoli Centrale',
            'stations' => ['BA', 'FG', 'NA'],
        ],
        'NA-BA' => [
            'name'     => 'Napoli Centrale/Bari Centrale',
            'stations' => ['NA', 'FG', 'BA'],
        ],
        'PA-CT' => [
            'name'     => 'Palermo Centrale/Catania Centrale',
            'stations' => ['PA', 'ME', 'CT'],
        ],
        'CT-PA' => [
            'name'     => 'Catania Centrale/Palermo Centrale',
            'stations' => ['CT', 'ME', 'PA'],
        ],
        'BO-VR' => [
            'name'     => 'Bologna Centrale/Verona Porta Nuova',
            'stations' => ['BO', 'VR'],
        ],

        'VR-BO' => [
            'name'     => 'Verona Porta Nuova/Bologna Centrale',
            'stations' => ['VR', 'BO'],
        ],

        'VE-BO' => [
            'name'     => 'Venezia Mestre/Bologna Centrale',
            'stations' => ['VE', 'PD', 'BO'],
        ],

        'BO-VE' => [
            'name'     => 'Bologna Centrale/Venezia Mestre',
            'stations' => ['BO', 'PD', 'VE'],
        ],
    ];

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * LoadSectionsCommand constructor.
     *
     * @param CommandBus $commandBusservice
     */
    public function __construct(CommandBus $commandBusservice)
    {
        $this->commandBus = $commandBusservice;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('app:load:sections')
            ->setDescription('Load the railway network sections')
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
        foreach (self::SECTIONS as $code => $sections) {
            $this->commandBus->dispatch(
                new CreateSection(
                    $code,
                    $sections['name'],
                    $sections['stations']
                )
            );
        }

        $output->writeln('<info>All sections are imported</info>');
    }
}