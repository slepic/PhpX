<?php

namespace PhpX\Tests\Collections\Iterators;

use PHPUnit\Framework\TestCase;
use PhpX\Collections\Iterators\IteratorAggregateIterator;
use ArrayObject;

class IteratorAggregateIteratorTest extends TestCase
{
    /**
     * @dataProvider provideValidData
     */
    public function testValidData(array $data)
    {
        $input = new ArrayObject($data);
        $i = new IteratorAggregateIterator($input);
        $output = iterator_to_array($i);
        $this->assertSame($data, $output);

        $input[] = 'new';

        $output2 = iterator_to_array($i);
        $this->assertSame($input->getArrayCopy(), $output2);
    }

    public function provideValidData()
    {
        return [
            [[1,2,3]]
        ];
    }
}
