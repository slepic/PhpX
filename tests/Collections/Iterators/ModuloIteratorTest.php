<?php

namespace PhpX\Tests\Collections\Iterators;

use PHPUnit\Framework\TestCase;
use PhpX\Collections\Iterators\ModuloIterator;
use ArrayIterator;

class ModuloIteratorTest extends TestCase
{
    /**
     * @dataProvider provideData
     */
    public function testData(array $data, int $divisor, int $acceptedModulo, array $expectedOutput)
    {
        $input = new ArrayIterator($data);
        $iterator = new ModuloIterator($input, $divisor, $acceptedModulo);
        $output = iterator_to_array($iterator);
        $this->assertSame($expectedOutput, $output);
    }

    public function provideData()
    {
        return [
            //evens
            [range(0, 5), 2, 0, [0 => 0, 2 => 2, 4 => 4]],
            //odds
            [range(0, 5), 2, 1, [1 => 1, 3 => 3, 5 => 5]],
            //multiples of three
            [range(0, 6), 3, 0, [0 => 0, 3 => 3, 6 => 6]],
            // %3 == 1
            [range(0, 7), 3, 1, [1 => 1, 4 => 4, 7 => 7]],
            // %3 == 2
            [range(0, 10), 3, 2, [2 => 2, 5 => 5, 8 => 8]],
            //position is what matters
            [[2,3,5,7,11,13,17,19,23], 3, 2, [2 => 5, 5 => 13, 8 => 23]],
            //position matters, but keys are preserved
            [[1 => 2,3,5,7,11,13,17,19,23], 3, 2, [3 => 5, 6 => 13, 9 => 23]],
        ];
    }
}
