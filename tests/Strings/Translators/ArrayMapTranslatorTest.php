<?php

namespace PhpX\Tests\Strings\Translators;

use PHPUnit\Framework\TestCase;
use PhpX\Strings\Translators\ArrayMapTranslator;
use PhpX\Strings\TranslatorInterface as Translator;
use ArrayAccess;

class ArrayMapTranslatorTest extends TestCase
{
    public function testConstructor()
    {
        $array = $this->createMock(ArrayAccess::class);
        $fallback = $this->createMock(Translator::class);
        $translator = new ArrayMapTranslator($array, $fallback);
        $this->assertSame($array, $translator->getMap());
        $this->assertSame($fallback, $translator->getFallback());
    }

    public function testDefaultFallbackConstructor()
    {
        $array = $this->createMock(ArrayAccess::class);
        $translator = new ArrayMapTranslator($array);
        $this->assertSame($array, $translator->getMap());
        $this->assertInstanceOf(Translator::class, $translator->getFallback());
    }

    public function testDefaultConstructor()
    {
        $translator = new ArrayMapTranslator();
        $this->assertInstanceOf(ArrayAccess::class, $translator->getMap());
        $this->assertInstanceOf(Translator::class, $translator->getFallback());
    }

    public function testTranslatesWhatMapHas()
    {
        $testKey = \md5(\time());
        $testValue = \md5($testKey);

        $array = $this->createMock(ArrayAccess::class);
        $array->method('offsetExists')
            ->with($testKey)
            ->willReturn(true);
        $array->method('offsetGet')
            ->with($testKey)
            ->willReturn($testValue);
        $array->expects($this->once())
            ->method('offsetExists')
            ->with($testKey);
        $array->expects($this->once())
            ->method('offsetGet')
            ->with($testKey);
        $fallback = $this->createMock(Translator::class);
        $fallback->expects($this->never())
            ->method('translate');
        $translator = new ArrayMapTranslator($array, $fallback);

        $this->assertSame($testValue, $translator->translate($testKey));
    }
    
    public function testTranslatesWhatMapHasNot()
    {
        $testKey = \md5(\time());
        $testValue = \md5($testKey);

        $array = $this->createMock(ArrayAccess::class);
        $array->method('offsetExists')
            ->with($testKey)
            ->willReturn(false);
        $array->expects($this->once())
            ->method('offsetExists')
            ->with($testKey);
        $array->expects($this->never())
            ->method('offsetGet')
            ->with($testKey);
        $fallback = $this->createMock(Translator::class);
        $fallback->method('translate')
            ->with($testKey)
            ->willReturn($testValue);
        $fallback->expects($this->once())
            ->method('translate');
        $translator = new ArrayMapTranslator($array, $fallback);

        $this->assertSame($testValue, $translator->translate($testKey));
    }
}
