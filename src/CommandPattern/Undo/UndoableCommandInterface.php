<?php

namespace PhpX\CommandPattern\Undo;

use \PhpX\CommandPattern\CommandInterface;

interface UndoableCommandInterface extends CommandInterface
{
    /**
     * @return CommandInterface
     */
    public function getUndoCommand(): CommandInterface;
}
