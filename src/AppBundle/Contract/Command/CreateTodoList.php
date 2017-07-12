<?php

namespace AppBundle\Contract\Command;

class CreateTodoList
{
    /**
     * @var string
     */
    private $listId;

    /**
     * @var string
     */
    private $name;


    /**
     * CreateTodoList constructor.
     * @param string $listId
     * @param string $name
     */
    public function __construct(string $listId, string $name)
    {
        $this->listId = $listId;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getListId(): string
    {
        return $this->listId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}