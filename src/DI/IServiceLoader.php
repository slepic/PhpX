<?php

namespace PhpX\DI;

interface IServiceLoader
{
	/**
	 * Tell if this loader can instantiate service by its id
	 *
	 * @param string $id
	 * @return boolean
	 */
	function canLoadService($id);

	/**
	 * Gets the dependencies of service as array of service ids
	 *
	 * @param string $id
	 * @return string[]|null Return ids of requested services, or null if you want the ServiceContainer itself
	 * 	This can be useful if you dont know what dependencies you have until you actualy try to instantiate the service
	 */
	function getServiceDependencies($id);

	/**
	 * Instantiates service by its id and dependent-upon services
	 *
	 * @param string $id
	 * @param object[] $services array of services which must satisfy requested dependencies obtained by call to getServiceDependencies
	 * @return object
	 */
	function loadService($id, $services);
}

