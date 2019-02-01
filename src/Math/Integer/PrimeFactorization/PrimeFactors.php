<?php

namespace PhpX\Math\Integer\PrimeFactorization;

use ArrayIterator;

class PrimeFactors implements
    PrimeFactorsBuilderInterface,
    PrimeFactorsBuilderFactoryInterface
{
    private $factors = [];

    public function add(int $prime): void
    {
        if (isset($this->factors[$prime])) {
            ++$this->factors[$prime];
        } else {
            $this->factors[$prime] = 1;
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->factors);
    }

    public function createPrimeFactorsBuilder(): PrimeFactorsBuilderInterface
    {
        return new self();
    }
}
