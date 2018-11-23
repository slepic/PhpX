<?php

namespace PhpX\Collections;

interface StackInterface//<ValueType>
{
	/**
	 * @return bool
	 */
	public function isEmpty();

	/**
	 * @return ValueType
	 */
	public function top();

	/**
	 * @return ValueType
	 */
	public function pop();

	/**
	 * @param ValueType $value
	 * @return void
	 */
	public function push($value);

	/**
	 * @return void
	 */
	public function clear();
}
