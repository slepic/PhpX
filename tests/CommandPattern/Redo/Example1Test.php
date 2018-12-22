<?php

namespace PhpX\Tests\CommandPattern\Redo;

use PHPUnit\Framework\TestCase;
use PhpX\CommandPattern\CommandInterface as Command;
use PhpX\CommandPattern\Undo\UndoableCommandInterface as UndoableCommand;
use PhpX\CommandPattern\Redo\RedoableCommandInterface as RedoableCommand;
use PhpX\CommandPattern\Redo\RedoableInvoker;
use PhpX\CommandPattern\Undo\UndoableInterface as Undoable;

class TestSwitch
{
    private $_on = false;

    public function isOn(): bool
    {
        return $this->_on;
    }

    public function on()
    {
        $this->_on = true;
    }
    public function off()
    {
        $this->_on = false;
    }
}

abstract class SwitchCommand implements UndoableCommand, RedoableCommand
{
    protected $sw;
    private $inverseCommand;

    public function __construct(TestSwitch $switch, SwitchCommand $inverseCommand)
    {
        $this->sw = $switch;
        $this->inverseCommand = $inverseCommand;
    }

    public function getUndoCommand(): Command
    {
        return $this->inverseCommand;
    }

    public function getRedoCommand(): Command
    {
        return $this->inverseCommand;
    }
}

class OnCommand extends SwitchCommand
{
    public function __construct(TestSwitch $switch, OffCommand $off = null)
    {
        parent::__construct($switch, $off ?: new OffCommand($switch, $this));
    }

    public function execute(): void
    {
        $this->sw->on();
    }
}

class OffCommand extends SwitchCommand
{
    public function __construct(TestSwitch $switch, OnCommand $on = null)
    {
        parent::__construct($switch, $on ?: new OnCommand($switch, $this));
    }

    public function execute(): void
    {
        $this->sw->off();
    }
}


class OnOffCommand implements UndoableCommand, RedoableCommand
{
    private $sw;

    public function __construct(TestSwitch $switch)
    {
        $this->sw = $switch;
    }

    public function execute(): void
    {
        if ($this->sw->isOn()) {
            $this->sw->off();
        } else {
            $this->sw->on();
        }
    }

    public function getUndoCommand(): Command
    {
        return $this;
    }

    public function getRedoCommand(): Command
    {
        return $this;
    }
}

class Example1Test extends TestCase
{
    public function test1()
    {
        $invoker = new RedoableInvoker();
        $switch = $this->createMock(TestSwitch::class);
        $switch->expects($this->exactly(6))
            ->method('on');
        $switch->expects($this->exactly(6))
            ->method('off');

        $onCommand = new OnCommand($switch);
        $invoker->executeCommand($onCommand);
        $invoker->undo();
        $invoker->redo();
        $invoker->undo();
        $invoker->redo();
        $invoker->undo();

        $offCommand = new OffCommand($switch);
        $invoker->executeCommand($offCommand);
        $invoker->undo();
        $invoker->redo();
        $invoker->undo();
        $invoker->redo();
        $invoker->undo();
    }

    public function test2()
    {
        $invoker = new RedoableInvoker();
        $switch = $this->createMock(TestSwitch::class);
        $switch->method('isOn')
            ->willReturnOnConsecutiveCalls(false, true, false, true, false, true, false, true);
        $switch->expects($this->exactly(3))
            ->method('on');
        $switch->expects($this->exactly(3))
            ->method('off');

        $onCommand = new OnOffCommand($switch);
        $invoker->executeCommand($onCommand);
        $invoker->undo();
        $invoker->redo();
        $invoker->undo();
        $invoker->redo();
        $invoker->undo();
    }
}
