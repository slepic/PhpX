<?php

namespace PhpX\Math\Integer\PrimeFactorization;

use ArrayAccess;

/**
 * Provides caching over any FactorizerInterface implementation.
 */
class CachingFactorizer implements FactorizerInterface
{
    /**
     * @var ArrayAccess
     */
    private $cache;

    /**
     * @var FactorizerInterface
     */
    private $factorizer;

    /**
     * @param FactorizerInterface $factorizer
     * @param ArrayAccess $cache
     */
    public function __construct(FactorizerInterface $factorizer, ArrayAccess $cache = null)
    {
        $this->factorizer = $factorizer;
        $this->cache = $cache ?: new ArrayObject();
    }

    /**
     * {@inheritdoc}
     */
    public function getPrimeFactors(int $value): iterable
    {
        if (isset($this->cache[$value])) {
            return $this->cache[$value];
        }
        $factors = $this->factorizer->getPrimeFactors($value);
        $this->cache[$value] = $factors;
        return $factors;
    }
}
