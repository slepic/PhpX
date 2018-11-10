<?php

namespace PhpX\CommandPattern\ExecutionVisitor;

/**
 * Interface for objects who wish to hook into command execution
 */
interface ExecutionVisitorInterface
{
	/**
	 * @param CommandInterface $command
	 * @param CommangInvokerInterface $invoker
	 * @return void
	 */
	public function start(CommandInterface $command, CommandInvokerInterface $invoker);

	/**
	 * @param CommandInterface $command
	 * @param CommangInvokerInterface $invoker
	 * @return void
	 */
	public function success(CommandInterface $command, CommandInvokerInterface $invoker);

	/**
	 * @param Exception $exception
	 * @param CommandInterface $command
	 * @param CommangInvokerInterface $invoker
	 * @return void
	 */
	public function error(Exception $error, CommandInterface $command, CommandInvokerInterface $invoker);
}
