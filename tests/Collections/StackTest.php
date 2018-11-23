<?php

namespace PhpX\Tests\Collections;

use \PHPUnit\Framework\TestCase;
use \PhpX\Collections\Stack;

class StackTest extends TestCase
{
	use StackInterfaceTestTrait;

	/**
	 * @return Stack
	 */
	protected function createEmptyStack()
	{
		return new Stack();
	}
}
