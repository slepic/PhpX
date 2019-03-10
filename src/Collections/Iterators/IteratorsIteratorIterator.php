<?php

namespace PhpX\Collections\Iterators;

use Iterator;
use IteratorAggregate;
use PhpX\TypeHint\InvalidTypeException;

/**
 * Sequentialy iterates over many iterators represented by iterator of iterators.
 */
class IteratorsIteratorIterator implements Iterator
{
    private $iterators;
    private $currentIterator;

    public function __construct(Iterator $iterators)
    {
        $this->iterators = $iterators;
    }

    private function getCurrentIterator(): Iterator
    {
        $currentIterator = $this->iterators->current();
        while ($currentIterator instanceof IteratorAggregate) {
            $currentIterator = $currentIterator->getIterator();
        }
        return $currentIterator;
    }

    public function rewind(): void
    {
        $this->iterators->rewind();
        if ($this->iterators->valid()) {
            $this->currentIterator = $this->getCurrentIterator();
            $this->currentIterator->rewind();
            $this->skipEmptyIterators();
        } else {
            $this->currentIterator = null;
        }
    }

    public function next(): void
    {
        $this->currentIterator->next();
        $this->skipEmptyIterators();
    }

    private function skipEmptyIterators(): void
    {
        while (!$this->currentIterator->valid()) {
            $this->iterators->next();
            if ($this->iterators->valid()) {
                $this->currentIterator = $this->getCurrentIterator();
                $this->currentIterator->rewind();
            } else {
                $this->currentIterator = null;
                break;
            }
        }
    }

    public function valid(): bool
    {
        return $this->currentIterator !== null;
    }

    public function current()
    {
        return $this->currentIterator->current();
    }

    public function key()
    {
        return $this->currentIterator->key();
    }
}
