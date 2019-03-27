<?php

namespace PhpX\Collections\Iterators;

use Iterator;

/**
 * This is a filter iterator based on the items' position in the iterator.
 * The following expression denotes the rule for accepting an item by the filter:
 *      $position % $divisor === $acceptedModulo
 *
 * Except that the modulo operation is never actualy invoked.
 * Instead it takes advantage of the period of the modulo function to skip fixed number of items.
 *
 * @example $oddNumbers = new ModuloIterator(new ArrayIterator([0,1,2,3,4,5]), 2, 1); //[1,3,5]
 *          $oddAreThePositions = new ModuloIterator(new ArrayIterator([2,3,5,7,11,13]), 2, 1); //[3,7,13] because the position in the input iteraotor matters
 *          $evenNumbers = new ModuloIterator(new ArrayIterator([0,1,2,3,4,5]), 2, 0); //[0,2,4]
 */
class ModuloIterator implements Iterator
{
    private $iterator;
    private $divisor;
    private $acceptedModulo;

    /**
     * @param Iterator $iterator The iterator to be filtered
     * @param int $divisor The modulo divisor operand.
     *      Providing value less then 1 will lead to an iterator that never leaves the first item of the inner iterator.
     * @param int $acceptedModulo Accepted modulo value.
     *      Actual modulo function never returns values higher nor equal to the divisor,
     *      but providing such a value to this argument will lead to simply skipping this much items off the beginning of the inner iterator.
     */
    public function __construct(Iterator $iterator, int $divisor, int $acceptedModulo = 0)
    {
        $this->iterator = $iterator;
        $this->divisor = $divisor;
        $this->acceptedModulo = $acceptedModulo;
    }

    public function rewind()
    {
        $this->iterator->rewind();
        $this->skip($this->acceptedModulo);
    }

    public function next()
    {
        $this->skip($this->divisor);
    }

    /**
     * @param $count Number of items of the inner iterator to skip
     */
    private function skip(int $count)
    {
        while ($this->iterator->valid() && $count > 0) {
            $this->iterator->next();
            --$count;
        }
    }

    public function valid()
    {
        return $this->iterator->valid();
    }

    public function key()
    {
        return $this->iterator->key();
    }

    public function current()
    {
        return $this->iterator->current();
    }
}
