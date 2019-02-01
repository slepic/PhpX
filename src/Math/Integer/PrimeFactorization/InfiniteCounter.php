<?php

namespace PhpX\Math\Integer\PrimeFactorization;

use SeekableIterator;

/**
 * Counts from a given integer by one toward maximum integer
 */
class InfiniteCounter implements SeekableIterator
{
    /**
     * @var int Start position used for rewind
     */
    private $start;

    /**
     * @var int Current position of the conuter
     */
    private $position;

    /**
     * Initialize the counter starting position
     */
    public function __construct(int $start = 0)
    {
        $this->start = $start;
        $this->position = $start;
    }

    public function rewind(): void
    {
        $this->position = $this->start;
    }

    /**
     * The iterator will only become invalid when the counter overflows.
     */
    public function valid(): bool
    {
        return $this->position >= $this->start;
    }

    public function key(): int
    {
        return $this->position;
    }

    public function current(): int
    {
        return $this->position;
    }

    public function next(): void
    {
        ++$this->position;
    }

    public function seek($position)
    {
        if ($position < $this->start) {
            throw new OutOfBoundsException();
        }
        $this->position = $position;
    }
}
