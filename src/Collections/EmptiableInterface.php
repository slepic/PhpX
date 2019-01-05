<?php

namespace PhpX\Collections;

/**
 * Represents object that can be cleared off its contents.
 */
interface EmptiableInterface extends UnderflowableInterface
{

    /**
     * @return void
     */
    public function clear();
}
