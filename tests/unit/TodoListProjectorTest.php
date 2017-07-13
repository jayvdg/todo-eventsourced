<?php

namespace Tests\Unit;

use AppBundle\Contract\Event\TodoListWasCreated;
use AppBundle\Contract\Event\TodoWasCreated;
use AppBundle\Projection\Todo;
use AppBundle\Projection\TodoList;
use AppBundle\Projection\TodoListProjector;
use Broadway\ReadModel\InMemory\InMemoryRepository;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Testing\ProjectorScenarioTestCase;

class TodoListProjectorTest extends ProjectorScenarioTestCase
{
    public function testTodoListWasCreated()
    {
        $this->scenario->withAggregateId('listid')
            ->given([])
            ->when(new TodoListWasCreated('listid', 'listname'))
            ->then([
                new TodoList('listid', 'listname')
            ]);
    }

    public function testTodoWasAddedToList()
    {
        $this->scenario->withAggregateId('listid')
            ->given([new TodoListWasCreated('listid', 'listname')])
            ->when(new TodoWasCreated('todoid', 'todoname', 'listid'))
            ->then([
                new TodoList('listid', 'listname', 1, new Todo('todoid', 'todoname'))
            ]);
    }

    /**
     * @return Projector
     */
    protected function createProjector(InMemoryRepository $repository)
    {
        return new TodoListProjector($repository);
    }
}