<?php

namespace PhpX\CommandPattern\Undo;

/**
 * This is basic undo implementation for UndoableCommandInterface::getUndoCommand()
 *
 * Usage:
 *
 *
 * class MyUndoableCommand implements UndoableCommandInterface, UndoableInterface
 *                     You want implement this ^^     And you need this ^^ to do it
 * {
 *	<!-- UndoableCommandInterface -->
 *
 * 	public function execute()
 * 	{
 * 		//some code..
 * 	}
 *
 * 	public function getUndoCommand()
 * 	{
 * 		//and this is the basic implementation of the UndoableCommandInterface using your UndoableInterface implementation.
 * 		return new UndoCommand($this);
 * 	}
 *
 *	<!-- UndoableInterface -->
 *
 *	public function canUndo()
 *	{
 *		//some checks etc.
 *	}
 *
 * 	public function undo()
 * 	{
 * 		//undo code...
 * 	}
 *
 * }
 */
class UndoCommand implements CommandInterface
{
    private $command;

    public function __construct(UndoableInterface $command)
    {
        $this->command = $command;
    }

    /**
     * This method simply calls the Undoable's undo method.
     */
    public function execute()
    {
        $this->command->undo();
    }
}
