<?php


namespace AppBundle\Domain;


class TodoListId
{
    /**
     * @var string
     */
    private $todolistId;

    /**
     * TodoListId constructor.
     * @param string $todolistId
     */
    public function __construct(string $todolistId)
    {
        $this->todolistId = $todolistId;
    }

    public function __toString()
    {
        return $this->todolistId;
    }
}