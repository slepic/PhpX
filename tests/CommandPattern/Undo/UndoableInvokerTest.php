<?php

namespace PhpX\Tests\CommandPattern\Undo;

use PHPUnit\Framework\TestCase;
use PhpX\CommandPattern\Undo\UndoableInvoker;
use PhpX\CommandPattern\Undo\UndoableCommandInterface as UndoableCommand;
use PhpX\CommandPattern\CommandInterface as Command;
use PhpX\CommandPattern\InvokerInterface as Invoker;
use PhpX\Collections\StackInterface as Stack;

class UndoableInvokerTest extends TestCase
{
    public function testDefaultConstructor()
    {
        $invoker = new UndoableInvoker();
        $this->assertInstanceOf(Invoker::class, $invoker->getInnerInvoker());
        $this->assertInstanceOf(Stack::class, $invoker->getUndoStack());
    }

    public function testDefaultStackConstructor()
    {
        $fallback = $this->createMock(Invoker::class);
        $invoker = new UndoableInvoker($fallback);
        $this->assertSame($fallback, $invoker->getInnerInvoker());
        $this->assertInstanceOf(Stack::class, $invoker->getUndoStack());
    }

    public function testConstructor()
    {
        $fallback = $this->createMock(Invoker::class);
        $stack = $this->createMock(Stack::class);
        $invoker = new UndoableInvoker($fallback, $stack);
        $this->assertSame($fallback, $invoker->getInnerInvoker());
        $this->assertSame($stack, $invoker->getUndoStack());
    }

    public function testGetLastExecutedCommand()
    {
        $undoCommand = $this->createMock(Command::class);
        $command = $this->createMock(UndoableCommand::class);
        $command->method('getUndoCommand')
            ->willReturn($undoCommand);
        $command->expects($this->once())
            ->method('getUndoCommand');
        $invoker = new UndoableInvoker();
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
        $invoker = new UndoableInvoker();
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
        $invoker = new UndoableInvoker();

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
