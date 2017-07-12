<?php


namespace AppBundle\Domain;

use AppBundle\Contract\Event\TodoWasCreated;
use AppBundle\Contract\Event\TodoWasDeleted;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

class Todo extends EventSourcedAggregateRoot
{
    /**
     * @var TodoId
     */
    protected $todoId;

    /**
     * @var TodoName
     */
    protected $todoName;

    /**
     * @var TodoListId
     */
    protected $todoListId;

    /**
     * @param TodoId $todoId
     * @param TodoName $todoName
     * @param TodoListId $todoListId
     * @return static
     */
    static public function create(TodoId $todoId, TodoName $todoName, TodoListId $todoListId)
    {
        $todoList = new static();
        $todoList->apply(new TodoWasCreated($todoId, $todoName, $todoListId));
        return $todoList;
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return (string)$this->todoId;
    }

    /**
     * @return static
     */
    public function delete()
    {
        $this->apply(new TodoWasDeleted($this->todoId, $this->todoName));

        return $this;
    }

    /**
     * @param TodoWasCreated $event
     */
    protected function applyTodoWasCreated(TodoWasCreated $event)
    {
        $this->todoId = new TodoId($event->getTodoId());
        $this->todoName = new TodoName($event->getName());
        $this->todoListId = new TodoListId($event->getTodoListId());
    }
}