<?php

namespace Tests\Unit;

use AppBundle\CommandHandling\TodoListHandler;
use AppBundle\Contract\Command\CreateTodoList;
use AppBundle\Contract\Command\DeleteTodoList;
use AppBundle\Contract\Event\TodoListWasCreated;
use AppBundle\Contract\Event\TodoListWasDeleted;
use AppBundle\Domain\TodoList;
use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;

class TodoListTest extends CommandHandlerScenarioTestCase
{
    /**
     * Create a command handler for the given scenario test case.
     *
     * @param EventStore $eventStore
     * @param EventBus $eventBus
     *
     * @return CommandHandler
     */
    protected function createCommandHandler(EventStore $eventStore, EventBus $eventBus)
    {
        return new TodoListHandler(new EventSourcingRepository($eventStore, $eventBus, TodoList::class,
            new PublicConstructorAggregateFactory()));

    }

    public function testCreateATodoList()
    {
        $this->scenario
            ->withAggregateId('listid')
            ->given([])
            ->when(new CreateTodoList(
                'listid', 'listname'
            ))
            ->then([new TodoListWasCreated('listid', 'listname')]);
    }

    public function testDeleteATodoList()
    {
        $this->scenario
            ->withAggregateId('listid')
            ->given([new TodoListWasCreated('listid', 'listname')])
            ->when(new DeleteTodoList('listid'))
            ->then([new TodoListWasDeleted('listid', 'listname')]);
    }
}