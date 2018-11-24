<?php

namespace PhpX\Tests\Collections\Iterators;

use \PHPUnit\Framework\TestCase;
use \PhpX\Collections\Iterators\BackwardIterator;

class BackwardIteratorTest extends ArrayIteratorTest
{
	protected function createTwoWayIteratorInterfaceInstance(array $testData)
	{
		$arrayIterator = parent::createTwoWayIteratorInterfaceInstance($testData);	
		return new BackwardIterator($arrayIterator);
	}
}
