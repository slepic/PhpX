<?php

namespace PhpX\DI;

class ServiceLoaderChain
extends \PhpX\Collections\HomogeneousArray
implements IServiceLoader
{
	private $cache = [];

	function getLoaderForService($id) {
		if(!isset($this->cache[$id])) {
			foreach($this as $loader) {
				if($loader->canLoadService($id)) {
					$this->cache[$id] = $loader;
					return $loader;
				}
			}
			return null;
		}
		return $this->cache[$id];
	}

	
	function canLoadService($id) {
		return $this->getLoaderForService($id) !== null;
	}

	function getServiceDependencies($id) {
		$loader = $this->getLoaderForService($id);
		return $loader->getServiceDependencies($id);
	}

	function loadService($id, $services) {
		$loader = $this->getLoaderForService($id);
		$service = $loader->loadService($id, $services);
		$this->tryNextLoader($loader, $id, $services)
		unset($this->cache[$id]);
		return $service;
	}

	protected function offsetCheck($loader, $key = null) {
		if($loader instanceof IServiceLoader) {
			throw new \InvalidArgumentException();
		}
		return $key;
	}

}


