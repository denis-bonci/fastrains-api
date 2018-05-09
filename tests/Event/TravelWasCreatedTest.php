<?php

namespace App\Tests\Event;

use App\Event\TravelWasCreated;
use Broadway\Serializer\Testing\SerializableEventTestCase;

class TravelWasCreatedTest extends SerializableEventTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createEvent()
    {
        return new TravelWasCreated('AAA', 'RM', 'TO');
    }

    /**
     * @test
     */
    public function itCreateRightEvent()
    {
        $event = $this->createEvent();

        $this->assertEquals('AAA', $event->getId());
        $this->assertEquals('RM', $event->getDepartureStationId());
        $this->assertEquals('TO', $event->getArrivalStationId());
    }
}
