<?php


namespace AppBundle\Projection;


class Todo
{
    /**
     * @var string
     */
    private $todoId;
    /**
     * @var string
     */
    private $todoName;

    /**
     * @var bool
     */
    private $done;

    /**
     * @param string $todoId
     * @param string $todoName
     * @param bool $done
     */
    public function __construct(string $todoId, string $todoName, bool $done = false)
    {
        $this->todoId = $todoId;
        $this->todoName = $todoName;
        $this->done = $done;
    }
}