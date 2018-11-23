<?php

namespace PhpX\Collections;

interface QueueInterface//<ValueType>
{
	/**
	 * @return bool
	 */
	public function isEmpty();

	/**
	 * @param ValueType $value
	 * @return void
	 */
	public function enqueue($value);

	/**
	 * @return ValueType
	 */
	public function dequeue();
}

