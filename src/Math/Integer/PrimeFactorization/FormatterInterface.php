<?php

namespace PhpX\Math\Integer\PrimeFactorization;

/**
 * Interface for objects that can format prime factorization into a nice readable equation.
 *
 * @note Since equation of prime factorization is a sum of powers,
 * it might be replaced by more general interface which does just that.
 */
interface FormatterInterface
{
    public function formatPrimeFactors(iterable $iterable): string;
}
