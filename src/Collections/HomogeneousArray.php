<?php

namespace PhpX\Collections;

abstract class HomogeneousArray
extends ArrayObject
{
	function __construct(array $array = null) {
		parent::__construct();
		if($array !== null) {
			$this->exchangeArray($array);
		}
	}


	/**
	 * Checks if $item can be stored under the $key and throws exception otherwise.
	 *
	 * It also allows changing the key before storing the value.
	 *
	 * @param mixed $item
	 * @param string|int|null $key
	 * @return string|int|null Returns the key to store the item under.
	 */
	abstract protected function offsetCheck($item, $key = null);

	function offsetSet($key, $value) {
		$realKey = $this->offsetCheck($value, $key);
		return parent::offsetSet($realKey, $value);
	}

	function exchangeArray($array) {
		$ret = parent::exchangeArray([]);
		foreach($array as $key => $value) {
			$this[$key] = $value;
		}
		return $ret;
	}
}
