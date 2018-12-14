<?php

namespace PhpX\Collections;

use IteratorAggregate;
use Countable;

/**
 * @generic interface CollectionInterface<ValueType> extends
 * 	IteratorAggregate<any, ValueType>,
 * 	Countable,
 * 	EmptiableInterface
 */
interface CollectionInterface extends
	IteratorAggregate,
	Countable,
	EmptiableInterface
{
	/**
	 * @param ValueType $item
	 * @return bool
	 */
	public function contains($item): bool;

	/**
	 * @param ValueType $item
	 */
	public function add($item);

	/**
	 * @param ValueType $item
	 */
	public function remove($item);
}

