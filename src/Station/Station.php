<?php

namespace App\Station;

use App\Event\StationWasCreated;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

/**
 * Class Station
 * @package App\Station
 */
class Station extends EventSourcedAggregateRoot
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
     * @var float
     */
    private $latitude;

    /**
     * @var float
     */
    private $longitude;

    /**
     * @var array
     */
    private $linkedStations;

    /**
     * @return string
     */
    public function getAggregateRootId(): string
    {
        return $this->id;
    }

    /**
     * @param string $code
     * @param string $name
     * @param float  $latitude
     * @param float  $longitude
     * @param array  $linkedStations
     *
     * @return Station
     */
    public static function create(string $code, string $name, float $latitude, float $longitude, array $linkedStations): Station
    {
        $station = new Station();
        $station->apply(new StationWasCreated(
            $code,
            $name,
            $latitude,
            $longitude,
            $linkedStations
        ));

        return $station;
    }

    /**
     * @param StationWasCreated $event
     */
    protected function applyStationWasCreated(StationWasCreated $event)
    {
        $this->id = $event->getId();
        $this->name = $event->getName();
        $this->latitude = $event->getLatitude();
        $this->longitude = $event->getLongitude();
        $this->linkedStations = $event->getLinkedStations();
    }
}