<?php

namespace PhpX\CommandPattern\Redo;

use PhpX\CommandPattern\CommandInterface;
use PhpX\CommandPattern\Undo\UndoableInvokerInterface;
use PhpX\CommandPattern\Redo\RedoableInterface;

interface RedoableInvokerInterface extends UndoableInvokerInterface, RedoableInterface
{
    public function getLastRedoCommand(): CommandInterface;
}
