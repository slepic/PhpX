<?php

namespace PhpX\DI;

use PhpX\DI\ContainerInterface;
use PhpX\DI\ServiceLoaderInterface as ServiceLoader;
use ArrayAccess;
use ArrayObject;

class Container implements ContainerInterface
{
	private $loader;
	private $cache;

	public function __construct(ServiceLoader $loader, ArrayAccess $cache = null)
	{
		$this->loader = $loader;
		$this->cache = $cache ?: new ArrayObject();
	}

	public function getLoader()
	{
		return $this->loader;
	}

	public function getCache()
	{
		return $this->cache;
	}

	public function has(string $serviceName): bool
	{
		return isset($this->cache[$serviceName])
			|| $this->loader->canLoadService($serviceName);
	}

	public function get(string $serviceName): object
	{
		if (isset($this->cache[$serviceName])) {
			return $this->cache[$serviceName];
		}
		$service = $this->loader->loadService($serviceName, $this);
		$this->cache[$serviceName] = $service;
		return $service;
	}

	public function unloadService(string $serviceName)
	{
		unset($this->cache[$key]);
	}
}

