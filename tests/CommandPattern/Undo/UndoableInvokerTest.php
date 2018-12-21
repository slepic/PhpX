<?php

namespace PhpX\Tests\CommandPattern\Undo;

use PHPUnit\Framework\TestCase;
use PhpX\CommandPattern\Undo\UndoableInvoker;
use PhpX\CommandPattern\InvokerInterface as Invoker;
use PhpX\Collections\StackInterface as Stack;
use PhpX\Tests\CommandPattern\InvokerInterfaceTestTrait;
use PhpX\Tests\CommandPattern\Undo\UndoableInvokerInterfaceTestTrait;

class UndoableInvokerTest extends TestCase
{
    use InvokerInterfaceTestTrait;
    use UndoableInvokerInterfaceTestTrait;

    protected function createInvoker(): UndoableInvoker
    {
        return $this->createUndoableInvoker();
    }

    protected function createUndoableInvoker(): UndoableInvoker
    {
        return new UndoableInvoker();
    }

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
}
