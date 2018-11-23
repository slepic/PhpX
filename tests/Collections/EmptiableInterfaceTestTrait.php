<?php

namespace PhpX\Tests\Collections;

/**
 * Class using this trait must implement following methods:
 *
 * @method createEmptyEmptiableInterfaceInstace
 * @method createNonEmptyEmptiableInterfaceInstace
 */
trait EmptiableInterfaceTestTrait
{
	public function testEmpty()
	{
		$emptiable = $this->createEmptyEmptiableInterfaceInstance();
		$this->assertTrue($emptiable->isEmpty());
	}

	public function testNonEmpty()
	{
		$emptiable = $this->createNonEmptyEmptiableInterfaceInstance();
		$this->assertFalse($emptiable->isEmpty());

		$emptiable->clear();
		$this->assertTrue($emptiable->isEmpty());
	}
}

