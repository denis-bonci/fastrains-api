<?php

namespace App\ReadModel;

use App\Event\StationWasCreated;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;

class StationProjector extends Projector
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * StationProjector constructor.
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    protected function applyStationWasCreated(StationWasCreated $event)
    {
        $this->repository->save(new Station(
            $event->getId(),
            $event->getName(),
            $event->getLatitude(),
            $event->getLongitude(),
            $event->getLinkedStations()
        ));
    }
}