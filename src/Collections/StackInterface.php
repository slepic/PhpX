<?php

namespace PhpX\Collections;

/**
 * @generic inteface StackInterface<ValueType> extends EmptiableInterface
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
