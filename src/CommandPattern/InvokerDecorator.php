<?php

namespace PhpX\CommandPattern;

use PhpX\CommandPattern\InvokerInterface as Invoker;
use PhpX\CommandPattern\LastInvoker as DefaultInvoker;
use PhpX\CommandPattern\CommandInterface as Command;

class InvokerDecorator implements Invoker
{
    private $invoker;

    public function __construct(Invoker $invoker = null)
    {
        $this->setInnerInvoker($invoker ?: new DefaultInvoker());
    }

    public function getInnerInvoker(): Invoker
    {
        return $this->invoker;
    }

    public function setInnerInvoker(Invoker $invoker)
    {
        $this->invoker = $invoker;
        return $this;
    }

    public function executeCommand(Command $command): void
    {
        $this->getInnerInvoker()->executeCommand($command);
    }
}
