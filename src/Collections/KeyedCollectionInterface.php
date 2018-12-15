<?php

namespace PhpX\Collections;

use ArrayAccess;

/**
 * @generic interface KeyedCollectionInterface<KeyType, ValueType> extends
 * 	CollectionInterface<ValueType>,
 * 	ContainerInterface<Key,Type, ValueType>,
 * 	IteratorAggregate<KeyType, ValueType>
 */
interface KeyedCollectionInterface extends CollectionInterface, ContainerInterface
{
	/**
	 * @param ValueType $item
	 * @return KeyType|null
	 */
	public function indexOf($item);

	/**
	 * @param KeyType $key
	 * @param ValueType $value
	 * @return void
	 */
	public function set($key, $value);

	/**
	 * @param KeyType $key
	 * @return void
	 */
	public function removeKey($key);
}

