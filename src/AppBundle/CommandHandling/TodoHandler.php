<?php

namespace AppBundle\CommandHandling;

use AppBundle\Contract\Command\CreateTodo;
use AppBundle\Contract\Command\DeleteTodo;
use AppBundle\Domain\Todo;
use AppBundle\Domain\TodoId;
use AppBundle\Domain\TodoList;
use AppBundle\Domain\TodoName;
use Broadway\CommandHandling\SimpleCommandHandler;
use Broadway\Repository\Repository;

final class TodoHandler extends SimpleCommandHandler
{
    /**
     * @var Repository
     */
    private $todoRepository;
    /**
     * @var Repository
     */
    private $todoListRepository;


    /**
     * @param Repository $todoRepository
     * @param Repository $todoListRepository
     */
    public function __construct(Repository $todoRepository, Repository $todoListRepository)
    {
        $this->todoRepository = $todoRepository;
        $this->todoListRepository = $todoListRepository;
    }

    /**
     * @param CreateTodo $command
     */
    protected function handleCreateTodo(CreateTodo $command)
    {
        /** @var TodoList $todoList */
        $todoList = $this->todoListRepository->load($command->getTodoListId());
        $todo = $todoList->addTodo(new TodoId($command->getTodoId()), new TodoName($command->getName()));
        $this->todoRepository->save($todo);
    }

    /**
     * @param DeleteTodo $command
     */
    protected function handleDeleteTodo(DeleteTodo $command)
    {
        /** @var Todo $todoList */
        $todoList = $this->todoRepository->load($command->getTodoId());
        $todoList->delete();
        $this->todoRepository->save($todoList);
    }
}