<?php

namespace App\Tests\ReadModel;

use App\ReadModel\Travel;
use Broadway\ReadModel\SerializableReadModel;
use Broadway\ReadModel\Testing\SerializableReadModelTestCase;

class TravelTest extends SerializableReadModelTestCase
{
    protected function createSerializableReadModel(): SerializableReadModel
    {
        return new Travel('AAA', [
            [
                "id" => "SA-MI",
                "coverage" => ["RM", "FI", "BO", "MI"]
            ],
            [
                "id" => "VE-TO",
                "coverage" => ["MI", "TO"]
            ],
        ]);
    }

    /**
     * @test
     */
    public function itCreatesRightReadModel()
    {
        /** @var Travel $readModel */
        $readModel = $this->createSerializableReadModel();

        $this->assertEquals('AAA', $readModel->getId());
        $this->assertEquals([
            [
                "id" => "SA-MI",
                "coverage" => ["RM", "FI", "BO", "MI"]
            ],
            [
                "id" => "VE-TO",
                "coverage" => ["MI", "TO"]
            ],
        ], $readModel->getTravel());
    }
}
