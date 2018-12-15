<?php

namespace PhpX\Collections;

/**
 * Interface for object which can convert themselves to array.
 *
 * This allows simple analysis using PHP built-in array functions.
 * Or the client may wrap the result in an ArrayObject to gain object-style wrapper for the built-in array functions.
 *
 * example:
 *
 * $x = new class implements ArrayAggregateInterface {...};
 *
 * $a = $x->getArrayCopy();
 * $keys = \array_keys($a);
 * $trimmed = \array_map('trim', $a);
 * //...and so on...
 */
interface ArrayAggregateInterface
{
    /**
     * Get array representation of the object state.
     *
     * @return array
     */
    public function getArrayCopy(): array;
}
