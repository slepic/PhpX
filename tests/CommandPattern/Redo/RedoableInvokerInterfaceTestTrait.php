<?php

namespace PhpX\Tests\CommandPattern\Redo;

use PhpX\CommandPattern\Undo\RedoableInvokerInterface as RedoableInvoker;

trait RedoableInvokerInterfaceTestTrait
{
    abstract protected function createRedoableInvoker(): RedoableInvoker;
}
