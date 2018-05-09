<?php

namespace App\ReadModel;

use App\Event\TravelWasCalculated;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;

class TravelProjector extends Projector
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * TravelProjector constructor.
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    protected function applyTravelWasCalculated(TravelWasCalculated $event)
    {
        $this->repository->save(new Travel(
            $event->getId(),
            $event->getTravel()
        ));
    }
}