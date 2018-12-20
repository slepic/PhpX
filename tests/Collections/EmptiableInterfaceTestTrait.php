<?php

namespace PhpX\Tests\Collections;

/**
 * Class using this trait must implement following methods:
 *
 * @method createEmptyEmptiableInterfaceInstance
 * @method createNonEmptyEmptiableInterfaceInstance
 */
trait EmptiableInterfaceTestTrait
{
    public function testEmpty()
    {
        $emptiable = $this->createEmptyEmptiableInterfaceInstance();
        $this->assertTrue($emptiable->isEmpty());
        if ($emptiable instanceof \Countable) {
            $this->assertSame(0, \count($emptiable));
        }
    }

    public function testNonEmpty()
    {
        $emptiable = $this->createNonEmptyEmptiableInterfaceInstance();
        $this->assertFalse($emptiable->isEmpty());
        if ($emptiable instanceof \Countable) {
            $this->assertTrue(0 < \count($emptiable));
        }

        $emptiable->clear();
        $this->assertTrue($emptiable->isEmpty());
    }
}
