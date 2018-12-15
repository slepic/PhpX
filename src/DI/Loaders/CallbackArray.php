<?php

namespace PhpX\DI\Loaders;

use PhpX\DI\ServiceLoaderInterface as ServiceLoader;
use PhpX\DI\ContainerInterface as Container;
use PhpX\Collections\ContainerInterface as Map;
use PhpX\TypeHint\InvalidTypeException;

class CallbackArray implements ServiceLoader
{
	private $factories;

	public function __construct(Map $factories)
	{
		$this->factories = $factories;
	}

	public function canLoadService(string $id): bool
	{
		return $this->factories->has($id);
	}

	public function loadService($id, Container $container): object
	{
		$factory = $this->factories->get($id);
		if(!is_callable($factory)) {
			throw new InvalidTypeException("callback", $factory, 'service=' . $id);
		}
		return $factory($container);
	}
}
