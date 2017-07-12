<?php

namespace AppBundle\Contract\Command;

class DeleteTodo
{
    /**
     * @var string
     */
    private $todoId;


    /**
     * @param string $todoId
     */
    public function __construct(string $todoId)
    {
        $this->todoId = $todoId;
    }

    /**
     * @return string
     */
    public function getTodoId(): string
    {
        return $this->todoId;
    }
}