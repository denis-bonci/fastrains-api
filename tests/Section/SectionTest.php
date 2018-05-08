<?php

namespace App\Tests\Section;

use App\Event\SectionWasCreated;
use App\Section\Section;
use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;

class SectionTest extends AggregateRootScenarioTestCase
{
    protected function getAggregateRootClass(): string
    {
        return Section::class;
    }

    /**
     * @test
     */
    public function itCreateNewSection()
    {
        $id = 'QH-SP';
        $name = 'Quahog/Springfield';
        $stations = ['QH', 'SP'];

        $this->scenario
            ->when(function () use ($id, $name, $stations) {
                return Section::create($id, $name, $stations);
            })
            ->then([
                new SectionWasCreated(
                    $id,
                    $name,
                    $stations
                )
            ]);
    }
}
