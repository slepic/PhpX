<?php

namespace PhpX\CommandPattern\Undo;

use PhpX\CommandPattern\InvokerInterface;
use PhpX\CommandPattern\CommandInterface;

interface UndoableInvokerInterface extends InvokerInterface, UndoableInterface
{
    /**
     * Returns last executed command
     *
     * Behaviour is undefined when no undoable command has been yet executed
     *
     * @return CommandInterface
     */
    public function getLastUndoCommand(): CommandInterface;
}
