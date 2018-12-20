<?php

namespace PhpX\CommandPattern;

require dirname(dirname(__DIR__)) . '/vendor/autoload.php';


class Target
{
    public function on()
    {
        echo "ON\n";
    }

    public function off()
    {
        echo "OFF\n";
    }
}

class OnComm implements Undo\UndoableCommandInterface, Undo\UndoableInterface
{
    private $t;

    public function __construct($t)
    {
        $this->t = $t;
    }

    public function execute()
    {
        $this->t->on();
    }

    public function canUndo()
    {
        return true;
    }

    public function undo()
    {
        $this->t->off();
    }

    public function getUndoCommand()
    {
        return new Redo\UndoCommand($this);
    }
}

$i = new LastInvoker();
$u = new Undo\UndoableInvoker($i);

$t = new Target();
$c = new OnComm($t);


\print_r($u);
$u->executeCommand($c);
\print_r($u);
$u->undo();
\print_r($u);
$u->redo();
\print_r($u);
