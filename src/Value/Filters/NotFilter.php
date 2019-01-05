<?php

namespace PhpX\Value\Filters;

use PhpX\Value\FilterInterface as Filter;

/**
 * @generic class NotFilter<ValueType> implements Filter<ValueType>
 */
class NotFilter implements Filter
{
    private $filter;

    public function __construct(Filter $filter)
    {
        $this->filter = $filter;
    }

    public function isAccepted($item): bool
    {
        return false === $this->filter->isAccepted($item);
    }
}
