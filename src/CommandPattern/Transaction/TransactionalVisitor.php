<?php

namespace PhpX\CommandPattern\Transaction;

/**
 * Visits execution of command by effectively wrapping it in transaction if the command being executed supports transactional behaviour.
 */
class TransactionalVisitor implements VistiorInterface
{

	/**
	 * {@inheritdoc}
	 */
	public function start(CommandInterface $command, InvokerInterface $invoker)
	{
		if($command instanceof TransactionalCommandInterface) {
			$command->startTransaction();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function success(CommandInterface $command, InvokerInterface $invoker)
	{
		if($command instanceof TransactionalCommandInterface) {
			$command->commitTransaction();
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function error(Exception $error, CommmandInterface $command, InvokerInterface $invoker)
	{
		if($command instanceof TransactionalCommandInterface) {
			$command->rollbackTransaction();
		}
	}
}

