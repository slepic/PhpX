<?php

namespace PhpX\Tests\Collections;

use PHPUnit\Framework\TestCase;
use PhpX\Collections\ArrayObject;

class ArrayObjectTest extends TestCase
{
	use KeyedCollectionInterfaceTestTrait;

 	protected function createEmptyEmptiableInterfaceInstance()
	{
		return new ArrayObject();
	}

	protected function createNonEmptyEmptiableInterfaceInstance()
	{
		return new ArrayObject([0]);
	}

	protected function createCountableInstance(int $count): ArrayObject
	{
		return new ArrayObject(\range(1, $count));
	}

	protected function createCollectionInterfaceInstanceWithItem($item): ArrayObject
	{
		return new ArrayObject([$item]);
	}

	protected function createCollectionInterfaceInstanceWithoutItem($item): ArrayObject
	{
		return new ArrayObject();
	}
}
