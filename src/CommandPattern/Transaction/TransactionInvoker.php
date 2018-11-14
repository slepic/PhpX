<?php

namespace PhpX\CommandPattern\Transaction;

use \PhpX\CommandPattern\CommandInterface as Command;
use \PhpX\CommandPattern\InvokerInterface as Invoker;
use \PhpX\CommandPattern\LastInvoker;
use \Exception;

/**
 * Visits execution of command by effectively wrapping it in transaction if the command being executed supports transactional behaviour.
 */
class TransactionInvoker implements Invoker
{
	/**
	 * @var Invoker
	 */
	private $invoker;

	/**
	 * @param Invoker|null $invoker
	 */
	public function __construct(Invoker $invoker = null)
	{
		$this->invoker = $invoker ?: new LastInvoker();
	}

	/**
	 * {@inheritdoc}
	 */
	public function executeCommand(Command $command)
	{
		if($command instanceof TransactionalCommandInterface) {
			$handler = $command->getTransactionHandler();
			$handler->startTransaction();
			try {
				$this->invoker->executeCommand($command);
			} catch (Exception $e) {
				$handler->rollbackTransaction();
				throw $e;
			}
			$handler->commitTransaction();
		} else {
			$this->invoker->executeCommand($command);
		}
	}


}

