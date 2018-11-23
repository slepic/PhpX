<?php

namespace PhpX\Autoload;

/**
 * Generic autoloader class.
 *
 * This is a wrapper for PHP spl_autoload_* functions.
 * The class offers method to register and unregister the autoloader and can work in various modes (@todo).
 * The file lookup logic is delegated to ClassLocatorInterface object.
 */
class Autoloader
{
	/**
	 * @vaar ClassLocatorInterface
	 */
	private $locator;

	/**
	 * @param ClassLocatorInterface $locator
	 */
	function __construct(ClassLocatorInterface $locator) {
		$this->locator = $locator;
	}

	/**
	 * @return ClassLocatorInterface
	 */
	function getLocator() {
		return $this->locator;
	}

	/**
	 * @param string $className
	 * @return void
	 */
	function loadClass($className) {
		$file = $this->getLocator()->getClassFile($className);
		if($file !== null) {
			if(\file_exists($file)) {
				include_once($file);
			}
		}
	}

	/**
	 * @return boolean
	 */
	function register() {
		return \spl_autoload_register([$this, 'loadClass']);
	}

	/**
	 * @return boolean
	 */
	function unregister() {
		return \spl_autoload_unregister([$this, 'loadClass']);
	}
}
