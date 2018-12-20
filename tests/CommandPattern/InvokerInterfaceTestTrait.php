<?php

namespace PhpX\Tests\CommandPattern;

use \PhpX\CommandPattern\CommandInterface;

/**
 * @method createInvoker() Implement this method to create the InvokerInterface implementation instance.
 */
trait InvokerInterfaceTestTrait
{
    public function testCallExecute()
    {
        $command = $this->createMock(CommandInterface::class);
        $command->expects($this->once())->method('execute');

        $invoker = $this->createInvoker();
        $invoker->executeCommand($command);
    }
}
