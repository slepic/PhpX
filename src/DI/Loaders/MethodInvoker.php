<?php

namespace PhpX\DI\Loaders;

use PhpX\DI\ContainerInterface as Container;
use PhpX\DI\ServiceLoaderInterface as ServiceLoader;
use PhpX\Strings\TransformatorInterface as StringTransformator;

class MethodInvoker implements ServiceLoader
{
	private $target;
	private $transformator;

	public function __construct(object $target, StringTransformator $transformator)
	{
		$this->target = $target;
		$this->transformator = $transformator;
	}

	public function canLoadService(string $serviceName): bool
	{
		$methodName = $this->transformator->transform($serviceName);
		return \method_exists($methodName, $this->target);
	}

	public function loadService(string $serviceName, Container $container): object
	{
		$methodName = $this->transformator->transform($serviceName);
		return \call_user_func([$this->target, $methodName], $container);
	}
}
