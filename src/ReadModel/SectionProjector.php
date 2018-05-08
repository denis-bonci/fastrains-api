<?php

namespace App\ReadModel;

use App\Event\SectionWasCreated;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;

class SectionProjector extends Projector
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * SectionProjector constructor.
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    protected function applySectionWasCreated(SectionWasCreated $event)
    {
        $this->repository->save(new Section(
            $event->getId(),
            $event->getName(),
            $event->getStations()
        ));
    }
}