<?php

namespace App\Tests\Travel;

use App\Event\TravelWasCalculated;
use App\Event\TravelWasCreated;
use App\ReadModel\Section;
use App\ReadModel\Station;
use App\Tests\StationRepositoryTrait;
use App\Travel\Travel;
use Broadway\EventSourcing\Testing\AggregateRootScenarioTestCase;
use Broadway\ReadModel\Repository;

class TravelTest extends AggregateRootScenarioTestCase
{
    use StationRepositoryTrait;

    /**
     * @var array
     */
    private static $stations = [];

    /**
     * @beforeClass
     */
    public static function loadData()
    {
        self::$stations = [
            'TO' => new Station('TO', 'Torino Porta Nuova', 45.06141, 7.67804, ['MI']),
            'MI' => new Station('MI', 'Milano Centrale', 45.48592, 9.2041, ['TO', 'VR', 'BO']),
            'VR' => new Station('VR', 'Verona Porta Nuova', 45.42909, 10.98229, ['MI', 'BO', 'PD']),
            'VE' => new Station('VE', 'Venezia Mestre', 45.48183, 12.23345, ['PD']),
            'PD' => new Station('PD', 'Padova', 45.41738, 11.88025, ['VE', 'VR', 'BO']),
            'BO' => new Station('BO', 'Bologna Centrale', 44.50593, 11.34295, ['FI', 'MI', 'VR', 'PD']),
            'FI' => new Station('FI', 'Firenze Santa Maria Novella', 43.77642, 11.24785, ['BO', 'RM']),
            'RM' => new Station('RM', 'Roma Termini', 41.9001, 12.5036, ['FI', 'NA']),
            'BA' => new Station('BA', 'Bari Centrale', 41.11745, 16.86899, ['FG']),
            'FG' => new Station('FG', 'Foggia', 41.46601, 15.55608, ['BA', 'NA']),
            'NA' => new Station('NA', 'Napoli Centrale', 40.85295, 14.27313, ['RM', 'FG', 'SA']),
            'SA' => new Station('SA', 'Salerno', 40.67538, 14.77241, ['NA']),
            'PA' => new Station('PA', 'Palermo Centrale', 38.10772, 13.36912, ['ME']),
            'CT' => new Station('CT', 'Catania Centrale', 37.50683, 15.10165, ['ME']),
            'ME' => new Station('ME', 'Messina Centrale', 38.18333, 15.56667, ['PA', 'CT']),
        ];
    }

    protected function getAggregateRootClass(): string
    {
        return Travel::class;
    }

    /**
     * @test
     */
    public function calculateItineraryFromRomeToMilan()
    {
        $stationRepository = $this->getStationRepository();

        $this->scenario
            ->withAggregateId('aaaa')
            ->given([new TravelWasCreated('aaaa', 'RM', 'MI')])
            ->when(function ($travel) use ($stationRepository) {
                $this->assertEquals([
                    self::$stations['RM'],
                    self::$stations['FI'],
                    self::$stations['BO'],
                    self::$stations['MI'],
                ], $travel->calculateItinerary($stationRepository));
            });
    }

    /**
     * @test
     */
    public function calculateItineraryFromBariToTurin()
    {
        $stationRepository = $this->getStationRepository();

        $this->scenario
            ->withAggregateId('aaaa')
            ->given([new TravelWasCreated('aaaa', 'BA', 'TO')])
            ->when(function ($travel) use ($stationRepository) {
                $this->assertEquals([
                    self::$stations['BA'],
                    self::$stations['FG'],
                    self::$stations['NA'],
                    self::$stations['RM'],
                    self::$stations['FI'],
                    self::$stations['BO'],
                    self::$stations['MI'],
                    self::$stations['TO'],
                ], $travel->calculateItinerary($stationRepository));
            });
    }

    /**
     * @test
     * @expectedException \DomainException
     */
    public function calculateItineraryFromCataniaToNaplesWithException()
    {
        $stationRepository = $this->getStationRepository();

        $this->scenario
            ->withAggregateId('aaaa')
            ->given([new TravelWasCreated('aaaa', 'CT', 'NA')])
            ->when(function ($travel) use ($stationRepository) {
                $travel->calculateItinerary($stationRepository);
            });
    }

    /**
     * @test
     */
    public function calculateSectionsFromRomeToTurin()
    {
        $id = 'AAA';
        $itinerary = ['RM', 'FI', 'BO', 'MI', 'TO'];

        $sectionRepository = $this->prophesize(Repository::class);

        $sectionRepository->findBy(['stations' => 'RM'])->willReturn([
            new Section('SA-MI', 'Salerno/Milano Centrale', ['SA', 'NA', 'RM', 'FI', 'BO', 'MI']),
            new Section('MI-SA', 'Milano Centrale/Salerno', ['MI', 'BO', 'FI', 'RM', 'NA', 'SA']),
        ]);

        $sectionRepository->findBy(['stations' => 'MI'])->willReturn([
            new Section('SA-MI', 'Salerno/Milano Centrale', ['SA', 'NA', 'RM', 'FI', 'BO', 'MI']),
            new Section('MI-SA', 'Milano Centrale/Salerno', ['MI', 'BO', 'FI', 'RM', 'NA', 'SA']),
            new Section('VE-TO', 'Venezia Mestre/Torino Porta Nuova', ['VE', 'PD', 'VR', 'MI', 'TO']),
            new Section('TO-VE', 'Torino Porta Nuova/Venezia Mestre', ['TO', 'MI', 'VR', 'PD', 'VE']),
        ]);

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new TravelWasCreated($id, 'RM', 'TO'),
            ])
            ->when(function ($travel) use ($itinerary, $sectionRepository) {
                $travel->calculateSections($itinerary, $sectionRepository->reveal());
            })
            ->then([
                new TravelWasCalculated(
                    $id, [
                        [
                            "id"       => "SA-MI",
                            "coverage" => ["RM", "FI", "BO", "MI"]
                        ],
                        [
                            "id"       => "VE-TO",
                            "coverage" => ["MI", "TO"]
                        ]
                    ]
                )

            ]);
    }

    /**
     * @test
     */
    public function calculateSectionsFromBariToNaples()
    {
        $id = 'AAA';
        $itinerary = ['BA', 'FG', 'NA'];

        $sectionRepository = $this->prophesize(Repository::class);

        $sectionRepository->findBy(['stations' => 'BA'])->willReturn([
            new Section('BA-NA', 'Bari Centrale/Napoli Centrale', ['BA', 'FG', 'NA']),
            new Section('NA-BA', 'Napoli Centrale/Bari Centrale', ['NA', 'FG', 'BA']),
        ]);

        $this->scenario
            ->withAggregateId($id)
            ->given([
                new TravelWasCreated($id, 'BA', 'NA'),
            ])
            ->when(function ($travel) use ($itinerary, $sectionRepository) {
                $travel->calculateSections($itinerary, $sectionRepository->reveal());
            })
            ->then([
                new TravelWasCalculated(
                    $id, [
                        [
                            "id"       => 'BA-NA',
                            "coverage" => ['BA', 'FG', 'NA']
                        ],
                    ]
                )
            ]);
    }
}