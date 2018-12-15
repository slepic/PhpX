<?php

namespace PhpX\TypeHint;

/**
 * @generic interface ValueObjectInterface<ValueType>
 */
interface ValueObjectInterface
{
    /**
     * @return ValueType
     */
    public function getValue();

    /**
     * @param ValueType $value
     */
    public function setValue($value);
}
