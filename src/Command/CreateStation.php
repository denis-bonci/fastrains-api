<?php

namespace App\Command;

/**
 * Class CreateStation
 * @package App\Command
 */
class CreateStation
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
     * CreateStation constructor.
     *
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
}