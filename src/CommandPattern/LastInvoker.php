<?php

namespace PhpX\CommandPattern;

class LastInvoker implements InvokerInterface
{
    public function executeCommand(CommandInterface $command): void
    {
        $command->execute();
    }
}
