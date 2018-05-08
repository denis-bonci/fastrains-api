<?php

namespace App\Tests\Station;

use App\Event\StationWasCreated;
use App\Station\Station;
use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;

class StationTest extends AggregateRootScenarioTestCase
{
    protected function getAggregateRootClass(): string
    {
        return Station::class;
    }

    /**
     * @test
     */
    public function itCreateNewStation()
    {
        $code = 'QH';
        $name = 'Quahog';
        $latitude = 43.34;
        $longitude = 15.51;
        $linkedStations = ['AA', 'BB', 'CC'];

        $this->scenario
            ->when(function () use ($code, $name, $latitude, $longitude, $linkedStations) {
                return Station::create(
                    $code,
                    $name,
                    $latitude,
                    $longitude,
                    $linkedStations
                );
            })
            ->then([
                new StationWasCreated(
                    $code,
                    $name,
                    $latitude,
                    $longitude,
                    $linkedStations)
            ]);
    }
}
