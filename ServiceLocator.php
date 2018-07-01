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
{
	/**
	 * @var object[]
	 */
	private $services = [];

	/**
	 * @var callable[]
	 */
	private $factories = [];

	/**
	 * Check if service is accessible
	 *
	 * If the service is accessible it is instantiated in the background.
	 *
	 * @{inheritdoc}
	 */
	function hasService($id) {
		if(isset($this->services[$id])) {
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
	 * @{inheritdoc}
	 */
	function getService($id) {
		if($this->hasService($id)) {
			return $this->services[$id];
		}
		throw new \Exception("Service '$id' not found.");
	}

	/**
	 * @param $id
	 * @param $service
	 */
	function setService($id, $service) {
		$this->services[$id] = $service;
	}

	/**
	 * @param $id
	 */
	function removeService($id) {
		unset($this->services[$id]);
	}

	/**
	 * @return object[]
	 */
	function getServices() {
		return $this->services;
	}

	/**
	 * @param $id
	 * @return object|null Returns null if no rule to instantiate the service is found
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
	 * @param $id
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
	 */
	function setFactory($id, callable $factory) {
		$this->factories[$id] = $factory;
	}

	/**
	 * @param $id
	 */
	function removeFactory($id) {
		unset($this->factories[$id]);
	}

	/**
	 * @return callable[]
	 */
	function getFactories() {
		return $this->factories;
	}
}


