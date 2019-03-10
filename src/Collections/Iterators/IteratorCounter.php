<?php

namespace PhpX\Collections\Iterators;

use Iterator;
use SeekableIterator;
use OuterIterator;
use OutOfBoundsException;

/**
 * Counts iterated items of the inner iterator as they come and returns the current offset as keys of the iterator.
 *
 * let $x instanceof IteratorCounter
 * assert(iterator_to_array($x) === array_values(iterator_to_array($x)));
 */
class IteratorCounter implements SeekableIterator, OuterIterator
{
    private $iterator;
    private $position;

    /**
     * @param Iterator $iterator
     * @param int $position Can set the initial position, according to the iterator initial state. Call to rewind will reset this to zero.
     */
    public function __construct(Iterator $iterator, int $position = 0)
    {
        $this->iterator = $iterator;
        $this->position = $position;
    }

    public function getInnerIterator(): Iterator
    {
        return $this->iterator;
    }

    public function rewind(): void
    {
        $this->iterator->rewind();
        $this->position = 0;
    }

    public function next(): void
    {
        $this->iterator->next();
        ++$this->position;
    }

    public function valid(): bool
    {
        return $this->iterator->valid();
    }

    public function current()
    {
        return $this->iterator->current();
    }

    public function key()
    {
        return $this->position;
    }

    public function seek($position)
    {
        if ($position < $this->position) {
            if ($position !== 0 && $this->iterator instanceof TwoWayIteratorInterface) {
                while ($position < $this->position) {
                    if (!$this->valid()) {
                        throw new OutOfBoundsException();
                    }
                    $this->iterator->prev();
                    --$this->position;
                }
            } else {
                $this->rewind();
            }
        }
        while ($position > $this->position) {
            if (!$this->valid()) {
                throw new OutOfBoundsException();
            }
            $this->next();
        }
        if (!$this->valid()) {
            throw new OutOfBoundsException();
        }
    }
}
