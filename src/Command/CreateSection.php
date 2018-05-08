<?php

namespace App\Command;

/**
 * Class CreateSection
 * @package App\Command
 */
class CreateSection
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

    /**
     * CreateSection constructor.
     *
     * @param string $id
     * @param string $name
     * @param array  $stations
     */
    public function __construct(string $id, string $name, array $stations)
    {
        $this->id = $id;
        $this->name = $name;
        $this->stations = $stations;
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
     * @return string
     */
    public function getStations(): array
    {
        return $this->stations;
    }
}