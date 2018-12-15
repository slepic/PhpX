<?php

namespace PhpX\Collections;

use JsonSerializable;

/**
 * Array wrapper
 */
class ArrayObject implements //ArrayObjectInterface
	StackInterface,
	QueueInterface,
	KeyedCollectionInterface,
//	ValueObject,
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

	public function isEmpty(): bool
	{
		return \count($this) === 0;
	}

	public function clear(): self
	{
		return $this->exchangeArray([]);
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

	public function push($value): self
	{
		return $this->append($value);
	}

	/*********************
	 * QueueInterface
	 * *******************/

	public function enqueue($value): self
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

	public function count(): int
	{
		return \count($this->data);
	}

	/****************************
	 * ArrayAggregateInterface
	 ****************************/

	public function getArrayCopy(): array
	{
		return $this->data;
	}

	/****************************
	 * ArrayExchangableInterface
	 ****************************/

	public function exchangeArray(array $array): self
	{
		$this->data = $array;
		return $this;
	}

	/*********************
	 * IteratorAggregate
	 * *******************/

	public function getIterator(): \Iterator
	{
		return new ArrayIterator($this->data);
	}

	public function fromIterator(Traversable $iterator): self
	{
		$this->clear();
		foreach ($iterator as $key => $item) {
			$this[$key] = $item;
		}
		return $this;
	}

	/***********************
	 * ValueObjectInterface
	 ***********************/

	public function getValue(): array
	{
		return $this->data;
	}

	/**
	 * @param iterable|ArrayAggregateInterface $value
	 */
	public function setValue($value): self
	{
		if(\is_array($value)) {
			return $this->exchangeArray($value);
		} elseif ($value instanceof ArrayAggregateInterface) {
			return $this->exchangeArray($value->getArrayCopy());
		} else if($value instanceof Traversable) {
			return $this->fromIterator($value);
		}
		throw new InvalidTypeException(
			'iterable|' . ArrayAggregateInterface::class,
			$value
		);
	}

	/***********************
	 * JsonSerializable
	 *************************/

	public function jsonSerialize(): array
	{
		return $this->data;
	}

	/************************
	 * CollectionInterface
	 * **********************/

	public function contains($item): bool
	{
		return $this->indexOf($item) !== false;
	}

	public function add($item): self
	{
		return $this->append($item);
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

	/*******************************
	 * ArrayAccess
	 * ****************************/

	public function offsetExists($key)
	{
		return \array_key_exists($key, $this->data);
	}

	public function offsetGet($key)
	{
		return $this->data[$key];
	}

	public function offsetSet($key, $value)
	{
		if($key === null) {
			$this->add($value);
		} else {
			$this->data[$key] = $value;
		}
	}

	public function offsetUnset($key)
	{
		unset($this->data[$key]);
	}

	/*******************
	 * ArrayInterface
	 * ****************/

	public function indexOf($item)
	{
		return \array_search($item, $this->data, true);
	}

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

	public function prepend($value): self
	{
		\array_unshift($this->data, $value);
		return $this;
	}

	public function prepended($value): self
	{
		$clone = $this->getClone();
		$clone->prepend($value);
		return $clone;
	}

	public function removeFirst()
	{
		return \array_shift($this->data);
	}

	public function append($value): self
	{
		\array_push($this->data, $value);
		return $this;
	}

	public function removeLast()
	{
		return \array_pop($this->data);
	}

	public function flip(): self
	{
		$this->data = \array_flip($this->data);
		return $this;
	}

	public function flipped(): self
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

