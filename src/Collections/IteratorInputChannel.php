<?php

namespace PhpX\Collections;

use Iterator;
use Exception;

/**
 * Adapts an Iterator to provide InputChannelInterface
 *
 * @generic class IteratorInputChannel<ValueType> implements InputChannelInterface<ValueType>
 *
 * @todo Decorate iterator
 */
class IteratorInputChannel implements InputChannelInterface
{
    private $iterator;

    /**
     * @param Iterator<any, ValueType> $iterator
     */
    public function __construct(Iterator $iterator)
    {
        $this->iterator = $iterator;
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return false === $this->iterator->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function top()
    {
        if ($this->isEmpty()) {
            throw new Exception();
        }
        return $this->iterator->current();
    }

    /**
     * {@inheritdoc}
     */
    public function extract()
    {
        $top = $this->top();
        $this->iterator->next();
        return $top;
    }
}
