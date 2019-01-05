<?php

namespace PhpX\Collections;

use PhpX\Value\FilterInterface as Filter;
use PhpX\Collections\UnderflowableInterface as Underflowable;
use Countable;
use is_array;
use count;
use PhpX\TypeHint\InvalidTypeException;

/**
 * This filter accepts items that are empty.
 *
 * @generic class UnderflowFilter implements FilterInterface<Underflowable|Countable|array>
 */
class UnderflowFilter implements Filter
{
    public function isAccepted($item): bool
    {
        if ($item instanceof Underflowable) {
            return $item->isEmpty();
        }
        if (is_array($item) || $item instanceof Countable) {
            return count($item) === 0;
        }
        throw new InvalidTypeException(
            [
                Underflowable::class,
                Countable::class,
                'array',
            ],
            $item
        );
    }
}
