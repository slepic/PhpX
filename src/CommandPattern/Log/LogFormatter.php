<?php

namespace PhpX\CommandPattern\ExecutionVisitor;

/**
 * Simple implementation of LogFormatterInterface
 */
class LogFormatter implements LogFormatterInterface
{
	private $separator;

	public function __construct($separator = null)
	{
		$this->separator = $separator ?: \PHP_EOL;
	}

	public function getStartMessage(CommandInterface $command, InvokerInterface $invoker)
	{
		return 'START:' . $this->separator . $this->getMessage($command, $invoker);
	}

	public function getStartContext(CommandInterface $command, InvokerInterface $invoker)
	{
		return $this->getContext($command, $invoker);
	}

	public function getSuccessMessage(CommandInterface $command, InvokerInterface $invoker)
	{
		return "SUCCESS:\n" . $this->getMessage($command, $invoker);
	}

	public function getSuccessContext(CommandInterface $command, InvokerInterface $invoker)
	{
		return $this->getContext($command, $invoker);
	}

	public function getErrorMessage(Exception $error, CommandInterface $command, InvokerInterface $invoker)
	{
		$message = $this->getMessage($command, $invoker);
		return "ERROR:\n{exception}\n" . $message;
	}

	public function getErrorContext(Exception $error, CommandInterface $command, InvokerInterface $invoker)
	{
		$context = $this->getContext($command, $invoker);
		$context['exception'] = $error;
		return $context;
	}

	protected function getMessage(CommandInterface $command, InvokerInterface $invoker)
	{
		return "Command={command}\nInvoker={invoker}\n";
	}

	protected function getContext(CommandInterface $command, InvokerInterface $invoker)
	{
		return [
			'command' => \get_class($command),
			'invoker' => \get_class($invoker),
		];
	}
}


