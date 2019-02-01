<?php

namespace PhpX\Tests\Math\Integer\PrimeFactorization;

use PHPUnit\Framework\TestCase;
use PhpX\Math\Integer\PrimeFactorization\SimpleFactorizer;

class SimpleFactorizerTest extends TestCase
{
    /**
     * @dataProvider provideFactorizationData
     */
    public function testFactorization(int $value, array $expect): void
    {
        $factorizer = new SimpleFactorizer();
        $factors = $factorizer->getPrimeFactors($value);
        $count = 0;
        foreach ($factors as $prime => $power) {
            $this->assertTrue(isset($expect[$prime]));
            $this->assertSame($expect[$prime], $power);
            ++$count;
        }
        $this->assertSame(\count($expect), $count);
    }

    /**
     * @return array
     */
    public function provideFactorizationData(): array
    {
        return [
            [1, []],
            [2, [2 => 1]],
            [3, [3 => 1]],
            [4, [2 => 2]],
            [5, [5 => 1]],
            [6, [2 => 1, 3 => 1]],
            [7, [7 => 1]],
            [8, [2 => 3]],
            [9, [3 => 2]],
            [10, [2 => 1, 5 => 1]],
            [11, [11 => 1]],
            [12, [2 => 2, 3 => 1]],
            [13, [13 => 1]],
            [14, [2 => 1, 7 => 1]],
            [15, [3 => 1, 5 => 1]],
            [16, [2 => 4]],
            [17, [17 => 1]],
            [18, [2 => 1, 3 => 2]],
            [19, [19 => 1]],
            [20, [2 => 2, 5 => 1]],
        ];
    }
}
