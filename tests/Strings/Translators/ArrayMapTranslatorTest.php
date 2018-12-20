<?php

namespace PhpX\Tests\Strings\Translators;

use PHPUnit\Framework\TestCase;
use PhpX\Strings\Translators\ArrayMapTranslator;
use PhpX\Strings\TranslatorInterface as Translator;
use ArrayAccess;

class ArrayMapTranslatorTest extends TestCase
{
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
