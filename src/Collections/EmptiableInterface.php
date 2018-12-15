<?php

namespace PhpX\Collections;

/**
 * Represents object that can be cleared off its contents.
 */
interface EmptiableInterface
{
    /**
     * @return bool
     */
    public function isEmpty();

    /**
     * @return void
     */
    public function clear();
}
