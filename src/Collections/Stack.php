<?php

namespace PhpX\Collections;

class Stack implements StackInterface
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
		return \reset($this->data);
	}

	public function pop()
	{
		return \array_shift($this->data);
	}

	public function push($value)
	{
		$this->data[] = $value;
		return $this;
	}
}
