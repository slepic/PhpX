<?php

namespace PhpX\Collections\Iterators;

interface TwoWayIteratorInterface extends \Iterator
{
    /**
     * Move iterator to previous element
     */
    public function prev();

    /**
     * Move iterator to the last element
     */
    public function end();
}
