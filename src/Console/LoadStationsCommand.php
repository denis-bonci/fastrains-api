<?php

namespace App\Console;

use App\Command\CreateStation;
use Broadway\CommandHandling\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class LoadStationsCommand
 * @package App\Console
 */
class LoadStationsCommand extends Command
{
    /**
     * @var array
     */
    const STATIONS = [
        'TO' => [
            'name'            => 'Torino Porta Nuova',
            'latitude'        => 45.06141,
            'longitude'       => 7.67804,
            'linked_stations' => ['MI'],
        ],
        'MI' => [
            'name'            => 'Milano Centrale',
            'latitude'        => 45.48592,
            'longitude'       => 9.2041,
            'linked_stations' => ['TO', 'VR', 'BO'],
        ],
        'VR' => [
            'name'            => 'Verona Porta Nuova',
            'latitude'        => 45.42909,
            'longitude'       => 10.98229,
            'linked_stations' => ['MI', 'BO', 'PD'],
        ],
        'VE' => [
            'name'            => 'Venezia Mestre',
            'latitude'        => 45.48183,
            'longitude'       => 12.23345,
            'linked_stations' => ['PD'],
        ],
        'PD' => [
            'name'            => 'Padova',
            'latitude'        => 45.41738,
            'longitude'       => 11.88025,
            'linked_stations' => ['VE', 'VR', 'BO'],
        ],
        'BO' => [
            'name'            => 'Bologna Centrale',
            'latitude'        => 44.50593,
            'longitude'       => 11.34295,
            'linked_stations' => ['FI', 'MI', 'VR', 'PD'],
        ],
        'FI' => [
            'name'            => 'Firenze Santa Maria Novella',
            'latitude'        => 43.77642,
            'longitude'       => 11.24785,
            'linked_stations' => ['BO', 'RM'],
        ],
        'RM' => [
            'name'            => 'Roma Termini',
            'latitude'        => 41.9001,
            'longitude'       => 12.5036,
            'linked_stations' => ['FI', 'NA'],
        ],
        'BA' => [
            'name'            => 'Bari Centrale',
            'latitude'        => 41.11745,
            'longitude'       => 16.86899,
            'linked_stations' => ['FG'],
        ],
        'FG' => [
            'name'            => 'Foggia',
            'latitude'        => 41.46601,
            'longitude'       => 15.55608,
            'linked_stations' => ['BA', 'NA'],
        ],
        'NA' => [
            'name'            => 'Napoli Centrale',
            'latitude'        => 40.85295,
            'longitude'       => 14.27313,
            'linked_stations' => ['RM', 'FG', 'SA'],
        ],
        'SA' => [
            'name'            => 'Salerno',
            'latitude'        => 40.67538,
            'longitude'       => 14.77241,
            'linked_stations' => ['NA'],
        ],
        'PA' => [
            'name'            => 'Palermo Centrale',
            'latitude'        => 38.10772,
            'longitude'       => 13.36912,
            'linked_stations' => ['ME'],
        ],
        'CT' => [
            'name'            => 'Catania Centrale',
            'latitude'        => 37.50683,
            'longitude'       => 15.10165,
            'linked_stations' => ['ME'],
        ],
        'ME' => [
            'name'            => 'Messina Centrale',
            'latitude'        => 38.18333,
            'longitude'       => 15.56667,
            'linked_stations' => ['PA', 'CT'],
        ],
    ];

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * LoadStationsCommand constructor.
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
            ->setName('app:load:stations')
            ->setDescription('Load the railway network stations')
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
        foreach (self::STATIONS as $code => $station) {
            $this->commandBus->dispatch(
                new CreateStation(
                    $code,
                    $station['name'],
                    $station['latitude'],
                    $station['longitude'],
                    $station['linked_stations']
                )
            );
        }

        $output->writeln('<info>All stations are imported</info>');
    }
}