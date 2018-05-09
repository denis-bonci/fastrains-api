<?php

namespace App\Event;

use Broadway\Serializer\Serializable;

class TravelWasCalculated implements Serializable
{
    /**
     * @var string
     */
    private  $id;

    /**
     * @var array
     */
    private $travel;

    /**
     * ItineraryWasCalculated constructor.
     * @param string $id
     * @param array $travel
     */
    public function __construct(string $id, array $travel)
    {
        $this->id = $id;
        $this->travel = $travel;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getTravel(): array
    {
        return $this->travel;
    }

    public function serialize(): array
    {
        return [
            'id' => $this->id,
            'travel' => $this->travel,
        ];
    }

    public static function deserialize(array $data)
    {
        return new self(
            $data['id'],
            $data['travel']
        );
    }
}