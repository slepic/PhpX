<?php

namespace PhpX\Tests\Collections;

trait KeyedCollectionInterfaceTestTrait
{
	use CollectionInterfaceTestTrait;

	public function testGetWhatIsSet()
	{
		$testKey = \md5(\time());
		$testValue = \md5($testKey);
		$collection = $this->createEmptyEmptiableInterfaceInstance();
		$this->assertTrue($collection->isEmpty());
		$collection->set($testKey, $testValue);
		$this->assertTrue($collection->has($testKey));
		$this->assertSame($testValue, $collection->get($testKey));
	}
}

