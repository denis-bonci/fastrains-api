<?php

namespace App;

use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\ReadModel\Repository;

class AppNewRepository extends EventSourcingRepository
{
    /**
     * @var Repository
     */
    private $stationRepository;

    /**
     * @var Repository
     */
    private $sectionRepository;

    public function __construct(
        EventStore $eventStore, EventBus $eventBus, $aggregateClass, $eventStreamDecorators = [],
        Repository $stationRepository, Repository $sectionRepository
    )
    {
        $this->stationRepository = $stationRepository;
        $this->sectionRepository = $sectionRepository;

        parent::__construct(
            $eventStore,
            $eventBus,
            $aggregateClass,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }

    /**
     * @return Repository
     */
    public function getStationRepository(): Repository
    {
        return $this->stationRepository;
    }

    /**
     * @return Repository
     */
    public function getSectionRepository(): Repository
    {
        return $this->sectionRepository;
    }
}