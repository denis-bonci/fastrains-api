<?php

namespace App\ReadModel;

use Broadway\ReadModel\SerializableReadModel;
use Location\Coordinate;

class Station implements SerializableReadModel
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
     * Station constructor.
     * @param string $id
     * @param string $name
     * @param float  $latitude
     * @param float  $longitude
     * @param array  $linkedStations
     */
    public function __construct(string $id, string $name, float $latitude, float $longitude, array $linkedStations)
    {
        $this->id = $id;
        $this->name = $name;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->linkedStations = $linkedStations;
    }

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

    public function getCoordinate(): Coordinate
    {
        return new Coordinate($this->latitude, $this->longitude);
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

    public static function deserialize(array $data)
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['latitude'],
            $data['longitude'],
            $data['linked_stations']
        );
    }

    public function __toString()
    {
        return $this->id;
    }
}