<?php

namespace PhpX\Tests\CommandPattern\Redo;

use PHPUnit\Framework\TestCase;
use PhpX\CommandPattern\Undo\UndoableInvokerInterface as UndoableInvoker;
use PhpX\CommandPattern\Redo\RedoableInvoker;
use PhpX\CommandPattern\InvokerInterface as Invoker;
use PhpX\Collections\StackInterface as Stack;
use PhpX\Tests\CommandPattern\InvokerInterfaceTestTrait;
use PhpX\Tests\CommandPattern\Undo\UndoableInvokerInterfaceTestTrait;
use PhpX\Tests\CommandPattern\Redo\RedoableInvokerInterfaceTestTrait;

class RedoableInvokerTest extends TestCase
{
    use InvokerInterfaceTestTrait;
    use UndoableInvokerInterfaceTestTrait;
    use RedoableInvokerInterfaceTestTrait;

    protected function createInvoker(): UndoableInvoker
    {
        return $this->createUndoableInvoker();
    }

    protected function createUndoableInvoker(): UndoableInvoker
    {
        return $this->createRedoableInvoker();
    }

    protected function createRedoableInvoker(): RedoableInvoker
    {
        return new RedoableInvoker();
    }

    public function testDefaultConstructor()
    {
        $invoker = $this->createRedoableInvoker();
        $this->assertInstanceOf(UndoableInvoker::class, $invoker->getInnerInvoker());
        $this->assertInstanceOf(Stack::class, $invoker->getRedoStack());
    }

    public function testDefaultStackConstructor()
    {
        $fallback = $this->createMock(UndoableInvoker::class);
        $invoker = new RedoableInvoker($fallback);
        $this->assertSame($fallback, $invoker->getInnerInvoker());
        $this->assertInstanceOf(Stack::class, $invoker->getRedoStack());
    }

    public function testConstructor()
    {
        $fallback = $this->createMock(UndoableInvoker::class);
        $stack = $this->createMock(Stack::class);
        $invoker = new RedoableInvoker($fallback, $stack);
        $this->assertSame($fallback, $invoker->getInnerInvoker());
        $this->assertSame($stack, $invoker->getRedoStack());
    }

    public function testFallbackWrapConstructor()
    {
        $fallback = $this->createMock(Invoker::class);
        $stack = $this->createMock(Stack::class);
        $invoker = new RedoableInvoker($fallback, $stack);
        $this->assertInstanceOf(UndoableInvoker::class, $invoker->getInnerInvoker());
        $this->assertSame($fallback, $invoker->getInnerInvoker()->getInnerInvoker());
        $this->assertSame($stack, $invoker->getRedoStack());
    }
}
