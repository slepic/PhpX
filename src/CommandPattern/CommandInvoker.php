<?php

namespace PhpX\CommandPattern;

class CommandInvoker implements CommandInvokerInterface
{
	public function executeCommand(CommandInterface $command)
	{
		$command->execute();
	}
}
