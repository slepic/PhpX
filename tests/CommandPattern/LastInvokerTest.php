<?php

namespace PhpX\Tests\CommandPattern;

use \PhpX\CommandPattern\LastInvoker;

class LastInvokerTest extends InvokerInterfaceTest
{
	public function createInvoker()
	{
		return new LastInvoker();
	}
}
