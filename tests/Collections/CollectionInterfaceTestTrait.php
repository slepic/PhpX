<?php

namespace PhpX\Tests\Collections;

trait CollectionInterfaceTestTrait
{
    use EmptiableInterfaceTestTrait;
    use CountableTestTrait;

    public function testAdd()
    {
        $item = \md5(\time());
        $collection = $this->createCollectionInterfaceInstanceWithoutItem($item);
        $this->assertFalse($collection->contains($item));
        $collection->add($item);
        $this->assertTrue($collection->contains($item));
    }

    public function testRemove()
    {
        $item = \md5(\time());
        $collection = $this->createCollectionInterfaceInstanceWithItem($item);
        $this->assertTrue($collection->contains($item));
        $collection->remove($item);
        $this->assertFalse($collection->contains($item));
    }
}
