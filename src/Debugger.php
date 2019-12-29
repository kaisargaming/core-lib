<?php
namespace KGaming\Core;

class Debugger
{
    private $is_debug = 0;
    private $payload;
    private $msg = '';

    public function __construct()
    {
        $this->is_debug = getenv('APP_DEBUG');
    }

    /**
     * Dump a payload.
     *
     * @param mixed $payload Variable to dump
     * @param string $msg Title of the dump
     * @return void
     */
    public function dump($payload, $msg='')
    {
        if ($this->is_debug)
        {
            $this->payload = $payload;
            $this->msg = $msg;
            if (!is_array($payload))
            {
                return $this->dumpText();
            }
            return $this->dumpObject();
        }
    }

    private function dumpObject()
    {
        echo '-----' . PHP_EOL;
        echo $this->msg . PHP_EOL;
        var_dump($this->payload);
        echo '-----' . PHP_EOL;
    }

    private function dumpText()
    {
        echo '-----' . PHP_EOL;
        echo $this->msg . PHP_EOL;
        echo $this->payload . PHP_EOL;
        echo '-----' . PHP_EOL;
    }
}
