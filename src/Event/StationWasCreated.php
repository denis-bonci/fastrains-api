<?php

namespace App\Event;

use Broadway\Serializer\Serializable;

class StationWasCreated implements Serializable
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
     * StationWasCreated constructor.
     * @param string $code
     * @param string $name
     * @param float  $latitude
     * @param float  $longitude
     * @param array  $linkedStations
     */
    public function __construct(string $code, string $name, float $latitude, float $longitude, array $linkedStations)
    {
        $this->id = $code;
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->linkedStations = $linkedStations;
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return array
     */
    public function getLinkedStations(): array
    {
        return $this->linkedStations;
    }

    public function serialize(): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'latitude'        => $this->latitude,
            'longitude'       => $this->longitude,
            'linked_stations' => $this->linkedStations,
        ];
    }

    public static function deserialize(array $data): StationWasCreated
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['latitude'],
            $data['longitude'],
            $data['linked_stations']
        );
    }
}