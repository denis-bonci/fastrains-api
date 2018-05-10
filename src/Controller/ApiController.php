<?php

namespace App\Controller;

use App\Command\CalculateTravel;
use App\Exception\DestinationUnreachableException;
use App\ReadModel\Section;
use App\ReadModel\Station;
use App\ReadModel\Travel;
use Broadway\CommandHandling\CommandBus;
use Broadway\ReadModel\Repository;
use Broadway\UuidGenerator\UuidGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends Controller
{
    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var UuidGeneratorInterface
     */
    private $uuidGenerator;

    /**
     * @var Repository
     */
    private $travelRepository;

    /**
     * @var Repository
     */
    private $sectionRepository;

    /**
     * @var Repository
     */
    private $stationRepository;

    /**
     * ApiController constructor.
     * @param CommandBus $commandBus
     * @param UuidGeneratorInterface $uuidGenerator
     * @param Repository $travelRepository
     * @param Repository $sectionRepository
     * @param Repository $stationRepository
     */
    public function __construct(CommandBus $commandBus, UuidGeneratorInterface $uuidGenerator, Repository $travelRepository, Repository $sectionRepository, Repository $stationRepository)
    {
        $this->commandBus = $commandBus;
        $this->uuidGenerator = $uuidGenerator;
        $this->travelRepository = $travelRepository;
        $this->sectionRepository = $sectionRepository;
        $this->stationRepository = $stationRepository;
    }

    /**
     * @Route("/stations")
     *
     * @return JsonResponse
     */
    public function stations(): JsonResponse
    {
        $stations = $this->stationRepository->findBy(["linked_stations" => ['$exists' => true ]]);

        $response =  new JsonResponse(
            array_map(function (Station $station) {
                return [
                    'id' => $station->getId(),
                    'name' => $station->getName(),
                ];
                }, $stations
            )
        );
        return $response;
    }

    /**
     * @Route("/travel")
     * @Method({"POST"})
     */
    public function search(Request $request)
    {
        $jsonRequest = json_decode($request->getContent());
        $departureStationId = $jsonRequest->departureId;
        $arrivalStationId = $jsonRequest->arrivalId;

        $travelId = $this->uuidGenerator->generate();

        try {
            $this->commandBus->dispatch(new CalculateTravel(
                $travelId,
                $departureStationId,
                $arrivalStationId
            ));
        } catch (DestinationUnreachableException $exception) {
            return new JsonResponse(['error' => 'Departure and arrival stations are not connected']);
        }

        /** @var Travel $travel */
        $travel = $this->travelRepository->find($travelId);

        $normalizedTravel = [];

        foreach ($travel->getTravel() as $section) {

            $stations = [];

            foreach ($section['coverage'] as $stationId) {
                $station = $this->stationRepository->find($stationId);

                $stations[] = [
                    'id' => $station->getId(),
                    'name' => $station->getName(),
                ];
            }

            /** @var Section $section */
            $section = $this->sectionRepository->find($section['id']);

            $normalizedTravel[] = [
                'id' => $section->getId(),
                'name' => $section->getName(),
                'stations' => $stations,
            ];
        }

        $response = new JsonResponse($normalizedTravel);
        return $response;

    }
}