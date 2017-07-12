<?php


namespace AppBundle\CommandHandling;


use AppBundle\Contract\Command\CreateTodoList;
use AppBundle\Contract\Command\DeleteTodoList;
use AppBundle\Domain\TodoList;
use AppBundle\Domain\TodoListId;
use AppBundle\Domain\TodoListName;
use Broadway\CommandHandling\SimpleCommandHandler;
use Broadway\Repository\Repository;

final class TodoListHandler extends SimpleCommandHandler
{
    /**
     * @var Repository
     */
    private $repository;


    /**
     * @param Repository $repository
     */
    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param CreateTodoList $command
     */
    protected function handleCreateTodoList(CreateTodoList $command)
    {
        $this->repository->save(TodoList::create(new TodoListId($command->getListId()),
            new TodoListName($command->getName())));
    }

    /**
     * @param DeleteTodoList $command
     */
    protected function handleDeleteTodoList(DeleteTodoList $command)
    {
        /** @var TodoList $todoList */
        $todoList = $this->repository->load($command->getListId());
        $todoList->delete();
        $this->repository->save($todoList);
    }
}