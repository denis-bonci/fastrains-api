<?php

namespace App\Tests\Event;

use App\Event\SectionWasCreated;
use Broadway\Serializer\Testing\SerializableEventTestCase;

class SectionWasCreatedTest extends SerializableEventTestCase
{
    protected function createEvent()
    {
        $id = 'QH-SP';
        $name = 'Quahog/Springfield';
        $stations = ['QH', 'SP'];

        return new SectionWasCreated($id, $name, $stations);
    }

    /**
     * @test
     */
    public function itCreateRightEvent()
    {
        $event = $this->createEvent();

        $this->assertEquals('QH-SP', $event->getId());
        $this->assertEquals('Quahog/Springfield', $event->getName());
        $this->assertEquals(['QH', 'SP'], $event->getStations());
    }
}