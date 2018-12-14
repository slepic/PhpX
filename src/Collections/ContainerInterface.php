<?php

namespace PhpX\Collections;

/**
 * @note Possibly alias for \Psr\Container\ContainerInterface
 *
 * Generic:
 * interface ContainerInterface<KeyType, ValueType>
 */
interface ContainerInterface
{
	/**
	 * @param KeyType $key
	 * @return bool
	 */
	public function has($key);

	/**
	 * @param KeyType $key
	 * @return ValueType
	 */
	public function get($key);
}

