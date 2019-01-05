<?php

namespace PhpX\Tests\Collections;

use PHPUnit\Framework\TestCase;
use PhpX\Collections\UnderflowFilter;
use PhpX\Collections\UnderflowableInterface as Underflowable;
use PhpX\TypeHint\InvalidTypeException;
use Countable;
use rand;
use range;
use BadMethodCallException;

class UnderflowFilterTest extends TestCase
{
    private $filter;

    protected function setUp()
    {
        $this->filter = new UnderflowFilter();
    }

    public function testEmptyUnderflowable()
    {
        $item = $this->createMock(Underflowable::class);
        $item->method('isEmpty')
            ->willReturn(true);
        $item->expects($this->once())
            ->method('isEmpty');
        $this->assertTrue($this->filter->isAccepted($item));
    }

    public function testNonEmptyUnderflowable()
    {
        $item = $this->createMock(Underflowable::class);
        $item->method('isEmpty')
            ->willReturn(false);
        $item->expects($this->once())
            ->method('isEmpty');
        $this->assertFalse($this->filter->isAccepted($item));
    }
    
    public function testEmptyCountable()
    {
        $item = $this->createMock(Countable::class);
        $item->method('count')
            ->willReturn(0);
        $item->expects($this->once())
            ->method('count');
        $this->assertTrue($this->filter->isAccepted($item));
    }

    public function testNonEmptyCountable()
    {
        $item = $this->createMock(Countable::class);
        $item->method('count')
            ->willReturn(rand(1, 500));
        $item->expects($this->once())
            ->method('count');
        $this->assertFalse($this->filter->isAccepted($item));
    }
    
    public function testEmptyArray()
    {
        $item = [];
        $this->assertTrue($this->filter->isAccepted($item));
    }

    public function testNonEmptyArray()
    {
        $item = range(1, rand(1, 5));
        $this->assertFalse($this->filter->isAccepted($item));
    }

    public function testInvalidTypeException()
    {
        $this->expectException(InvalidTypeException::class);
        $this->filter->isAccepted(null);
    }

    public function testUnderflowableBeforeCountable()
    {
        $item = new class implements Countable, Underflowable {
            public $called = 0;
            public function count(): int
            {
                throw new BadMethodCallException('count was not expected to be called.');
            }

            public function isEmpty(): bool
            {
                ++$this->called;
                return true;
            }
        };
        $this->filter->isAccepted($item);
        $this->assertSame(1, $item->called);
    }
}
