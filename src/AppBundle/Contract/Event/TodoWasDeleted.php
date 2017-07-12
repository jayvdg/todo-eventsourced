<?php

namespace AppBundle\Contract\Event;


class TodoWasDeleted
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
     * CreateTodoList constructor.
     * @param string $todoId
     * @param string $name
     */
    public function __construct(string $todoId, string $name)
    {
        $this->todoId = $todoId;
        $this->name = $name;
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
}