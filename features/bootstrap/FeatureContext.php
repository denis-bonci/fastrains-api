<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Class FeatureContext
 */
class FeatureContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var Response|null
     */
    private $response;

    /**
     * FeatureContext constructor.
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given an api rest
     */
    public function anApiRest()
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        $input = new ArrayInput(['command' => 'app:setup']);
        $output = new NullOutput();
        $application->run($input, $output);
    }

    /**
     * @When sends a request to :path
     */
    public function sendsARequestTo($path)
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then i receive a stations list
     */
    public function iReceiveAStationsList()
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }

        if ($this->response->getStatusCode() !== 200) {
            throw new \RuntimeException('Invalid status code');
        }

        $json = json_decode($this->response->getContent());

        if (count($json) !== 15) {
            throw new \RuntimeException('Unexpected stations number');
        }
    }

    /**
     * @When i send a requesto to :path with departure to :departureStationId and arrival to :arrivalStationId
     */
    public function iSendARequestoToWithDepartureToAndArrivalTo($path, $departureStationId, $arrivalStationId)
    {
        $this->response = $this->kernel->handle(Request::create(
            $path,
            'POST',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            '{"departureId": "RM", "arrivalId": "TO"}'
            )
        );
    }

    /**
     * @Then i receive a travel itinerary with :arg1 change
     */
    public function iReceiveATravelItineraryWithChange($arg1)
    {
        if ($this->response->getStatusCode() !== 200) {
            throw new \RuntimeException('Invalid status code');
        }

        $content = json_decode($this->response->getContent());

        if (count($content) !== 2) {
            throw new \RuntimeException('Invalid number of sections');
        }

        if ($content[0]->id !== 'SA-MI') {
            throw new \RuntimeException('Invalid section');
        }

        if ($content[1]->id !== 'VE-TO') {
            throw new \RuntimeException('Invalid section');
        }
    }
}
