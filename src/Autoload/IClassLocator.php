<?php

namespace PhpX\Autoload;

/**
 * Used by Autoloader to locate files for classes
 */
interface IClassLocator
{
	/**
	 * Returns full path to php file containing given class.
	 *
	 * The file returned does not need to exist.
	 * The locator may simply generate the filename by its rules and the autoloader will check whether it is usable.
	 *
	 * @param string $className
	 * @return string|null Returns path to file to load, or null if no rule found
	 */
	function getClassFile($className);
}

