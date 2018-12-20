<?php

namespace PhpX\DI\Loaders;

use PhpX\DI\ServiceLoaderInterface as ServiceLoader;
use PhpX\DI\ContainerInterface as Container;

class Chain implements ServiceLoader
{
    private $chain;

    public function __construct(iterable $chain)
    {
        $this->chain = $chain;
    }

    public function canLoadService($id): bool
    {
        return $this->getLoader($id) !== null;
    }

    public function loadService($id, Container $container)
    {
        $loader = $this->getLoader($id);
        if ($loader !== null) {
            return $loader->loadService($id, $container);
        }
        throw new LogicException();
    }

    public function getLoader($id): ?ServiceLoader
    {
        foreach ($this->chain as $loader) {
            if ($loader->canLoadService($id)) {
                return $loader;
            }
        }
        return null;
    }
}
