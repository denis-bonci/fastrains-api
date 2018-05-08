<?php

namespace App\Section;

use App\Event\SectionWasCreated;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

class Section extends EventSourcedAggregateRoot
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $stations;

    public function getAggregateRootId(): string
    {
        return $this->id;
    }

    public static function create(string $id, string $name, array $stations)
    {
        $section = new Section();
        $section->apply(new SectionWasCreated(
            $id,
            $name,
            $stations
        ));

        return $section;
    }

    protected function applySectionWasCreated(SectionWasCreated $event)
    {
        $this->id = $event->getId();
        $this->name = $event->getName();
        $this->stations = $event->getStations();
    }
}