<?php

namespace PhpX\Tests\Collections;

use PHPUnit\Framework\TestCase;
use PhpX\Collections\IteratorInputChannel as Channel;
use Exception;
use ArrayIterator;

class IteratorInputChannelTest extends TestCase
{
    public function testEmpty()
    {
        $iterator = new ArrayIterator([]);
        $channel = new Channel($iterator);
        $this->assertTrue($channel->isEmpty());
    }

    public function testTopEmptyThrows()
    {
        $iterator = new ArrayIterator([]);
        $channel = new Channel($iterator);
        $this->expectException(Exception::class);
        $channel->top();
    }

    public function testExtractEmptyThrows()
    {
        $iterator = new ArrayIterator([]);
        $channel = new Channel($iterator);
        $this->expectException(Exception::class);
        $channel->extract();
    }

    public function testOneTwoThree()
    {
        $iterator = new ArrayIterator([1,2,3]);
        $channel = new Channel($iterator);
        for ($i=0; $i<2; ++$i) {
            $this->assertFalse($channel->isEmpty());
            $this->assertSame(1, $channel->top());
            $this->assertSame(1, $channel->extract());
            $this->assertFalse($channel->isEmpty());
            $this->assertSame(2, $channel->top());
            $this->assertSame(2, $channel->extract());
            $this->assertFalse($channel->isEmpty());
            $this->assertSame(3, $channel->top());
            $this->assertSame(3, $channel->extract());
            $this->assertTrue($channel->isEmpty());
            $iterator->rewind();
        }
    }
}
