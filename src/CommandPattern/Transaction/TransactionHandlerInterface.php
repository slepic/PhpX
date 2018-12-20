<?php

namespace PhpX\CommandPattern\Transaction;

/**
 * Abstraction for transaction enforcement
 */
interface TransactionHandlerInterface
{
    /**
     * @return void
     */
    public function startTransaction();

    /**
     * @return void
     */
    public function commitTransaction();

    /**
     * @return void
     */
    public function rollbackTransaction();
}
