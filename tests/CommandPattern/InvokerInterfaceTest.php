<?php

namespace PhpX\Tests\CommandPattern;

use \PhpX\CommandPattern\CommandInterface;
use \PhpX\CommandPattern\InvokerInterface;
use \PHPUnit\Framework\TestCase;

abstract class InvokerInterfaceTest extends TestCase
{
	protected $invoker;

	public function setUp()
	{
		$this->invoker = $this->createInvoker();
	}

	abstract protected function createInvoker();

	public function testCallExecete()
	{
		$command = $this->createMock(CommandInterface::class);
		$command->expects($this->once())->method('execute');

		$this->invoker->executeCommand($command);
	}
}
