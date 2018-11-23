<?php

namespace PhpX\Tests\Collections;

/**
 * Use this trait to provide basic tests for your StackInterface implementation.
 *
 * Implement createEmptyStack() method that will return an empty stack!
 */
trait StackInterfaceTestTrait
{
	public function testStackInterface()
	{
		$testValue1 = \rand();
		$testValue2 = $testValue1 + 1;

		$stack = $this->createEmptyStack();
		$this->assertTrue($stack->isEmpty());

		$stack->push($testValue1);
		$this->assertFalse($stack->isEmpty());
		$this->assertSame($testValue1, $stack->top());

		$stack->push($testValue2);
		$this->assertFalse($stack->isEmpty());
		$this->assertSame($testValue2, $stack->top());

		$this->assertSame($testValue2, $stack->pop());
		$this->assertFalse($stack->isEmpty());

		$this->assertSame($testValue1, $stack->pop());
		$this->assertTrue($stack->isEmpty());
	}

	public function testTopThrowsWhenStackIsEmpty()
	{
		$stack = $this->createEmptyStack();
		$this->assertTrue($stack->isEmpty());

		$this->expectException(\Exception::class);
		$stack->top();
	}

	public function testPopThrowsWhenStackIsEmpty()
	{
		$stack = $this->createEmptyStack();
		$this->assertTrue($stack->isEmpty());

		$this->expectException(\Exception::class);
		$stack->pop();
	}
}

