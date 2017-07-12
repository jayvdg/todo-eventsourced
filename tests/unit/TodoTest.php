<?php

namespace Tests\Unit;

use AppBundle\CommandHandling\TodoHandler;
use AppBundle\Contract\Command\CreateTodo;
use AppBundle\Contract\Command\DeleteTodo;
use AppBundle\Contract\Event\TodoListWasCreated;
use AppBundle\Contract\Event\TodoListWasDeleted;
use AppBundle\Contract\Event\TodoWasCreated;
use AppBundle\Contract\Event\TodoWasDeleted;
use AppBundle\Domain\Todo;
use AppBundle\Domain\TodoList;
use AppBundle\Exceptions\AggregateRootNotAvailableException;
use Broadway\CommandHandling\CommandHandler;
use Broadway\CommandHandling\Testing\CommandHandlerScenarioTestCase;
use Broadway\EventHandling\EventBus;
use Broadway\EventSourcing\AggregateFactory\PublicConstructorAggregateFactory;
use Broadway\EventSourcing\EventSourcingRepository;
use Broadway\EventStore\EventStore;
use Broadway\Repository\AggregateNotFoundException;

class TodoTest extends CommandHandlerScenarioTestCase
{
    public function testCreateATodoWithList()
    {
        $this->scenario
            ->withAggregateId('listid')
            ->given([new TodoListWasCreated('listid', 'listname')])
            ->withAggregateId('todoid')
            ->given([])
            ->when(new CreateTodo(
                'todoid', 'name', 'listid'
            ))
            ->then([new TodoWasCreated('todoid', 'name', 'listid')]);
    }

    public function testCreateATodoWithNonExistingList()
    {
        $this->expectException(AggregateNotFoundException::class);

        $this->scenario
            ->withAggregateId('todoid')
            ->given([])
            ->when(new CreateTodo(
                'todoid', 'name', 'missinglist'
            ))
            ->then([]);
    }

    public function testCreateATodoWithDeletedList()
    {
        $this->expectException(AggregateRootNotAvailableException::class);

        $this->scenario
            ->withAggregateId('listid')
            ->given([
                new TodoListWasCreated('listid', 'listname'),
                new TodoListWasDeleted('listid', 'listname')
            ])
            ->withAggregateId('todoid')
            ->given([])
            ->when(new CreateTodo(
                'todoid', 'name', 'listid'
            ))
            ->then([]);
    }



    public function testDeleteATodo()
    {
        $this->scenario
            ->withAggregateId('todoid')
            ->given([new TodoWasCreated('todoid', 'name', 'listid')])
            ->when(new DeleteTodo('todoid'))
            ->then([new TodoWasDeleted('todoid', 'name')]);
    }

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
        return new TodoHandler(
            new EventSourcingRepository($eventStore, $eventBus, Todo::class, new PublicConstructorAggregateFactory()),
            new EventSourcingRepository($eventStore, $eventBus, TodoList::class, new PublicConstructorAggregateFactory())
        );
    }
}