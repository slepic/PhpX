<?php

namespace PhpX\Tests\Collections\Iterators;

use PHPUnit\Framework\TestCase;
use PhpX\Collections\Iterators\IteratorsIteratorIterator;
use Iterator;
use EmptyIterator;
use ArrayIterator;
use ArrayObject;

class IteratorsIteratorIteratorTest extends TestCase
{
    /**
     * @dataProvider provideValidDataSets
     */
    public function testValidDataSets(Iterator $input, array $expectedOutput)
    {
        $iterator = new IteratorsIteratorIterator($input);
        $output = iterator_to_array($iterator);
        $this->assertSame($expectedOutput, $output);
    }

    public function provideValidDataSets(): array
    {
        return [
            //empty set
            [new EmptyIterator(), []],

            //simple set
            [new ArrayIterator([
                new ArrayIterator([1,2,3]),
                new ArrayIterator([3=>11,4=>22,5=>33]),
            ]), [1,2,3,11,22,33]],

            //set with empty iterators to be skipped
            [new ArrayIterator([
                new EmptyIterator(),
                new ArrayIterator([1,2,3]),
                new EmptyIterator(),
                new ArrayIterator([3=>11,4=>22,5=>33]),
                new EmptyIterator(),
            ]), [1,2,3,11,22,33]],

            //IteratorAggregates work too
            [new ArrayIterator([
                new ArrayObject([1,2,3]),
                new ArrayObject([3=>11,4=>22,5=>33]),
            ]), [1,2,3,11,22,33]],
        ];
    }
}
