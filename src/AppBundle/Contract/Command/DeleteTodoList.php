<?php

namespace AppBundle\Contract\Command;

class DeleteTodoList
{
    /**
     * @var string
     */
    private $listId;


    /**
     * @param string $listId
     */
    public function __construct(string $listId)
    {
        $this->listId = $listId;
    }

    /**
     * @return string
     */
    public function getListId(): string
    {
        return $this->listId;
    }
}