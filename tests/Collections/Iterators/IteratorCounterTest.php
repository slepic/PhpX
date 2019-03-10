<?php

namespace PhpX\Tests\Collections\Iterators;

use PHPUnit\Framework\TestCase;
use PhpX\Collections\Iterators\IteratorCounter;
use Iterator;
use ArrayIterator;
use EmptyIterator;
use stdClass;
use OutOfBoundsException;

class IteratorCounterTest extends TestCase
{
    /**
     * @dataProvider provideValidDataSets
     */
    public function testValidDataSets(array $input)
    {
        $expectedOutput = array_values($input);
        $inputIterator = new ArrayIterator($input);
        $iterator = new IteratorCounter($inputIterator);
        $output = iterator_to_array($iterator);
        $this->assertSame($expectedOutput, $output);
    }

    public function provideValidDataSets(): array
    {
        return [
            //empty set
            [[]],

            //already counted set is same
            [[1,2,3]],

            //simple set
            [[1 => 1, 2 => 2, 3 => 3]],

        //generic set
            [[1 => new stdClass(), 'x' => 100, 'abc' => 'def']],
        ];
    }

    /**
     * @dataProvider provideSeekData
     */
    public function testSeek(array $input, array $positions)
    {
        $inputValues = array_values($input);
        $inputIterator = new ArrayIterator($input);
        $counter = new IteratorCounter($inputIterator);
        foreach ($positions as $position) {
            if (isset($inputValues[$position])) {
                $expectedCurrent = $inputValues[$position];
            } else {
                $this->expectException(OutOfBoundsException::class);
            }
            $counter->seek($position);
            $this->assertTrue($counter->valid());
            $this->assertSame($position, $counter->key());
            $this->assertSame($expectedCurrent, $counter->current());
        }
    }

    public function provideSeekData(): array
    {
        return [
            //same as normal iteration
            [[10,20,30], [0,1,2]],

            //inversed iteration
            [[10,20,30], [2,1,0]],

            //mid repeated
            [[10,20,30], [1,1,1,1]],

            //many random seeks
            [[10,20,30], [2,1,0,1,2,1,0,2,2,1,1,0,0]],

            //out of bound seek
            [[10,20,30], [5]],
        ];
    }
}
