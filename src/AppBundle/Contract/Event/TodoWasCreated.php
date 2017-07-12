<?php

namespace AppBundle\Contract\Event;


class TodoWasCreated
{
    /**
     * @var string
     */
    private $todoId;

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $todoListId;


    /**
     * CreateTodoList constructor.
     * @param string $todoId
     * @param string $name
     * @param string $todoListId
     */
    public function __construct(string $todoId, string $name, string $todoListId)
    {
        $this->todoId = $todoId;
        $this->name = $name;
        $this->todoListId = $todoListId;
    }

    /**
     * @return string
     */
    public function getTodoId(): string
    {
        return $this->todoId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getTodoListId(): string
    {
        return $this->todoListId;
    }
}