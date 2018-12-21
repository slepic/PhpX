<?php

namespace PhpX\CommandPattern\Redo;

use PhpX\CommandPattern\Undo\UndoableInterface;

interface RedoableInterface extends UndoableInterface
{
    public function canRedo(): bool;
    public function redo(): void;
}
