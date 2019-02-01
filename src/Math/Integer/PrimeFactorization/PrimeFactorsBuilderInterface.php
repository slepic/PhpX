<?php

namespace PhpX\Math\Integer\PrimeFactorization;

use IteratorAggregate;

interface PrimeFactorsBuilderInterface extends IteratorAggregate
{
    public function add(int $prime): void;
}
