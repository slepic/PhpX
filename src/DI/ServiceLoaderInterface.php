<?php

namespace PhpX\DI;

use PhpX\DI\ContainerInterface as Container;

interface ServiceLoaderInterface
{
	public function canLoadService(string $serviceName): bool;

	public function loadService(string $serviceName, Container $container);
}
