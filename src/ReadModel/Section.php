<?php

namespace App\ReadModel;

use Broadway\ReadModel\SerializableReadModel;

class Section implements SerializableReadModel
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
     * Section constructor.
     * @param string $id
     * @param string $name
     * @param string $stations
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

    public function serialize(): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'stations' => $this->stations,
        ];
    }

    public static function deserialize(array $data)
    {
        return new self(
            $data['id'],
            $data['name'],
            $data['stations']
        );
    }
}