<?php

namespace PhpX\CommandPattern\Redo;

use PhpX\CommandPattern\Redo\RedoableInvokerInterface;
use PhpX\CommandPattern\Redo\RedoableCommandInterface as RedoableCommand;
use PhpX\CommandPattern\CommandInterface as Command;
use PhpX\CommandPattern\InvokerInterface as Invoker;
use PhpX\CommandPattern\InvokerDecorator;
use PhpX\CommandPattern\Undo\UndoableInvokerInterface as UndoableInvoker;
use PhpX\CommandPattern\Undo\UndoableInvoker as DefaultUndoableInvoker;
use PhpX\Collections\StackInterface as Stack;
use PhpX\Collections\ArrayObject as DefaultStack;

/**
 * This invoker wraps an UndoableInvoker to provide redo capability
 */
class RedoableInvoker extends InvokerDecorator implements RedoableInvokerInterface
{
    private $invoker;
    private $redoStack;

    /**
     * @param InvokerInterface|null $invoker If the invoker is not UndoableInvokerInterface it gets wrapped in the default one
     * @param StackInterface|null $redoStack
     */
    public function __construct(Invoker $invoker = null, Stack $redoStack = null)
    {
        if (!$invoker instanceof UndoableInvoker) {
            $invoker = new DefaultUndoableInvoker($invoker);
        }
        parent::__construct($invoker);
        $this->redoStack = $redoStack ?: new DefaultStack();
    }

    public function getRedoStack(): Stack
    {
        return $this->redoStack;
    }

    /**
     * {@inheritdoc}
     */
    public function executeCommand(Command $command): void
    {
        $this->redoStack->clear();
        parent::executeCommand($command);
    }

    /**
     * {@inheritdoc}
     */
    public function canUndo(): bool
    {
        return $this->getInnerInvoker()->canUndo();
    }

    /**
     * {@inheritdoc}
     */
    public function undo(): void
    {
        $command = $this->getLastUndoCommand();
        $this->getInnerInvoker()->undo();
        if ($command instanceof RedoableCommand) {
            $redoCommand = $command->getRedoCommand();
            $this->redoStack->push($redoCommand);
        } else {
            $this->redoStack->clear();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getLastUndoCommand(): Command
    {
        return $this->getInnerInvoker()->getLastUndoCommand();
    }

    /**
     * {@inheritdoc}
     */
    public function canRedo(): bool
    {
        return $this->redoStack->isEmpty() === false;
    }

    /**
     * {@inheritdoc}
     */
    public function redo(): void
    {
        $command = $this->redoStack->top();
        parent::executeCommand($command);
        $this->redoStack->pop();
    }

    /**
     * {@inheritdoc}
     */
    public function getLastRedoCommand(): Command
    {
        return $this->redoStack->top();
    }
}
