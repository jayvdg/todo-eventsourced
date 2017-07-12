<?php


namespace AppBundle\Domain;


use AppBundle\Contract\Event\TodoListWasCreated;
use AppBundle\Contract\Event\TodoListWasDeleted;
use AppBundle\Exceptions\AggregateRootNotAvailableException;
use Broadway\EventSourcing\EventSourcedAggregateRoot;

class TodoList extends EventSourcedAggregateRoot
{
    /**
     * @var TodoListId
     */
    protected $todoListId;

    /**
     * @var TodoListName
     */
    protected $todoListName;

    /** @var  bool */
    protected $deleted;

    /**
     * @param TodoListId $todoListId
     * @param TodoListName $todoListName
     * @return static
     */
    static public function create(TodoListId $todoListId, TodoListName $todoListName)
    {
        $todoList = new static();
        $todoList->apply(new TodoListWasCreated($todoListId, $todoListName));
        return $todoList;
    }

    /**
     * @return string
     */
    public function getAggregateRootId()
    {
        return (string)$this->todoListId;
    }

    /**
     * @return static
     */
    public function delete()
    {
        $this->apply(new TodoListWasDeleted($this->todoListId, $this->todoListName));

        return $this;
    }

    /**
     * @param TodoId $id
     * @param TodoName $todoName
     *
     * @return Todo
     * @throws \Exception
     */
    public function addTodo(TodoId $id, TodoName $todoName)
    {
        if ($this->deleted) {
            throw new AggregateRootNotAvailableException('List was deleted');
        }

        return Todo::create($id, $todoName, $this->todoListId);
    }

    /**
     * @param TodoListWasCreated $event
     */
    protected function applyTodoListWasCreated(TodoListWasCreated $event)
    {
        $this->todoListId = new TodoListId($event->getListId());
        $this->todoListName = new TodoListName($event->getName());
    }

    /**
     * @param TodoListWasDeleted $event
     */
    protected function applyTodoListWasDeleted(TodoListWasDeleted $event)
    {
        $this->deleted = true;
    }
}