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
		$collection->offsetSet($testKey, $testValue);
		$this->assertTrue($collection->offsetExists($testKey));
		$this->assertSame($testValue, $collection->offsetGet($testKey));
	}
}

