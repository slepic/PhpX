<?php

namespace PhpX\CommandPattern\Undo;

use PhpX\CommandPattern\CommandInterface as Command;
use PhpX\CommandPattern\InvokerInterface as Invoker;
use PhpX\CommandPattern\InvokerDecorator;
use PhpX\Collections\StackInterface as Stack;
use PhpX\Collections\ArrayObject as DefaultStack;
use PhpX\CommandPattern\Undo\UndoableCommandInterface as UndoableCommand;
use PhpX\CommandPattern\Undo\UndoableInvokerInterface;

/**
 * Basic implementation of undoable invoker.
 */
class UndoableInvoker extends InvokerDecorator implements UndoableInvokerInterface
{
    /**
     * @var Stack
     */
    private $undoStack;

    /**
     * @param Invoker|null $invoker
     * @param Stack|null $stack
     */
    public function __construct(Invoker $invoker = null, Stack $undoStack = null)
    {
        parent::__construct($invoker);
        $this->undoStack = $undoStack ?: new DefaultStack();
    }

    /**
     * @return Stack
     */
    public function getUndoStack(): Stack
    {
        return $this->undoStack;
    }

    /**
     * {@inheritdoc}
     *
     * If the coomand is an UndoableCommandInterface it can be undone later through the UndoableInterface methods.
     *
     * The execution of the command is delegated to the inner invoker.
     */
    public function executeCommand(Command $command): void
    {
        parent::executeCommand($command);
        if ($command instanceof UndoableCommand) {
            $undoCommand = $command->getUndoCommand();
            $this->undoStack->push($undoCommand);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function canUndo(): bool
    {
        return $this->undoStack->isEmpty() === false;
    }

    /**
     * {@inheritdoc}
     *
     * The execution of the undo command is delegated to the inner invoker.
     *
     * The undo command remains on stack if it's execution throws an Exception.
     */
    public function undo(): void
    {
        $command = $this->undoStack->top();
        parent::executeCommand($command);
        $this->undoStack->pop();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastUndoCommand(): Command
    {
        return $this->undoStack->top();
    }
}
