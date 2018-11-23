<?php

namespace PhpX\Collections;

/**
 * StackInterface<ValueType>
 */
interface StackInterface extends EmptiableInterface
{
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
}
