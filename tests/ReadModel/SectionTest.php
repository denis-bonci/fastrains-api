<?php

namespace App\Tests\ReadModel;

use App\ReadModel\Section;
use Broadway\ReadModel\SerializableReadModel;
use Broadway\ReadModel\Testing\SerializableReadModelTestCase;

class SectionTest extends SerializableReadModelTestCase
{
    /**
     * {@inheritdoc}
     */
    protected function createSerializableReadModel(): SerializableReadModel
    {
        $id = 'QH-SP';
        $name = 'Quahog/Springfield';
        $stations = ['QH', 'SP'];

        return new Section($id, $name, $stations);
    }

    /**
     * @test
     */
    public function itCreatesRightReadModel()
    {
        /** @var Section $readModel */
        $readModel = $this->createSerializableReadModel();

        $this->assertEquals('QH-SP', $readModel->getId());
        $this->assertEquals('Quahog/Springfield', $readModel->getName());
        $this->assertEquals(['QH', 'SP'], $readModel->getStations());
    }
}
