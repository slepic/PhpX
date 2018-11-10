<?php

namespace PhpX\CommandPattern\ExecutionVisitor;


/**
 * Implementation of CommandInvokerInterface that allows visitin of execution process
 */
class VisitableCommandInvoker implements CommandInvokerInterface
{
	private $visitor;
	private $invoker;

	public function __construct(VisitorInterface $visitor, CommandInvokerInterface $invoker)
	{
		$this->visitor = $visitor;
		$this->invoker = $invoker;
	}

	public function executeCommand(CommandInterface $command)
	{
		$this->visitor->start($command, $this);
		try {
			$this->invoker->executeCommand($command);
		} catch (\Exception $e) {
			$this->visitor->error($e, $command, $this);
			throw $e;
		}
		$this->visitor->success($command, $this);
	}
}
