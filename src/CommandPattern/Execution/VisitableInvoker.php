<?php

namespace PhpX\CommandPattern\Execution;


/**
 * Implementation of InvokerInterface that allows visitin of execution process
 */
class VisitableInvoker implements InvokerInterface
{
	private $visitor;
	private $invoker;

	public function __construct(VisitorInterface $visitor, InvokerInterface $invoker)
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
