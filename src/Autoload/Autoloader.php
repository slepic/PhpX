<?php

namespace PhpX\Autoload;

/**
 * Generic autoloader class.
 *
 * This is a wrapper for PHP spl_autoload_* functions.
 * The class offers method to register and unregister the autoloader and can work in various modes (@todo).
 * The file lookup logic is delegated to IClassLocator object.
 */
class Autoloader
{
	/**
	 * @vaar IClassLocator
	 */
	private $locator;

	/**
	 * @param IClassLocator $locator
	 */
	function __construct(IClassLocator $locator) {
		$this->locator = $locator;
	}

	/**
	 * @return IClassLocator
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
