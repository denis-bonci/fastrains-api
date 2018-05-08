<?php

namespace App\Tests\ReadModel;

use App\Event\SectionWasCreated;
use App\ReadModel\Section;
use App\ReadModel\SectionProjector;
use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;

class SectionProjectorTest extends ProjectorScenarioTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createProjector(InMemoryRepository $repository): Projector
    {
        return new SectionProjector($repository);
    }

    /**
     * @test
     */
    public function itCreatesRightReadModel()
    {
        $id = 'QH-SP';
        $name = 'Quahog/Springfield';
        $stations = ['QH', 'SP'];

        $this->scenario
            ->when(
                new SectionWasCreated(
                    $id,
                    $name,
                    $stations
                )
            )
            ->then([
                new Section(
                    $id,
                    $name,
                    $stations
                )
            ]);
    }
}
