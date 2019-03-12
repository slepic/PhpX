<?php

namespace PhpX\Collections\Iterators;

use Iterator;
use IteratorAggregate;
use OuterIterator;

class IteratorAggregateIterator implements Iterator, OuterIterator
{
    private $aggregate;
    private $iterator;

    public function __construct(IteratorAggregate $aggregate)
    {
        $this->aggregate = $aggregate;
    }

    public function getInnerIterator()
    {
        if ($this->iterator === null) {
            $this->rewind();
        }
        return $this->iterator;
    }

    public function rewind()
    {
        $this->iterator = $this->aggregate->getIterator();
    }

    public function next()
    {
        $this->getInnerIterator()->next();
    }

    public function valid()
    {
        return $this->getInnerIterator()->valid();
    }

    public function current()
    {
        return $this->getInnerIterator()->current();
    }

    public function key()
    {
        return $this->getInnerIterator()->key();
    }

    public function __call($name, $args)
    {
        return \call_user_func_array([$this->getInnerIterator(), $name], $args);
    }
}
