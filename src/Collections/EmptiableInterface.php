<?php

namespace PhpX\Collections;

interface EmptiableInterface
{
	/**
	 * @return bool
	 */
	public function isEmpty();

	/**
	 * @return void
	 */
	public function clear();
}
