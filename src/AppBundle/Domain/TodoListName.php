<?php


namespace AppBundle\Domain;


class TodoListName
{
    /**
     * @var string
     */
    private $todoListName;

    /**
     * TodoListId constructor.
     * @param string $todoListName
     */
    public function __construct(string $todoListName)
    {
        $this->todoListName = $todoListName;
    }

    public function __toString()
    {
        return $this->todoListName;
    }
}