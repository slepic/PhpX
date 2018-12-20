<?php

namespace PhpX\Tests\Collections\Iterators;

trait TwoWayIteratorInterfaceTestTrait
{
    public function testForwardIsBackwardBackward()
    {
        $testData = [
            1 => 'a',
            'a' => 1,
            2 => 'b',
            'b' => 'c',
        ];
        $iterator = $this->createTwoWayIteratorInterfaceInstance($testData);

        $forward = \iterator_to_array($iterator);
        //$this->assertSame($testData, $forward);

        $backward = [];
        for ($iterator->end(); $iterator->valid(); $iterator->prev()) {
            $backward[$iterator->key()] = $iterator->current();
        }
        $this->assertSame($forward, \array_combine(\array_reverse(\array_keys($backward)), \array_reverse($backward)));
    }
}
