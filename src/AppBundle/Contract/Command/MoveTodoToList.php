<?php

namespace AppBundle\Contract\Command;

class MoveTodoToList
{
    /**
     * @var string
     */
    private $todoId;
    /**
     * @var string
     */
    private $listId;


    /**
     * @param string $todoId
     * @param string $listId
     */
    public function __construct(string $todoId, string $listId)
    {
        $this->todoId = $todoId;
        $this->listId = $listId;
    }


    /**
     * @return string
     */
    public function getTodoId(): string
    {
        return $this->todoId;
    }
}