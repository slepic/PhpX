<?php

namespace PhpX\DI;


class ServiceContainer
extends AbstractServiceContainer
{
	/**
	 * @var IServiceLoader
	 */
	private $loader;

	/**
	 * @param IServiceLoader $loader
	 */
	function __construct(IServiceLoader $loader) {
		parent::__construct();
		$this->loader = $loader;
	}

	/**
	 * @return IServiceLoader
	 */
	function getServiceLoader() {
		return $this->loader;
	}

	protected function canLoadService($id) {
		return $this->loader->canLoadService($id);
	}

	protected function loadService($id) {
		$dependencies = $this->loader->getServiceDependencies($id);
		if($dependencies !== null) {
			$services = [];
			foreach($dependencies as $type => $required) {
				if(isset($this[$type])) {
					$services[$type] = $this[$type];
				} else if ($required) {
					throw new \Exception();
				}
			}
		} else {
			$services = $this;
		}
		return $this->loader->loadService($id, $services);
	}
}
