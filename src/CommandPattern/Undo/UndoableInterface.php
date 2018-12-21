<?php

namespace PhpX\CommandPattern\Undo;

interface UndoableInterface
{
    /**
     * @return bool
     */
    public function canUndo(): bool;

    /**
     * @return void
     */
    public function undo(): void;
}
