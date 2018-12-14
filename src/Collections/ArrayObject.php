<?php

namespace PhpX\Collections;

use JsonSerializable;
use ArrayAccess;

/**
 * Array wrapper
 */
class ArrayObject implements
	StackInterface,
	QueueInterface,
	KeyedCollectionInterface,
	ArrayAccess,
//	ValueObject,
//	ArrayConvertible,
	JsonSerializable
//	Clonable
{
	/**
	 * @var array
	 */
	private $data = [];

	/**
	 * @param array|Traversable|null $value
	 */
	public function __construct($value = null)
	{
		if($value !== null) {
			$this->setValue($value);
		}
	}

	/********************
	 * EmptiableInterface
	 *********************/

	public function isEmpty()
	{
		return empty($this->data);
	}

	public function clear()
	{
		$this->data = [];
		return $this;
	}


	/******************
	 * StackInterface
	 *****************/

	public function top()
	{
		return $this->last();
	}

	public function pop()
	{
		return $this->removeLast();
	}

	public function push($value)
	{
		return $this->append($value);
	}

	/*********************
	 * QueueInterface
	 * *******************/

	public function enqueue($value)
	{
		return $this->prepend($value);
	}

	public function dequeue()
	{
		return $this->removeLast();
	}

	/*******************
	 * Countable
	 *******************/

	public function count()
	{
		return \count($this->data);
	}

	/****************************
	 * ArrayConvertibleInterface
	 ****************************/

	public function toArray()
	{
		return $this->data;
	}

	public function fromArray(array $array)
	{
		$this->data = $array;
	}

	public function fromIterator(Traversable $iterator)
	{
		$this->data = [];
		foreach($iterator as $key => $item)
		{
			$this->data[$key] = $item;
		}
	}

	/*********************
	 * IteratorAggregate
	 * *******************/

	public function getIterator()
	{
		return new ArrayIterator($this->data);
	}

	/***********************
	 * ValueObjectInterface
	 ***********************/

	public function getValue(): array
	{
		return $this->data;
	}

	/**
	 * @param iterable $value
	 */
	public function setValue($value)
	{
		if(\is_array($value)) {
			$this->fromArray($value);
		} else if($value instanceof Traversable) {
			$this->fromIterator($value);
		} else {
			throw new InvalidTypeException('iterable', $value);
		}
		return $this;
	}

	/***********************
	 * JsonSerializable
	 *************************/

	public function jsonSerialize()
	{
		return $this->data;
	}

	/*************************
	 * ContainerInterface
	 * **********************/

	public function has($key): bool
	{
		return $this->offsetExists($key);
	}

	public function get($key)
	{
		return $this->data[$key];
	}

	/************************
	 * CollectionInterface
	 * **********************/

	public function contains($item): bool
	{
		return $this->indexOf($item) !== false;
	}

	public function add($item)
	{
		$this->append($item);
	}

	public function remove($item)
	{
		$key = $this->indexOf($item);
		if($key !== false)
		{
			unset($this[$key]);
			return true;
		}
		return false;
	}

	/************************
	 * KeyedCollectionInterface
	 * **********************/

	public function indexOf($item)
	{
		return \array_search($item, $this->data);
	}

	public function set($key, $value)
	{
		$this->data[$key] = $value;
	}

	public function removeKey($key)
	{
		unset($this->data[$key]);
	}

	/*******************************
	 * ArrayAccess
	 * ****************************/

	public function offsetExists($key)
	{
		return \array_key_exists($key, $this->data);
	}

	public function offsetGet($key)
	{
		return $this->get($key);
	}

	public function offsetSet($key, $value)
	{
		if($key === null) {
			$this->push($value);
		} else {
			$this->set($key, $value);
		}
	}

	public function offsetUnset($key)
	{
		$this->removeKey($key);
	}

	/*******************
	 * ArrayInterface
	 * ****************/

	public function keys()
	{
		return new self(\array_keys($this->data));
	}


	public function first()
	{
		return \reset($this->data);
	}

	public function last()
	{
		return \end($this->data);
	}

	public function firstKey()
	{
		\reset($this->data);
		return \key($this->data);
	}

	public function lastKey()
	{
		\end($this->data);
		return \key($this->data);
	}

	public function prepend($value)
	{
		\array_unshift($this->data, $value);
		return $this;
	}

	public function prepended($value)
	{
		$clone = $this->getClone();
		$clone->prepend($value);
		return $clone;
	}

	public function removeFirst()
	{
		return \array_shift($this->data);
	}

	public function append($value)
	{
		\array_push($this->data, $value);
		return $this;
	}

	public function removeLast()
	{
		return \array_pop($this->data);
	}

	public function flip()
	{
		$this->data = \array_flip($this->data);
		return $this;
	}

	public function flipped()
	{
		return new self(\array_flip($this->data));
	}

	/*********************
	 * ListInterface
	 *********************/

	public function insertBefore($item, $before)
	{
	}

	public function insertBeforeKey($item, $beforeKey)
	{
	}

	public function insertAfter($item, $after)
	{
	}

	public function insertAfterKey($item, $afterKey)
	{
	}

	/*********************
	 * ClonableInterface
	 ********************/

	public function getClone()
	{
		return clone $this;
	}
}

