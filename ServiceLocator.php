<?php

/**
 * @feature Add and remove services directly
 * @feature Add and remove services' factories. Factories are represented by
 * 	callbacks that accept ServiceContainer itself as first argument and the id
 * 	of the service as second argument.
 * @feature Derived classes can autoload services by defining a createService<ServiceName> method
 * @feature Derived classes can change the way of building method name in autoloading (overriding getFactoryMethodName method)
 */
class ServiceLocator
implements \ArrayAccess, \IteratorAggregate, \Countable
{
	/**
	 * @var array
	 */
	private $services = [];

	/**
	 * @var callable[]
	 */
	private $factories = [];

	/**
	 * Checks if service is stored in the locator.
	 *
	 * Ignores any known rules to instantiate the service.
	 *
	 * @param string $id
	 * @return boolean
	 */
	function isServiceLoaded($id) {
		return isset($this->services[$id]);
	}

	/**
	 * Check if service is accessible
	 *
	 * If the service is accessible it is instantiated in the background.
	 *
	 * @param string $id
	 * @return boolean
	 */
	function hasService($id) {
		if($this->isServiceLoaded($id)) {
			return true;
		}
		$service = $this->createService($id);
		if($service === null) {
			return false;
		}
		$this->setService($id, $service);
		return true;
	}

	/**
	 * @param string $id
	 * @return mixed
	 * @throws \Exception if the service is not available
	 */
	function getService($id) {
		if($this->hasService($id)) {
			return $this->services[$id];
		}
		throw new \Exception("Service '$id' not found.");
	}

	/**
	 * @param string $id
	 * @param mixed $service
	 * @return ServiceLocator
	 */
	function setService($id, $service) {
		$this->services[$id] = $service;
		return $this;
	}

	/**
	 * Pushes the service to service locator and generates its identifier
	 * @param object $service
	 * @return string Returns identifier assigned to the service, which is it's class name.
	 */
	function addService($service) {
		if(\is_object($service)) {
			$id = \get_class($service);
			$this->setService($id, $service);
			return $id;
		}
		throw new \Exception('Only object services can be pushed to this ServiceLocator.');
	}

	/**
	 * @param $id
	 * @return ServiceLocator
	 */
	function removeService($id) {
		unset($this->services[$id]);
		return $this;
	}

	/**
	 * Returns array of loaded services
	 *
	 * @return mixed[]
	 */
	function getServices() {
		return $this->services;
	}

	/**
	 * Creates the service through stored factories or own factory methods
	 *
	 * Override this method to implement any other means of service autoloading.
	 *
	 * @param string $id
	 * @return mixed Returns null if no rule to instantiate the service is found
	 */
	function createService($id) {
		if($this->hasFactory($id)) {
			$factory = $this->getFactory($id);
			return $factory($this, $id);
		}
		$method = $this->getFactoryMethodName($id);
		if(\method_exists($this, $method)) {
			return $this->$method($id);
		}
		return null;
	}

	/**
	 * Gets name of method used for service autoloading
	 *
	 * Extends this method to change the pattern for factory method names.
	 *
	 * @param string $id
	 * @return string
	 */
	function getFactoryMethodName($id) {
		return 'createService' . $id;
	}

	/**
	 * @param $id
	 * @return boolean
	 */
	function hasFactory($id) {
		return isset($this->factories[$id]);
	}

	/**
	 * @param $id
	 * @return callable
	 */
	function getFactory($id) {
		return $this->factories[$id];
	}

	/**
	 * @param $id
	 * @param $factory callable
	 * @return ServiceLocator
	 */
	function setFactory($id, callable $factory) {
		$this->factories[$id] = $factory;
		return $this;
	}

	/**
	 * @param $id
	 * @return ServiceLocator
	 */
	function removeFactory($id) {
		unset($this->factories[$id]);
		return $this;
	}

	/**
	 * @return callable[]
	 */
	function getFactories() {
		return $this->factories;
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

	/**
	 * @param $id
	 * @param $service
	 * @return mixed Returns the service
	 */
	function offsetSet($id, $service) {
		if($id === null) {
			$this->addService($service);
		} else {
			$this->setService($id, $service);
		}
		return $service;
	}

	/**
	 * @param $id
	 */
	function offsetUnset($id) {
		return $this->removeService($id);
	}

	/**
	 * Iterator over loaded services
	 *
	 * @return \Iterator
	 */
	function getIterator() {
		return new \ArrayIterator($this->getServices());
	}

	/**
	 * Counts loaded services
	 *
	 * @return int
	 */
	function count() {
		return \count($this->getServices());
	}
}


