<?php

namespace PhpX\CommandPattern\Execution;

/**
 * Interface for objects who wish to hook into command execution
 */
interface VisitorInterface
{
	/**
	 * @param CommandInterface $command
	 * @param InvokerInterface $invoker
	 * @return void
	 */
	public function start(CommandInterface $command, InvokerInterface $invoker);

	/**
	 * @param CommandInterface $command
	 * @param InvokerInterface $invoker
	 * @return void
	 */
	public function success(CommandInterface $command, InvokerInterface $invoker);

	/**
	 * @param Exception $exception
	 * @param CommandInterface $command
	 * @param InvokerInterface $invoker
	 * @return void
	 */
	public function error(Exception $error, CommandInterface $command, InvokerInterface $invoker);
}
