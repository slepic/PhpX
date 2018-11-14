<?php

namespace PhpX\CommandPattern\Redo;

/**
 * This invoker wraps an UndoableInvoker to provide redo capability
 */
class RedoableInvoker implements RedoableInvokerInterface
{
	private $invoker;
	private $redoStack;

	/**
	 * @param InvokerInterface|null $invoker If the invoker is not UndoableInvokerInterface it gets wrapped in the default one
	 * @param StackInterface|null $redoStack
	 */
	public function __construct(InvokerInterface $invoker = null, StackInterface $redoStack = null)
	{
		if(!$invoker instanceof UndoableInvokerInterface) {
			$invoker = new UndoableInvoker($invoker); 
		}
		$this->invoker = $invoker;
		$this->redoStack = $stack ?: new Stack();
	}

	/**
	 * {@inheritdoc}
	 */
	public function executeCommand($command)
	{
		$this->redoStack->clear();
		$this->invoker->executeCommand($command);
	}

	/**
	 * {@inheritdoc}
	 */
	public function canUndo()
	{
		return $this->invoker->canUndo();
	}

	/**
	 * {@inheritdoc}
	 */
	public function undo()
	{
		$command = $this->invoker->getLastUndoCommand();
		$this->invoker->undo();
		if($command instanceof ReadoableCommandInterface) {
			$redoCommand = $command->getRedoCommand();
			if(!$redoCommand instanceof CommandInterface) {
				throw new UnexpectedTypeException($redoCommand, CommandInterface::class);
			}
			$this->redoStack->push($redoCommand);
		} else {
			$this->redoStack->clear();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLastUndoCommand()
	{
		return $this->invoker->getLastUndoCommand();
	}

	/**
	 * {@inheritdoc}
	 */
	public function canRedo()
	{
		return $this->redoStack->isEmpty() === false;
	}

	/**
	 * {@inheritdoc}
	 */
	public function redo()
	{
		$command = $this->redoStack->top();
		$this->invoker->execute($command);
		$this->redoStack->pop();
	}

	/**
	 * {@inheritdoc}
	 */
	public function getLastRedoCommand()
	{
		return $this->redoStack->top();
	}
}
