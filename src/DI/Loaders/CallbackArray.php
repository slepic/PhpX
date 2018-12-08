<?php

namespace PhpX\DI\Loaders;

use PhpX\DI\ServiceLoaderInterface as ServiceLoader;
use PhpX\DI\ContainerInterface as Container;
use ArrayAccess;

class CallbackArray implements ServiceLoader
{
	private $factories;

	public function __construct(ArrayAccess $factories)
	{
		$this->factories = $factories;
	}

	public function canLoadService($id)
	{
		return isset($this->factories[$id]);
	}

	public function loadService($id, Container $container)
	{
		$factory = $this->factories[$id];
		return $factory($container);
	}
}
