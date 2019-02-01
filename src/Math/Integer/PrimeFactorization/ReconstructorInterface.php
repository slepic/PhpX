<?php

namespace PhpX\Math\Integer\PrimeFactorization;

interface ReconstructorInterface
{
    /**
     * Reconstructs the original integer from its prime factors.
     *
     * @param iterable $factors
     * @return int
     */
    public function reconstructFromPrimeFactors(iterable $factors): int;
}
