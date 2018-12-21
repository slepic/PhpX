<?php

namespace PhpX\Tests\CommandPattern\Undo;

use PHPUnit\Framework\TestCase;
use PhpX\CommandPattern\Undo\UndoableInterface as Undoable;
use PhpX\CommandPattern\Undo\UndoCommand;

class UndoCommandTest extends TestCase
{
    public function testExecuteUndo()
    {
        $undoable = $this->createMock(Undoable::class);
        $undoable->expects($this->once())
            ->method('undo');
        $command = new UndoCommand($undoable);
        $command->execute();
    }
}
