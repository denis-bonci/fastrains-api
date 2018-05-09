<?php

namespace App\Command;

/**
 * Class CalculateTravel
 * @package App\Command
 */
class CalculateTravel
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
     * CalculateTravel constructor.
     *
     * @param string $id
     * @param string $departureStationId
     * @param string $arrivalStationId
     */
    public function __construct(string $id, string $departureStationId, string $arrivalStationId)
    {
        $this->id = $id;
        $this->departureStationId = $departureStationId;
        $this->arrivalStationId = $arrivalStationId;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDepartureStationId(): string
    {
        return $this->departureStationId;
    }

    /**
     * @return string
     */
    public function getArrivalStationId(): string
    {
        return $this->arrivalStationId;
    }
}