<?php

namespace PhpX\Collections;

use \Countable;
use \IteratorAggregate;
use \ArrayIterator;
use \Exception as StackEmptyException;

class Stack implements
	StackInterface,
	Countable,
	IteratorAggregate
{
	private $data;

	public function __construct(array $data = [])
	{
		$this->data = $data;
	}

	public function isEmpty()
	{
		return empty($this->data);
	}

	public function clear()
	{
		$this->data = [];
		return $this;
	}

	public function top()
	{
		if($this->isEmpty()) {
			throw new StackEmptyException();
		}
		return \reset($this->data);
	}

	public function pop()
	{
		if($this->isEmpty()) {
			throw new StackEmptyException();
		}
		return \array_shift($this->data);
	}

	public function push($value)
	{
		\array_unshift($this->data, $value);
		return $this;
	}

	public function count()
	{
		return \count($this->data);
	}

	public function getIterator()
	{
		return new ArrayIterator($this->data);
	}
}
