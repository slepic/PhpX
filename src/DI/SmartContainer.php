<?php

namespace PhpX\DI;

/**
 * This container is a ServiceContainer with facade for all ServiceLocators implemented by this module.
 * It offers all the functionality in one class and the client need not know anything about the components used to implement it.
 *
 * This class can be derived from, but if you are implementing container for a subset of your services which have same interface
 * then you probably won't need all the functionality and extending a more generic container might be a better choice.
 *
 * If you derive this class to add factory methods on it, call the parent constructor with a new ByContainerMethodLocator($this),
 * as this one is not added by default, because it is useless when using the SmartContainer without extending it.
 */
class SmartContainer
extends ServiceContainer
{
	function __construct(IServiceLocator $locator = null) {
		$locators = [];
		if($locator !== null) {
			$locators[] = $locator;
		}
		$locators[] = new ByFactoryLocator();
		//$locators[] = new ByContainerMethodLocator();
		//$locators[] = new AutowireLocator();
		$chain = new ServiceLocatorChain($locators);
		parent::__construct($chain);
	}

	function getFactories() {
		return $this->byFactoryLocator->toArray();
	}

	function setServiceFactory($id, $factory) {
		return $this->byFactoryLocator[$id] = $factory;
	}

	//TODO and so on
}


