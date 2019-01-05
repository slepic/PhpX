<?php

namespace PhpX\Tests\Value\Filters;

use PHPUnit\Framework\TestCase;
use PhpX\Value\Filters\NotFilter;
use PhpX\Value\FilterInterface as Filter;

class NotFilterTest extends TestCase
{
    protected function setUp()
    {
        $this->innerFilter = $this->createMock(Filter::class);
        $this->filter = new NotFilter($this->innerFilter);
    }

    /*public function testInnerFilterGetter()
    {
        $this->assertSame($this->innerFilter, $this->filter->getInnerFilter());
    }*/

    public function testAccepted()
    {
        $this->innerFilter->method('isAccepted')
            ->willReturn(true);
        $this->innerFilter->expects($this->once())
            ->method('isAccepted');
        $this->assertFalse($this->filter->isAccepted(null));
    }

    public function testNotAccepted()
    {
        $this->innerFilter->method('isAccepted')
            ->willReturn(false);
        $this->innerFilter->expects($this->once())
            ->method('isAccepted');
        $this->assertTrue($this->filter->isAccepted(null));
    }
}
