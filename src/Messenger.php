<?php
namespace KGaming\Core;

class Messenger
{
    protected $messages = [];

    public function send($msg)
    {
        $message = Utils::getTime('H:i:s') . ' ' . $msg;
        $this->messages = $message;
        return $message;
    }

    public function show($msg, $type = 'INFO')
    {
        echo $this->send($type .': '. $msg) . PHP_EOL;
        return $this;
    }

    public function debug($payload, $subject)
    {
        $debugger = new Debugger();
        $debugger->dump($payload, $subject);
        return $this;
    }

    public function shutdown()
    {
        die();
    }
}
