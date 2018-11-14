<?php

namespace PhpX\CommandPattern\Transaction;

use \PhpX\CommandPattern\CommandInterface;

interface TransactionalCommandInterface extends CommandInterface
{
	/**
	 * @return TransactionHandlerInterface
	 */
	public function getTransactionHandler();
}
