<?php

namespace PhpX\CommandPattern;

interface InvokerInterface
{
    /**
     * @param CommandInterface $command
     * @return void
     */
    public function executeCommand(CommandInterface $command): void;
}
