<?php

namespace PhpX\Collections;

/**
 * Generic:
 * interface MapInterface<KeyType, ValueType>
 */
interface MapInterface
{
	/**
	 * @param KeyType $key
	 * @return bool
	 */
	public function has($key): bool;

	/**
	 * @param KeyType $key
	 * @return ValueType
	 */
	public function get($key);
}

