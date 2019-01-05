<?php

namespace PhpX\Tests\Collections;

use PHPUnit\Framework\TestCase;
use PhpX\Collections\InputChannelIterator as ChannelIterator;
use PhpX\Collections\InputChannelInterface as Channel;

class InputChannelIteratorTest extends TestCase
{
    protected function setUp()
    {
        $this->channel = $this->createMock(Channel::class);
        $this->iterator = new ChannelIterator($this->channel);
    }

    public function testNonEmptyIsValid()
    {
        $this->channel->method('isEmpty')
            ->willReturn(false);
        $this->channel->expects($this->once())
            ->method('isEmpty');
        $this->assertTrue($this->iterator->valid());
    }

    public function testEmptyIsInvalid()
    {
        $this->channel->method('isEmpty')
            ->willReturn(true);
        $this->channel->expects($this->once())
            ->method('isEmpty');
        $this->assertFalse($this->iterator->valid());
    }

    public function testFirstIsTop()
    {
        $testValue = md5(time());
        $this->channel->method('top')
            ->willReturn($testValue);
        $this->channel->expects($this->never())
            ->method('isEmpty');
        $this->channel->expects($this->once())
            ->method('top');
        $this->channel->expects($this->never())
            ->method('extract');
        $this->assertSame($testValue, $this->iterator->current());
    }

    public function testNextExtracts()
    {
        $testValue = md5(time());
        $this->channel->method('top')
            ->willReturn($testValue);
        $this->channel->method('extract')
            ->willReturn($testValue);
        $this->channel->expects($this->never())
            ->method('isEmpty');
        $this->channel->expects($this->once())
            ->method('top');
        $this->channel->expects($this->once())
            ->method('extract');
        $this->assertSame($testValue, $this->iterator->current());
        $this->iterator->next();
    }

    public function testNextIsInvalid()
    {
        $testValue = md5(time());
        $this->channel->method('top')
            ->willReturn($testValue);
        $this->channel->method('extract')
            ->willReturn($testValue);
        $this->channel->method('isEmpty')
            ->willReturn(true);
        $this->channel->expects($this->once())
            ->method('isEmpty');
        $this->channel->expects($this->once())
            ->method('top');
        $this->channel->expects($this->once())
            ->method('extract');
        $this->assertSame($testValue, $this->iterator->current());
        $this->iterator->next();
        $this->assertFalse($this->iterator->valid());
    }

    public function testNextIsValid()
    {
        $testValue = md5(time());
        $this->channel->method('top')
            ->willReturn($testValue);
        $this->channel->method('extract')
            ->willReturn($testValue);
        $this->channel->method('isEmpty')
            ->willReturn(true);
        $this->channel->expects($this->once())
            ->method('isEmpty');
        $this->channel->expects($this->once())
            ->method('top');
        $this->channel->expects($this->once())
            ->method('extract');
        $this->assertSame($testValue, $this->iterator->current());
        $this->iterator->next();
        $this->assertFalse($this->iterator->valid());
    }
}
