<?php

namespace PhpX\CommandPattern;

interface CommandInvokerInterface
{
	/**
	 * @param CommandInterface $command
	 * @return void
	 */
	public function executeCommand(CommandInterface $command);
}
