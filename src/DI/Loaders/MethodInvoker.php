<?php

namespace PhpX\DI\Loaders;

use PhpX\DI\ContainerInterface as Container;
use PhpX\DI\ServiceLoaderInterface as ServiceLoader;
use PhpX\Strings\Translators\TranslatorInterface as StringTranslator;

class MethodInvoker implements ServiceLoader
{
	private $target;
	private $translator;

	public function __construct(object $target, StringTranslator $translator)
	{
		$this->target = $target;
		$this->translator = $translator;
	}

	public function canLoadService(string $serviceName): bool
	{
		$methodName = $this->translator->translate($serviceName);
		return \method_exists($methodName, $this->target);
	}

	public function loadService(string $serviceName, Container $container): object
	{
		$methodName = $this->translator->translate($serviceName);
		return \call_user_func([$this->target, $methodName], $container);
	}
}
