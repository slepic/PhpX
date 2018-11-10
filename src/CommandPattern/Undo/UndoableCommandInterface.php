<?php

namespace PhpX\CommandPatter\Undo;

interface UndoableCommandInterface extends CommandInterface;
{
	/**
	 * @return CommandInterface
	 */
	public function getUndoCommand();
}
