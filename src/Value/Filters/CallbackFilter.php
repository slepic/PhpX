<?php

namespace PhpX\Value\Filters;

use PhpX\Value\FilterInterface as Filter;

/**
 * @generic class CallbackFilter<ValueType> implements Filter<ValueType>
 */
class CallbackFilter implements Filter
{
    private $callback;

    /**
     * @param callable<ArgumentList<ValueType>, bool>
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function isAccepted($item): bool
    {
        return \call_user_func_array($this->callback, [$item]);
    }
}
