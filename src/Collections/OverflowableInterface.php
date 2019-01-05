<?php

namespace PhpX\Collections;

/**
 * Interface for objects that aggregate items and might run out of space for more items.
 */
interface OverflowableInterface
{
    /**
     * Tells if the collection is full.
     *
     * If the collection is full, it can accept no more items.
     * And if it offers methods to add items, they should throw Exception if called
     * when isFull would return true.
     *
     * @return bool
     */
    public function isFull(): bool;
}
