<?php

namespace PhpX\Math\Integer\PrimeFactorization;

class Formatter implements FormatterInterface
{
    private $reconstructor;
    private $powerSign;
    private $timesSign;
    private $equalSign;

    public function __construct(
        ReconstructorInterface $reconstructor = null,
        string $powerSign = '^',
        string $timesSign = ' * ',
        string $equalSign = ' = '
    ) {
        $this->reconstructor = $reconstructor ?: new Reconstructor();
        $this->powerSign = $powerSign;
        $this->timesSign = $timesSign;
        $this->equalSign = $equalSign;
    }

    public function formatPrimeFactors(iterable $factors): string
    {
        $sum = $this->reconstructor->reconstructFromPrimeFactors($factors);
        $parts = [];
        foreach ($factors as $prime => $power) {
            $parts[] = $prime . $this->powerSign . $power;
        }
        return implode($this->timesSign, $parts) . $this->equalSign . $sum;
    }
}
