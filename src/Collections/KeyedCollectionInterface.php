<?php

namespace PhpX\Collections;

use ArrayAccess;

/**
 * @generic interface KeyedCollectionInterface<KeyType, ValueType> extends
 * 	CollectionInterface<ValueType>,
 * 	ArrayAccess<Key,Type, ValueType>,
 * 	IteratorAggregate<KeyType, ValueType>
 */
interface KeyedCollectionInterface extends CollectionInterface, ArrayAccess, ArrayExchangableInterface
{
}
