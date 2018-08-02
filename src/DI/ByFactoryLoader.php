<?php

namespace PhpX\DI;

class ByFactoryLoader
extends \PhpX\Collections\HomogeneousArray
implements IServiceLoader
{
	function canLoadService($id) {
		return isset($this[$id]));
	}

	function getServiceDependencies() {
		return null;
	}

	function loadService($id, $services) {
		$factory = $this[$id];
		return $factory($id, $services);
	}

	function isValidItem($factory) {
		return \is_callable($factory);
	}
}


