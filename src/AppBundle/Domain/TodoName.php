<?php


namespace AppBundle\Domain;


class TodoName
{
    /**
     * @var string
     */
    private $todoName;

    /**
     * TodoListId constructor.
     * @param string $todoName
     */
    public function __construct(string $todoName)
    {
        $this->todoName = $todoName;
    }

    public function __toString()
    {
        return $this->todoName;
    }
}