<?php

namespace PhpX\Tests\DI\Loaders;

use PHPUnit\Framework\TestCase;
use PhpX\Strings\TranslatorInterface as Translator;
use PhpX\DI\Loaders\MethodInvoker;
use PhpX\DI\Container;

class MethodInvokerTest extends TestCase
{
    public function testLoadsServiceWhenTranslatorReturnsExistingMethodName()
    {
        $serviceName = \md5(\time());
        $service = new \ArrayIterator([1]);
        $factoryMethod = 'getIterator';
        $target = $this->createMock(\IteratorAggregate::class);
        $target->method($factoryMethod)
            ->willReturn($service);
        $target->expects($this->once())
            ->method($factoryMethod);
        $translator = $this->createMock(Translator::class);
        $translator->method('translate')
            ->with($serviceName)
            ->willReturn($factoryMethod);
        $translator->expects($this->exactly(2))
            ->method('translate')
            ->with($serviceName);
        $container = $this->createMock(Container::class);
        $loader = new MethodInvoker($target, $translator);
        $this->assertTrue($loader->canLoadService($serviceName));
        $this->assertSame($service, $loader->loadService($serviceName, $container));
    }
}
