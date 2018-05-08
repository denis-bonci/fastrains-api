<?php

namespace App\Station;

use App\Command\CreateStation;
use Broadway\CommandHandling\SimpleCommandHandler;
use Broadway\EventSourcing\EventSourcingRepository;

class StationCommandHandler extends SimpleCommandHandler
{
    /**
     * @var EventSourcingRepository
     */
    private $repository;

    /**
     * StationCommandHandler constructor.
     * @param EventSourcingRepository $repository
     */
    public function __construct(EventSourcingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handleCreateStation(CreateStation $command)
    {
        $this->repository->save(Station::create(
            $command->getId(),
            $command->getName(),
            $command->getLatitude(),
            $command->getLongitude(),
            $command->getLinkedStations()
        ));
    }
}