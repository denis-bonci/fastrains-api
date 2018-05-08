<?php

namespace App\Tests\ReadModel;

use App\Event\StationWasCreated;
use App\ReadModel\Station;
use App\ReadModel\StationProjector;
use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;

class StationProjectorTest extends ProjectorScenarioTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createProjector(InMemoryRepository $repository): Projector
    {
        return new StationProjector($repository);
    }

    /**
     * @test
     */
    public function itCreatesRightReadModel()
    {
        $code = 'QH';
        $name = 'Quahog';
        $latitude = 43.34;
        $longitude = 15.51;
        $linkedStations = ['AA', 'BB', 'CC'];

        $this->scenario
            ->when(
                new StationWasCreated(
                    $code,
                    $name,
                    $latitude,
                    $longitude,
                    $linkedStations
                )
            )
            ->then([
                new Station(
                    $code,
                    $name,
                    $latitude,
                    $longitude,
                    $linkedStations
                )
            ]);
    }
}
