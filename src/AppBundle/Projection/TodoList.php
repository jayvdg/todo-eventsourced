<?php


namespace AppBundle\Projection;

use Broadway\ReadModel\Identifiable;

class TodoList implements Identifiable
{
    /**
     * @var string
     */
    private $listId;
    /**
     * @var string
     */
    private $listName;
    /**
     * @var array
     */
    private $todos;
    /**
     * @var int
     */
    private $todoCount;

    /**
     * TodoList constructor.
     * @param string $listId
     * @param string $listName
     * @param int $todoCount
     * @param Todo[] $todos
     */
    public function __construct(string $listId, string $listName, int $todoCount = 0, Todo ...$todos)
    {
        $this->listId = $listId;
        $this->listName = $listName;
        $this->todoCount = $todoCount;
        $this->todos = $todos;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->listId;
    }

    /**
     * @param Todo $todo
     * @return TodoList
     */
    public function addTodo(Todo $todo): TodoList
    {
        return new static($this->listId, $this->listName, $this->todoCount+1, $todo);
    }
}