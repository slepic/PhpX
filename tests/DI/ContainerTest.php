<?php

namespace PhpX\Tests\DI;

use PhpX\DI\Container;
use PhpX\DI\ServiceLoaderInterface as Loader;
use PHPUnit\Framework\TestCase;
use ArrayAccess;

class ContainerTest extends TestCase
{
	public function testDependeciesGetters()
	{
		$loader = $this->createMock(Loader::class);
		$storage = $this->createMock(ArrayAccess::class);

		$container = new Container($loader, $storage);

		$this->assertSame($loader, $container->getLoader());
		$this->assertSame($storage, $container->getCache());
	}

	public function testConstructWithoutCache()
	{
		$loader = $this->createMock(Loader::class);

		$container = new Container($loader);

		$this->assertInstanceOf(ArrayAccess::class, $container->getCache());
	}

	public function testHasCallsLoader()
	{
		$serviceName = \md5(\time());
		$loader = $this->createMock(Loader::class);
		$loader->expects($this->once())
			->method('canLoadService')
			->with($serviceName);

		$container = new Container($loader);
		$container->has($serviceName);
	}

	public function testGetReturnsWhatLoaderReturns()
	{
		$serviceName = \md5(\time());
		$service = new \stdClass();
		$loader = $this->createMock(Loader::class);
		$loader->method('loadService')
			->with($serviceName)
			->willReturn($service);
		$loader->expects($this->once())
			->method('loadService')
			->with($serviceName);

		$container = new Container($loader);
		$result = $container->get($serviceName);

		/*
		$this->assertSame($service, $result);
		 */
	}

	public function testGetReturnsStillTheSameInstance()
	{
		//mock deps
		$serviceName = \md5(\time());
		$service = new \stdClass();
		$loader = $this->createMock(Loader::class);
		$loader->method('loadService')
			->with($serviceName)
			->willReturn($service);
		$loader->expects($this->once())
			->method('loadService')
			->with($serviceName);

		//create tested object
		$container = new Container($loader);

		//make assertions
		$result = $container->get($serviceName);
		$this->assertSame($service, $result);
		$result = $container->get($serviceName);
		$this->assertSame($service, $result);
	}

	public function testHasAsksCacheFirstAndNeverCallsLoaderIfCacheLoaded()
	{
		$serviceName = \md5(\time());
		$testService = new \stdClass();
		$loader = $this->createMock(Loader::class);
		$loader->expects($this->never())
			->method('canLoadService');
		$storage = $this->createMock(ArrayAccess::class);
		$storage->method('offsetExists')
			->with($serviceName)
			->willReturn(true);
		$storage->expects($this->once())
			->method('offsetExists')
			->with($serviceName);

		$container = new Container($loader, $storage);

		$result = $container->has($serviceName);
		$this->assertTrue($result);
	}
}
