<?php

namespace App\Tests\Section;

use App\AppRepository;
use App\Command\CreateSection;
use App\Event\SectionWasCreated;
use App\Section\SectionCommandHandler;
use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventStore\EventStore;

/**
 * Class SectionCommandHandlerTest
 * @package App\Tests\Section
 */
class SectionCommandHandlerTest extends CommandHandlerScenarioTestCase
{
    /**
     * @param EventStore $eventStore
     * @param EventBus   $eventBus
     *
     * @return CommandHandler
     */
    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus): CommandHandler
    {
        return new SectionCommandHandler(
            new AppRepository($eventStore, $eventBus, 'App\Section\Section')
        );
    }

    /**
     * @test
     */
    public function itHandleCreateSection()
    {
        $id = 'QH-SP';
        $name = 'Quahog/Springfield';
        $stations = ['QH', 'SP'];

        $this->scenario
            ->when(new CreateSection($id, $name, $stations))
            ->then([new SectionWasCreated($id, $name, $stations)]);
    }
}
