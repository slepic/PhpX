<?php

namespace PhpX\CommandPattern\Redo;

/**
 * Represents a command that can be redone after being undone
 *
 * This is actualy only useful to implement on an "UndoCommand"
 * which is any command returned by UndoableCommandInterface::getUndoCommand()
 */
interface RedoableCommandInterface extends CommandInterface
{
	/**
	 * @return CommandInterface
	 */
	public function getRedoCommand();
}
