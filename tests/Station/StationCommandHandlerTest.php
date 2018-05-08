<?php

namespace App\Tests\Station;

use App\AppRepository;
use App\Command\CreateStation;
use App\Event\StationWasCreated;
use App\Station\StationCommandHandler;
use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;

/**
 * Class StationCommandHandlerTest
 * @package App\Tests\Station
 */
class StationCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    /**
     * Create a command handler for the given scenario test case.
     *
     * @param EventStore $eventStore
     * @param EventBus   $eventBus
     *
     * @return CommandHandler
     */
    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new StationCommandHandler(
            new AppRepository($eventStore, $eventBus, 'App\Station\Station')
        );
    }

    /**
     * @test
     */
    public function itHandleCreateStationCommand()
    {
        $id = 'QH';
        $name = 'Quahog';
        $latitude = 43.34;
        $longitude = 15.51;
        $linkedStations = ['AA', 'BB', 'CC'];

        $this->scenario
            ->when(new CreateStation(
                $id,
                $name,
                $latitude,
                $longitude,
                $linkedStations
            ))
            ->then([
                new StationWasCreated(
                    $id,
                    $name,
                    $latitude,
                    $longitude,
                    $linkedStations
                )
            ]);
    }
}
