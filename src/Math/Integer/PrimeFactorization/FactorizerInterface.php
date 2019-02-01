<?php

namespace PhpX\Math\Integer\PrimeFactorization;

/**
 * Interface for objects implementing prime factorization algorithm over integer data type.
 */
interface FactorizerInterface
{
    /**
     * Get an iterator of prime factors.
     *
     * @return iterable Returns iterator over pairs [p_k => n_k] where $value = SUM(p_k^n_k)
     * where p_k is prime, and n_k is its number of occurences in the prime factorization.
     */
    public function getPrimeFactors(int $value): iterable;
}
