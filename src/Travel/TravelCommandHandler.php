<?php

namespace App\Travel;

use App\Command\CalculateTravel;
use Broadway\CommandHandling\SimpleCommandHandler;
use Broadway\EventSourcing\EventSourcingRepository;

class TravelCommandHandler extends SimpleCommandHandler
{
    /**
     * @var EventSourcingRepository
     */
    private $repository;

    public function __construct(EventSourcingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handleCalculateTravel(CalculateTravel $command)
    {
        $travel = Travel::create(
            $command->getId(),
            $command->getDepartureStationId(),
            $command->getArrivalStationId()
        );

        $itinerary = $travel->calculateItinerary($this->repository->getStationRepository());
        $travel->calculateSections($itinerary, $this->repository->getSectionRepository());

        $this->repository->save($travel);
    }
}