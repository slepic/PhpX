<?php

namespace PhpX\Collections;

/**
 * Interface for objects that aggregate items and can tell if they contain any items or none.
 *
 * This is similar to native PHP Countable interface,
 * except it can only tell if the count is zero or not.
 *
 * But in case this is exactly what the client is interested in,
 * it can get better performance through this interface
 * then it would get through the Countable interface.
 *
 * For example imagine a tree class that implements Countable to count its nodes recursively.
 * Counting them all to tell that it is not zero is unnessesarily expensive.
 * On the other hand, lookig that it contains no child on the first level is exponentialy faster for any tree deeper then 1.
 */
interface UnderflowableInterface
{
    /**
     * Tells if the collection is empty.
     *
     * If the implementor contains methods to remove objects they should throw Exception if called when isEmpty would return true.
     *
     * @return bool
     */
    public function isEmpty(): bool;
}
