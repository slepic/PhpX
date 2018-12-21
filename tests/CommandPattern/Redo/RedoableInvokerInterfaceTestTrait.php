<?php

namespace PhpX\Tests\CommandPattern\Redo;

use PhpX\CommandPattern\Redo\RedoableInvokerInterface as RedoableInvoker;
use PhpX\CommandPattern\Redo\RedoableCommandInterface as RedoableCommand;
use PhpX\CommandPattern\Undo\UndoableCommandInterface as UndoableCommand;
use PhpX\CommandPattern\CommandInterface as Command;

trait RedoableInvokerInterfaceTestTrait
{
    abstract protected function createRedoableInvoker(): RedoableInvoker;

    public function testCanRedoUndoneCommand()
    {
        $redoCommand = $this->createMock(Command::class);
        $redoCommand->expects($this->once())
            ->method('execute');
        $undoCommand = $this->createMock(RedoableCommand::class);
        $undoCommand->method('getRedoCommand')
            ->willReturn($redoCommand);
        $undoCommand->expects($this->once())
            ->method('execute');
        $undoCommand->expects($this->once())
            ->method('getRedoCommand');
        $command = $this->createMock(UndoableCommand::class);
        $command->method('getUndoCommand')
            ->willReturn($undoCommand);
        $command->expects($this->once())
            ->method('execute');
        $command->expects($this->once())
            ->method('getUndoCommand');
        $invoker = $this->createRedoableInvoker();
        $this->assertFalse($invoker->canUndo());
        $this->assertFalse($invoker->canRedo());
        $invoker->executeCommand($command);
        $this->assertTrue($invoker->canUndo());
        $this->assertFalse($invoker->canRedo());
        $invoker->undo();
        $this->assertFalse($invoker->canUndo());
        $this->assertTrue($invoker->canRedo());
        $invoker->redo();
        $this->assertFalse($invoker->canUndo());
        $this->assertFalse($invoker->canRedo());
    }
    
    public function testCanUndoRedoneCommand()
    {
        $undoRedoCommand = $this->createMock(Command::class);
        $redoCommand = $this->createMock(UndoableCommand::class);
        $redoCommand->method('getUndoCommand')
            ->willReturn($undoRedoCommand);
        $redoCommand->expects($this->once())
            ->method('execute');
        $redoCommand->expects($this->once())
            ->method('getUndoCommand');
        $redoCommand->expects($this->once())
            ->method('execute');
        $undoCommand = $this->createMock(RedoableCommand::class);
        $undoCommand->method('getRedoCommand')
            ->willReturn($redoCommand);
        $undoCommand->expects($this->once())
            ->method('execute');
        $undoCommand->expects($this->once())
            ->method('getRedoCommand');
        $command = $this->createMock(UndoableCommand::class);
        $command->method('getUndoCommand')
            ->willReturn($undoCommand);
        $command->expects($this->once())
            ->method('execute');
        $command->expects($this->once())
            ->method('getUndoCommand');
        $invoker = $this->createRedoableInvoker();
        $this->assertFalse($invoker->canUndo());
        $this->assertFalse($invoker->canRedo());
        $invoker->executeCommand($command);
        $this->assertTrue($invoker->canUndo());
        $this->assertFalse($invoker->canRedo());
        $invoker->undo();
        $this->assertFalse($invoker->canUndo());
        $this->assertTrue($invoker->canRedo());
        $invoker->redo();
        $this->assertTrue($invoker->canUndo());
        $this->assertFalse($invoker->canRedo());
        $invoker->undo();
        $this->assertFalse($invoker->canUndo());
        $this->assertFalse($invoker->canRedo());
    }
}
