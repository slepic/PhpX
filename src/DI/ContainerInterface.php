<?php

namespace PhpX\DI;

interface ContainerInterface
{
    /**
     * @param string $serviceName
     * @return bool
     */
    public function has(string $serviceName): bool;

    /**
     * @param string $serviceName
     * @return object
     */
    public function get(string $serviceName);
}
