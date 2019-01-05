<?php

namespace PhpX\Collections;

/**
 * @generic interface InputChannelInterface<ValueType> extends UnderflowableInterface
 */
interface InputChannelInterface extends UnderflowableInterface
{
    /**
     * Get the next item in the channel.
     *
     * @return ValueType
     *
     * @throws Exception if empty
     */
    public function top();

    /**
     * Remove the next item from the channel.
     *
     * @return ValueType
     *
     * @throws Exception if empty
     */
    public function extract();
}
