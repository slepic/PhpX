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
	 * @var TransactionHandlerInterface
	 */
	private $handler;

	/**
	 * @var Invoker
	 */
	private $invoker;

	/**
	 * @param TransactionHandlerInterface $handler
	 * @param Invoker|null $invoker
	 */
	public function __construct(TransactionHandlerInterface $handler, Invoker $invoker = null)
	{
		$this->handler = $handler;
		$this->invoker = $invoker ?: new LastInvoker();
	}

	/**
	 * {@inheritdoc}
	 */
	public function executeCommand(Command $command)
	{
		$this->handler->startTransaction();
		try {
			$this->invoker->executeCommand($command);
		} catch (Exception $e) {
			$this->handler->rollbackTransaction();
			throw $e;
		}
		$this->handler->commitTransaction();
	}


}

