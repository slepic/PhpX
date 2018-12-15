<?php

namespace PhpX\Tests\DI\Loaders;

use PHPUnit\Framework\TestCase;
use PhpX\DI\Loaders\CallbackArray;
use PhpX\DI\ContainerInterface as Container;
use PhpX\Collections\ContainerInterface as Map;

class CallbackArrayTest extends TestCase
{
		public function testX()
		{
			$serviceName = \md5(\time());
			$service = new \stdClass();
			$serviceName2 = \md5($serviceName);
			$service2 = new \stdClass();
	
			$array = $this->createMock(Map::class);
			$array->method('has')
				->with($serviceName)
				->willReturn(true);
			$array->method('get')
				->with($serviceName)
				->willReturn(function (Container $container) use($service, $serviceName2) {
					$service->service2 = $container->get($serviceName2);
					return $service;
				});
			$container = $this->createMock(Container::class);
			$container->method('get')
				->with($serviceName2)
				->willReturn($service2);
			$loader = new CallbackArray($array);
			$this->assertTrue($loader->canLoadService($serviceName));
			$this->assertSame($service, $loader->loadService($serviceName, $container));
			$this->assertSame($service2, $service->service2);
		}
}
