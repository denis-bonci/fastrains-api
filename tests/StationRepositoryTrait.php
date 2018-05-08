<?php

namespace App\Tests;

use Broadway\ReadModel\Repository;

trait StationRepositoryTrait
{
    protected $stationRepository;

    public function getStationRepository()
    {
        if (!$this->stationRepository) {
            $stationRepository = $this->prophesize(Repository::class);
            $stationRepository->find('FI')->willReturn(self::$stations['FI']);
            $stationRepository->find('NA')->willReturn(self::$stations['NA']);
            $stationRepository->find('BO')->willReturn(self::$stations['BO']);
            $stationRepository->find('RM')->willReturn(self::$stations['RM']);
            $stationRepository->find('VR')->willReturn(self::$stations['VR']);
            $stationRepository->find('PD')->willReturn(self::$stations['PD']);
            $stationRepository->find('MI')->willReturn(self::$stations['MI']);
            $stationRepository->find('TO')->willReturn(self::$stations['TO']);
            $stationRepository->find('FG')->willReturn(self::$stations['FG']);
            $stationRepository->find('BA')->willReturn(self::$stations['BA']);
            $stationRepository->find('SA')->willReturn(self::$stations['SA']);
            $stationRepository->find('VE')->willReturn(self::$stations['VE']);
            $stationRepository->find('ME')->willReturn(self::$stations['ME']);
            $stationRepository->find('PA')->willReturn(self::$stations['PA']);
            $stationRepository->find('CT')->willReturn(self::$stations['CT']);
            $this->stationRepository = $stationRepository;
        }

        return $this->stationRepository->reveal();
    }
}