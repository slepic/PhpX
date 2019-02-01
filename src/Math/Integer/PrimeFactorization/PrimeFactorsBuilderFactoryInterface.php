<?php

namespace PhpX\Math\Integer\PrimeFactorization;

interface PrimeFactorsBuilderFactoryInterface
{
    public function createPrimeFactorsBuilder(): PrimeFactorsBuilderInterface;
}
