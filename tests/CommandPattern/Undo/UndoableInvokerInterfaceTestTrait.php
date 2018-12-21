<?php

namespace PhpX\Tests\CommandPattern\Undo;

use PhpX\CommandPattern\Undo\UndoableInvokerInterface as UndoableInvoker;
use PhpX\CommandPattern\Undo\UndoableCommandInterface as UndoableCommand;
use PhpX\CommandPattern\CommandInterface as Command;

trait UndoableInvokerInterfaceTestTrait
{
    abstract protected function createUndoableInvoker(): UndoableInvoker;

    public function testGetLastExecutedCommand()
    {
        $undoCommand = $this->createMock(Command::class);
        $command = $this->createMock(UndoableCommand::class);
        $command->method('getUndoCommand')
            ->willReturn($undoCommand);
        $command->expects($this->once())
            ->method('getUndoCommand');
        $invoker = $this->createUndoableInvoker();
        $invoker->executeCommand($command);
        $this->assertTrue($invoker->canUndo());
        $this->assertSame($undoCommand, $invoker->getLastUndoCommand());
    }

    public function testCannotUndoTwice()
    {
        $command = $this->createMock(UndoableCommand::class);
        $command->expects($this->once())
            ->method('execute');
        $command->expects($this->once())
            ->method('getUndoCommand');
        $invoker = $this->createUndoableInvoker();
        $invoker->executeCommand($command);
        $this->assertTrue($invoker->canUndo());
        $invoker->undo();
        $this->assertFalse($invoker->canUndo());
    }

    public function testCanUndoAsMuchAsExecuted()
    {
        $count = 5;
        $commands = [];
        for ($i=0; $i<$count; ++$i) {
            $undoCommand = $this->createMock(Command::class);
            $undoCommand->expects($this->once())
                ->method('execute');
            $command = $this->createMock(UndoableCommand::class);
            $command->method('getUndoCommand')
                ->willReturn($undoCommand);
            $command->expects($this->once())
                ->method('execute');
            $command->expects($this->once())
                ->method('getUndoCommand');
            $commands[$i] = $command;
            $undoCommands[$i] = $undoCommand;
        }
        $invoker = $this->createUndoableInvoker();

        foreach ($commands as $i => $command) {
            $invoker->executeCommand($command);
            $this->assertTrue($invoker->canUndo());
            $this->assertSame($undoCommands[$i], $invoker->getLastUndoCommand());
        }
        for ($i=$count - 1; $i > 0; --$i) {
            $invoker->undo();
            $this->assertTrue($invoker->canUndo());
            $this->assertSame($undoCommands[$i-1], $invoker->getLastUndoCommand());
        }
        $invoker->undo();
        $this->assertFalse($invoker->canUndo());
    }
}
