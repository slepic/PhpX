<?php

namespace PhpX\Value;

/**
 * Interface for objects that can filter values by some criteria.
 *
 * @generic interface FilterInterface<ValueType>
 */
interface FilterInterface
{
    /**
     * @param ValueType $item
     * @return bool
     * @throws Exception if $item is not of the implemented generic type.
     */
    public function isAccepted($item): bool;
}
