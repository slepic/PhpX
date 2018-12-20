<?php

namespace PhpX\CommandPattern\Undo;

interface UndoableInterface
{
    /**
     * @return bool
     */
    public function canUndo();

    /**
     * @return void
     */
    public function undo();
}
