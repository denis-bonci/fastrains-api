<?php

namespace App\Travel;

use App\Event\TravelWasCalculated;
use App\Event\TravelWasCreated;
use App\Exception\DestinationUnreachableException;
use App\ReadModel\Section;
use App\ReadModel\Station;
use Broadway\EventSourcing\EventSourcedAggregateRoot;
use Broadway\ReadModel\Repository;
use Location\Distance\Haversine;

class Travel extends EventSourcedAggregateRoot
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $departureStationId;

    /**
     * @var string
     */
    private $arrivalStationId;

    /**
     * @var array
     */
    private $itinerary;

    public function getAggregateRootId(): string
    {
        return $this->id;
    }

    public static function create(string $id, string $departureStationId, string $arrivalStationId): Travel
    {
        $travel = new Travel();
        $travel->apply(new TravelWasCreated(
            $id,
            $departureStationId,
            $arrivalStationId
        ));

        return $travel;
    }

    public function applyTravelWasCreated(TravelWasCreated $event)
    {
        $this->id = $event->getId();
        $this->departureStationId = $event->getDepartureStationId();
        $this->arrivalStationId = $event->getArrivalStationId();
    }

    public function calculateItinerary(Repository $repository)
    {
        /** @var Station $departureStation */
        $departureStation = $repository->find($this->departureStationId);
        /** @var Station $arrivalStation */
        $arrivalStation = $repository->find($this->arrivalStationId);

        $itinerary = [$departureStation];
        $current = $departureStation;

        $totalDistance = $this->calculateDistance($current, $arrivalStation);

        while ($totalDistance) {
            $linkedStationsDistances = [];

            foreach ($current->getLinkedStations() as $linkedStationId) {

                /** @var Station $linkedStation */
                $linkedStation = $repository->find($linkedStationId);

                $distanceFromDestination = $this->calculateDistance($linkedStation, $arrivalStation);

                $linkedStationsDistances[(int)$distanceFromDestination] = $linkedStation;
            }

            $nextStationDistance = min(array_keys($linkedStationsDistances));
            $totalDistance = $nextStationDistance;

            $current = $linkedStationsDistances[$nextStationDistance];

            if (in_array($current, $itinerary)) {
                throw new DestinationUnreachableException();
            }

            $itinerary[] = $current;
        }

        return array_map(function (Station $station) {return $station->getId();}, $itinerary);
    }

    /**
     * @param array $itinerary
     * @param Repository $repository
     */
    public function calculateSections(array $itinerary, Repository $repository)
    {
        $currentFrom = $this->departureStationId;
        $foundSections = [];

        do {
            $sections = $repository->findBy(['stations' => $currentFrom]);

            foreach ($sections as $section) {
                /** @var Section $section */
                $intersection = array_intersect($itinerary, $section->getStations());

                $foundFrom = array_search(reset($intersection), $section->getStations());
                $leng = count($intersection);

                if ($leng < 2 || array_key_exists($section->getId(), array_column($foundSections, 'id'))) {
                    continue;
                }

                $compared = array_slice($section->getStations(), $foundFrom, $leng);

                $compared2 = array_values($intersection);

                if ($compared2 === $compared) {
                    $foundSections[] = ['id' => $section->getId(), 'coverage' => $compared2];
                    $currentFrom = end($intersection);
                    $itinerary = [$currentFrom] + array_diff($itinerary,  $compared2);
                    break;
                }
            }

        } while ($currentFrom !== $this->arrivalStationId);

        $this->apply(new TravelWasCalculated($this->id, $foundSections));
    }

    protected function applySectionsWasCalculated(TravelWasCalculated $event)
    {
        $this->itinerary = $event->getTravel();
    }

    protected function calculateDistance(Station $station1, Station $station2): float
    {
        $calculator = new Haversine();

        return $calculator->getDistance($station1->getCoordinate(), $station2->getCoordinate());
    }
}
