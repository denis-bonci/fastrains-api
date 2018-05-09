<?php

namespace App\Tests\Event;

use App\Event\TravelWasCalculated;
use Broadway\Serializer\Testing\SerializableEventTestCase;

class TravelWasCalculatedTest extends SerializableEventTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createEvent()
    {
        return new TravelWasCalculated('AAA', [
            [
                "id"       => "SA-MI",
                "coverage" => ["RM", "FI", "BO", "MI"]
            ],
            [
                "id"       => "VE-TO",
                "coverage" => ["MI", "TO"]
            ],
        ]);
    }

    /**
     * @test
     */
    public function itCreateRightEvent()
    {
        $event = $this->createEvent();

        $this->assertEquals('AAA', $event->getId());
        $this->assertEquals([
            [
                "id"       => "SA-MI",
                "coverage" => ["RM", "FI", "BO", "MI"]
            ],
            [
                "id"       => "VE-TO",
                "coverage" => ["MI", "TO"]
            ],
        ], $event->getTravel());
    }
}
