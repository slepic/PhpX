<?php

/**
 * Basic implementation of undo which allows redo by reruning the original command
 */
class ReadoableUndoCommand implements ReadoableCommandInterface
{
	private $command;

	public function __construct(CommandInterface $command)
	{
		$this->command = $command;
	}

	public function execute()
	{
		$this->command->undo();
	}

	public function getRedoCommand()
	{
		return $this->command;
	}
}

/**
 * Basic implementation of redo which call the redo method of given RedoableInterface
 */
class RedoCommand implements CommandInterface, RedoableInterface
{
	private $command;

	public function __construct(ReadoableInterface $command)
	{
		$this->command = $command;
	}

	public function execute()
	{
		$this->command->redo();
	}
}

/**
 * Basic implementation of redo command which allows to undo again
 */
class UndoableRedoCommand extends RedoCommand implements UndoableCommandInterface
{
	public function getUndoCommand()
	{
		return $this->command;
	}
}
