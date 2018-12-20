<?php

namespace PhpX\Tests\CommandPattern;

use \PHPUnit\Framework\TestCase;
use \PhpX\CommandPattern\LastInvoker;

class LastInvokerTest extends TestCase
{
    use InvokerInterfaceTestTrait;

    protected function createInvoker()
    {
        return new LastInvoker();
    }
}
