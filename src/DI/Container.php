<?php

use PhpX\DI\ContainerInterface;
use PhpX\DI\ServiceLoaderInterface as ServiceLoader;
use ArrayAccess;

class Container implements ContainerInterface
{
	private $loader;
	private $cache;

	public function __construct(ServiceLoader $loader, ArrayAccess $cache)
	{
		$this->loader = $loader;
		$this->cache = $cache;
	}

	public function has(string $serviceName): bool
	{
		return isset($this->cache[$serviceName])
			|| $this->loader->has($serviceName);
	}

	public function get(string $serviceName): object
	{
		if (isset($this->cache[$serviceName]) {
			return $this->cache[$serviceName];
		}
		$service = $this->loader->get($serviceName, $this);
		$this->cache[$serviceName] = $service;
		return $service;
	}
}

