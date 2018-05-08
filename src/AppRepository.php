<?php

namespace App;

use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;

class AppRepository extends EventSourcingRepository
{
    public function __construct(EventStore $eventStore, EventBus $eventBus, $aggregateClass, $eventStreamDecorators = [])
    {
        parent::__construct(
            $eventStore,
            $eventBus,
            $aggregateClass,
            new PublicConstructorAggregateFactory(),
            $eventStreamDecorators
        );
    }
}