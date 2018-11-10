<?php

namespace PhpX\CommandPattern\ExecutionVisitor;

/**
 * Interface for formatiing commands for PSR logger 
 */
interface LogFormatterInterface
{
	/**
	 * @param CommandInterface $command
	 * @param CommangInvokerInterface $invoker
	 * @return string
	 */
	public function getStartMessage(CommandInterface $command, CommandInvokerInterface $invoker);

	/**
	 * @param CommandInterface $command
	 * @param CommangInvokerInterface $invoker
	 * @return array
	 */
	public function getStartContext(CommandInterface $command, CommandInvokerInterface $invoker);

	/**
	 * @param CommandInterface $command
	 * @param CommangInvokerInterface $invoker
	 * @return string
	 */
	public function getSuccessMessage(CommandInterface $command, CommandInvokerInterface $invoker);

	/**
	 * @param CommandInterface $command
	 * @param CommangInvokerInterface $invoker
	 * @return array
	 */
	public function getSuccessContext(CommandInterface $command, CommandInvokerInterface $invoker);

	/**
	 * @param CommandInterface $command
	 * @param CommangInvokerInterface $invoker
	 * @return string
	 */
	public function getErrorMessage(Exception $error, CommandInterface $command, CommandInvokerInterface $invoker);

	/**
	 * @param CommandInterface $command
	 * @param CommangInvokerInterface $invoker
	 * @return array
	 */
	public function getErrorContext(Exception $error, CommandInterface $command, CommandInvokerInterface $invoker);
}
