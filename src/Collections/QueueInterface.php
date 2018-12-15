<?php

namespace PhpX\Collections;

/**
 * @generic interface QueueInterface<ValueType> extends EmptiableInterface
 */
interface QueueInterface extends EmptiableInterface
{
    /**
     * @param ValueType $value
     * @return void
     */
    public function enqueue($value);

    /**
     * @return ValueType
     */
    public function dequeue();
}
