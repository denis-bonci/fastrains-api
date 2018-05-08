<?php

namespace App\Section;

use App\Command\CreateSection;
use Broadway\CommandHandling\SimpleCommandHandler;
use Broadway\EventSourcing\EventSourcingRepository;

class SectionCommandHandler extends SimpleCommandHandler
{
    /**
     * @var EventSourcingRepository
     */
    private $repository;

    /**
     * SectionCommandHandler constructor.
     * @param EventSourcingRepository $repository
     */
    public function __construct(EventSourcingRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handleCreateSection(CreateSection $command)
    {
        $this->repository->save(Section::create(
           $command->getId(),
           $command->getName(),
           $command->getStations()
        ));
    }
}