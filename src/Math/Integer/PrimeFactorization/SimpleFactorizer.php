<?php

namespace PhpX\Math\Integer\PrimeFactorization;

use Traversable;
use Exception;

/**
 * Simple implementation of prime factorization algorithm.
 *
 * Depends on an iterator of all primes and a builder of the prime factorization result.
 */
class SimpleFactorizer implements FactorizerInterface
{
    /**
     * @var Traversable<int>
     */
    private $primes;

    /**
     * @var PrimeFactorsBuilderFactoryInterface
     */
    private $factory;

    /**
     * @param Traversable<int>|null $primes Iterator over all primes in ascending order.
     *  But this factorizer actualy accepts iterator of superset of this as long as it starts from 2 and goes upwards.
     *  The iterator should contain all consecutive primes from 2 upwards. Although it is not that necessary
     *  if you know in advance what values you will pass to the factorizer once constructed.
     *  In such case you may only pass certain subsets of all primes.
     *  The iterator only needs to contain so many primes that will be used by any $value passed getPrimeFactors method.
     *  So in principle passing iterator of non cosecutive primes may still make this factorizer work for value that dont have
     *  a prime factor among the missing primes.
     *
     *  Current default implementation of primes iterator is an Infinite counter from 2 to max integer,
     *  Which makes this implementation excess even worse performance then it generaly does.
     */
    public function __construct(Traversable $primes = null, PrimeFactorsBuilderFactoryInterface $factory = null)
    {
        $this->primes = $primes ?: new InfiniteCounter(2);
        $this->factory = $factory ?: new PrimeFactors();
    }

    /**
     * {@inheritdoc}
     */
    public function getPrimeFactors(int $value): iterable
    {
        if ($value < 1) {
            throw new Exception('Expected natural number (N > 0), got ' . $value . '.');
        }
        $factors = $this->factory->createPrimeFactorsBuilder();
        if ($value < 2) {
            return $factors;
        }
        $current = $value;
        foreach ($this->primes as $prime) {
            if ($prime <= $current) {
                while ($current % $prime === 0) {
                    $factors->add($prime);
                    if ($prime === $current) {
                        return $factors;
                    }
                    $current /= $prime;
                }
            } else {
                $this->generatorError($value, $current, $factors, 'Skipped some prime number.');
            }
        }
        $this->generatorError($value, $current, $factors, 'Out of prime numbers.');
    }

    private function generatorError(int $value, int $current, PrimeFactorsBuilderInterface $factors, string $message = null)
    {
        throw new Exception(
            'Primes generator error' . (empty($message) ? '.' : (': ' . $message)) . \PHP_EOL
            . 'Factorizer: ' . \print_r($this, true)
            . 'Factorized value: ' . \print_r($value, true) . \PHP_EOL
            . 'Current reduced value: ' . \print_r($current, true) . \PHP_EOL
            . 'Current factors: ' . \print_r($factors, true)
        );
    }
}
