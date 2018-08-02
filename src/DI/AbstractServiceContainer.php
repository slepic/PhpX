<?php

namespace PhpX\DI;


abstract class AbstractServiceContainer
extends \PhpX\Collections\HomogeneousArray
{	
	/**
	 * Checks if service is stored in the loader.
	 *
	 * Ignores any known rules to instantiate the service.
	 *
	 * @param string $id
	 * @return boolean
	 */
	function isServiceLoaded($id) {
		return parent::offsetGet($id);
	}

	/**
	 * Check if service is accessible
	 *
	 * @param string $id
	 * @return boolean
	 */
	function hasService($id) {
		if($this->isServiceLoaded($id)) {
			return true;
		}
		return $this->canLoadService($id);
	}

	/**
	 * @param string $id
	 * @return mixed
	 * @throws \Exception if the service is not available
	 */
	function getService($id) {
		if(!$this->isServiceLoaded($id)) {
			$service = $this->loadService($id);
			$this->setService($id, $service);
		}
		return parent::offsetGet($id);
	}


	/**
	 * @param string $id
	 * @param mixed $service
	 * @return ServiceLoader
	 */
	function setService($id, $service) {
		$this[$id] = $service;
		return $this;
	}

	/**
	 * Pushes the service to service loader and generates its identifier
	 * @param object $service
	 * @return string Returns identifier assigned to the service, which is it's class name.
	 */
	function addService($service) {
		if(\is_object($service)) {
			$id = \get_class($service);
			$this->setService($id, $service);
			return $id;
		}
		throw new \Exception('Only object services can be pushed to this ServiceLoader.');
	}

	/**
	 * @param $id
	 * @return ServiceLoader
	 */
	function removeService($id) {
		unset($this[$id]);
		return $this;
	}

	/**
	 * @param $id
	 * @return boolean
	 */
	function offsetExists($id) {
		return $this->hasService($id);
	}

	/**
	 * @param $id
	 */
	function offsetGet($id) {
		return $this->getService($id);
	}

	protected function offsetCheck($service, $id = null) {
		if($service === null) {
			throw new \Exception();
		}
		if($id === null)  {
			if(\is_object($service)) {
				$id = \get_class($service);
			} else {
				throw new \Exception();
			}
		} else if (!((\is_string($id) && $id !== '') || \is_int($id))) {
			throw new \Exception();
		}
		return $id;
	}
	

	/**
	 * @param string $id
	 * @return boolean
	 */
	protected function canLoadService($id);

	/**
	 * @param string $id
	 * @return object
	 */
	protected function loadService($id);
}

