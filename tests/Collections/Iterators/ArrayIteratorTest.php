<?php

namespace PhpX\Tests\Collections\Iterators;

use \PHPUnit\Framework\TestCase;
use \PhpX\Collections\Iterators\ArrayIterator;

class ArrayIteratorTest extends TestCase
{
	use TwoWayIteratorInterfaceTestTrait;

	protected function createTwoWayIteratorInterfaceInstance(array $testData)
	{
		return new ArrayIterator($testData);
	}
}
