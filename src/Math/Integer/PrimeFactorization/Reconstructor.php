<?php

namespace PhpX\Math\Integer\PrimeFactorization;

class Reconstructor implements ReconstructorInterface
{
    public function reconstructFromPrimeFactors(iterable $factors): int
    {
        $sum = 1;
        foreach ($factors as $prime => $power) {
            for ($i=0; $i<$power; ++$i) {
                $sum *= $prime;
            }
        }
        return $sum;
    }
}
