<?php

namespace App\Tests\ReadModel;

use App\Event\TravelWasCalculated;
use App\Event\TravelWasCreated;
use App\ReadModel\Travel;
use App\ReadModel\TravelProjector;
use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;

class TravelProjectorTest extends ProjectorScenarioTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createProjector(InMemoryRepository $repository): Projector
    {
        return new TravelProjector($repository);
    }

    /**
     * @test
     */
    public function itNotCreatesReadModel()
    {
        $id = 'AAA';
        $departureStationId = 'RM';
        $arrivalStationId = 'MI';

        $this->scenario
            ->when(new TravelWasCreated(
                $id,
                $departureStationId,
                $arrivalStationId
            ))
            ->then([]);
    }

    /**
     * @test
     */
    public function itCreatesRightReadModel()
    {
        $id = 'AAA';
        $departureStationId = 'RM';
        $arrivalStationId = 'TO';
        $travel = [
            [
                "id"       => "SA-MI",
                "coverage" => ["RM", "FI", "BO", "MI"]
            ],
            [
                "id"       => "VE-TO",
                "coverage" => ["MI", "TO"]
            ],
        ];

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new TravelWasCreated($id, $departureStationId, $arrivalStationId)
            ])
            ->when(
                new TravelWasCalculated($id, $travel)
            )
            ->then([
                new Travel(
                    $id,
                    $travel
                )
            ]);
    }
}
