<?php

namespace PhpX\Tests\Collections;

trait CountableTestTrait
{
    public function testCountsRight()
    {
        $expect = \rand(1, 100);
        $countable = $this->createCountableInstance($expect);

        $result = \count($countable);
        $this->assertSame($expect, $result);
    }
}
