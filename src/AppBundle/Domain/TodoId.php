<?php


namespace AppBundle\Domain;


class TodoId
{
    /**
     * @var string
     */
    private $todoId;

    /**
     * TodoListId constructor.
     * @param string $todoId
     */
    public function __construct(string $todoId)
    {
        $this->todoId = $todoId;
    }

    public function __toString()
    {
        return $this->todoId;
    }
}