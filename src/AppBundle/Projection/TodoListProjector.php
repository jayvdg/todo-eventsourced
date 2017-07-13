<?php


namespace AppBundle\Projection;


use AppBundle\Contract\Event\TodoListWasCreated;
use AppBundle\Contract\Event\TodoWasCreated;
use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;

class TodoListProjector extends Projector
{
    /**
     * @var Repository
     */
    private $repository;

    /**
     * TodoListProjector constructor.
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param TodoListWasCreated $event
     */
    protected function applyTodoListWasCreated(TodoListWasCreated $event)
    {
        $this->repository->save(new TodoList($event->getListId(), $event->getName()));
    }

    /**
     * @param TodoWasCreated $event
     */
    protected function applyTodoWasCreated(TodoWasCreated $event)
    {
        /** @var TodoList $todoList */
        $todoList = $this->repository->find($event->getTodoListId());

        $this->repository->save($todoList->addTodo(new Todo($event->getTodoId(), $event->getName())));
    }
}