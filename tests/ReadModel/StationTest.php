<?php

namespace App\Tests\ReadModel;

use App\ReadModel\Station;
use Broadway\ReadModel\SerializableReadModel;
use Broadway\ReadModel\Testing\SerializableReadModelTestCase;
use Location\Coordinate;

class StationTest extends SerializableReadModelTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createSerializableReadModel(): SerializableReadModel
    {
        $id = 'QH';
        $name = 'Quahog';
        $latitude = 43.34;
        $longitude = 15.51;
        $linkedStations = ['AA', 'BB', 'CC'];

        return new Station($id, $name, $latitude, $longitude, $linkedStations);
    }

    /**
     * @test
     */
    public function itCreatesRightReadModel()
    {
        /** @var Station $readModel */
        $readModel = $this->createSerializableReadModel();

        $this->assertEquals('QH', $readModel->getId());
        $this->assertEquals('Quahog', $readModel->getName());
        $this->assertEquals(new Coordinate(43.34, 15.51), $readModel->getCoordinate());
        $this->assertEquals(['AA', 'BB', 'CC'], $readModel->getLinkedStations());
    }
}
