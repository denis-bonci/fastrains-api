<?php

namespace App\Event;

use App\ReadModel\Station;
use Broadway\Serializer\Serializable;

class TravelWasCreated implements Serializable
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
     * TravelWasCreated constructor.
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

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'departureStationId' => $this->departureStationId,
            'arrivalStationId' => $this->arrivalStationId,
        ];
    }

    public static function deserialize(array $data)
    {
        return new self(
            $data['id'],
            $data['departureStationId'],
            $data['arrivalStationId']
        );
    }
}