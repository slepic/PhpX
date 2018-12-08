<?php

namespace PhpX\DI;

interface ServiceLoaderInterface
{
	public function canLoadService(string $serviceName): bool;

	public function loadService(string $serviceName): object;
}
