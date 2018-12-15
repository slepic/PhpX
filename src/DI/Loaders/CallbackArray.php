<?php

namespace PhpX\DI\Loaders;

use PhpX\DI\ServiceLoaderInterface as ServiceLoader;
use PhpX\DI\ContainerInterface as Container;
use PhpX\TypeHint\InvalidTypeException;
use ArrayAccess;

class CallbackArray implements ServiceLoader
{
    private $factories;

    public function __construct(ArrayAccess $factories)
    {
        $this->factories = $factories;
    }

    public function canLoadService(string $id): bool
    {
        return $this->factories->offsetExists($id);
    }

    public function loadService($id, Container $container): object
    {
        $factory = $this->factories->offsetGet($id);
        if (!is_callable($factory)) {
            throw new InvalidTypeException("callback", $factory, 'service=' . $id);
        }
        return $factory($container);
    }
}
