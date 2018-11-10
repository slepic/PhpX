<?php

namespace PhpX\CommandPattern\ExecutionVisitor;

/**
 * Vistor of command execution that logs start, success and error of execution process
 */
class LoggingVisitor implements CommandExecutionVistiorInterface
{
	private $formatter;
	private $logger;
	private $startLevel;
	private $successLevel;
	private $errorLevel;

	public function __construct(LoggerInterface $logger, LogFormatterInterface $formatter = null, $startLevel = null, $successLevel = null, $errorLevel = null)
	{
		$this->formatter = $formatter ?: new LogFormatter();
		$this->logger = $logger;
		$this->startLevel = $startLevel ?: LogLevel::INFO;
		$this->successLevel = $successLevel ?: LogLevel::INFO;
		$this->errorLEvel = $errorLevel ?: LogLevel::ERROR;
	}

	public function start(CommandInterface $command, CommandInvokerInterface $invoker)
	{
		$message = $this->formatter->getStartMessage($command, $invoker);
		$context = $this->formatter->getStartContext($command, $invoker);
		$this->logger->log($this->startLevel, $message, $context);
	}

	public function success(CommandInterface $command, CommandInvokerInterface $invoker)
	{
		$message = $this->formatter->getSuccessMessage($command, $invoker);
		$context = $this->formatter->getSuccessContext($command, $invoker);
		$this->logger->log($this->successLevel, $message, $context);
	}

	public function error(Exception $error, CommandInterface $command, CommandInvokerInterface $invoker)
	{
		$message = $this->formatter->getErrorMessage($error, $command, $invoker);
		$context = $this->formatter->getErrorContext($error, $command, $invoker);
		$this->logger->log($this->errorLevel, $message, $context);
	}
}

