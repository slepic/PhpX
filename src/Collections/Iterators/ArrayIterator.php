<?php

namespace PhpX\Collections\Iterators;

class ArrayIterator implements TwoWayIteratorInterface
{
    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function prev()
    {
        \prev($this->data);
    }

    public function next()
    {
        \next($this->data);
    }

    public function current()
    {
        return \current($this->data);
    }

    public function key()
    {
        return \key($this->data);
    }

    public function rewind()
    {
        \reset($this->data);
    }

    public function end()
    {
        \end($this->data);
    }

    public function valid()
    {
        return $this->key() !== null;
    }

    public function getBackwardIterator()
    {
        return new BackwardIterator($this);
    }
}
