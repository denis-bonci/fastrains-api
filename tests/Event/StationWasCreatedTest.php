<?php

namespace App\Tests\Event;

use App\Event\StationWasCreated;
use Broadway\Serializer\Testing\SerializableEventTestCase;

class StationWasCreatedTest extends SerializableEventTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createEvent()
    {
        $code = 'QH';
        $name = 'Quahog';
        $latitude = 43.34;
        $longitude = 15.51;
        $linkedStations = ['AA', 'BB', 'CC'];

        return new StationWasCreated($code, $name, $latitude, $longitude, $linkedStations);
    }

    /**
     * @test
     */
    public function itCreateRightEvent()
    {
        $event    = $this->createEvent();

        $this->assertEquals('QH', $event->getId());
        $this->assertEquals('Quahog', $event->getName());
        $this->assertEquals(43.34, $event->getLatitude());
        $this->assertEquals(15.51, $event->getLongitude());
        $this->assertEquals(['AA', 'BB', 'CC'], $event->getLinkedStations());
    }
}
