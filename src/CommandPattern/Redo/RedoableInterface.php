<?php

namespace PhpX\CommandPattern\Redo;

interface RedoableInterface extends UndoableInterface
{
	public function canRedo();
	public function redo();
}	
