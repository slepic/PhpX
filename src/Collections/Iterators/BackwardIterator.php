<?php

namespace PhpX\Collections\Iterators;

/**
 * Wraps any TwoWayIteratorInterface and provides iterator that iterates in backward direction.
 */
class BackwardIterator extends \IteratorIterator implements TwoWayIteratorInterface
{
    public function __construct(TwoWayIteratorInterface $iterator)
    {
        parent::__construct($iterator);
    }

    public function rewind()
    {
        return $this->getInnerIterator()->end();
    }

    public function end()
    {
        return $this->getInnerIterator()->rewind();
    }

    public function next()
    {
        return $this->getInnerIterator()->prev();
    }

    public function prev()
    {
        return $this->getInnerIterator()->next();
    }

    public function getBackwardIterator()
    {
        return $this->getInnerIterator();
    }
}
