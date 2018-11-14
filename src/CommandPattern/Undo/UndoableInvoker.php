<?php

namespace PhpX\CommandPattern\Undo;

use PhpX\CommandPattern\InvokerInterface;
use PhpX\CommandPattern\LastInvoker;
use PhpX\Collections\StackInterface;
use PhpX\Collections\Stack;
use PhpX\CommandPattern\Undo\UndoableInterface;
use PhpX\CommandPattern\Undo\UndoableCommandInterface;

class UndoableInvoker implements InvokerInterface, UndoableInterface
{
	private $invoker;
	private $undoStack;

	public function __construct(InvokerInterface $invoker = null, StackInterface $undoStack = null)
	{
		$this->invoker = $invoker ?: new LastInvoker();
		$this->undoStack = $undoStack ?: new Stack();
	}

	/**
	 * @return InvokerInterface
	 */
	public function getInnerInvoker()
	{
		return $this->invoker;
	}

	/**
	 * @return StackInterface
	 */
	public function getUndoStack()
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
	public function executeCommand(CommandInterface $command)
	{
		$this->invoker->executeCommand($command);
		if($command instanceof UndoableCommandInterface) {
			$undoCommand = $command->getUndoCommand();
			if(!$undoCommand instanceof CommandInterface) {
				throw new UnexpectedTypeException($undoCommand, CommandInterface::class);
			}
			$this->undoStack->push($undoCommand);
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function canUndo()
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
	public function undo()
	{
		$command = $this->undoStack->top();
		$this->invoker->executeCommand($command);
		$this->undoStack->pop();
	}
}
