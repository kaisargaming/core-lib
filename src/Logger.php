<?php
namespace KGaming\Core;

class Logger
{
    protected $payload;
    protected $config;

    public function __construct($config=[])
    {
        if (!count($config))
        {
            $this->initDefaultConfig();
        }

    }
    public function log($payload)
    {
        $this->payload = $payload;
    }

    private function initDefaultConfig()
    {
        $this->config = [
            'dest' => 'file',
            'path' => __DIR__ . '/../logs/',
            'prefix' => 'logger-test',
            'max_size' => '1M',
            'max_file' => '7'
        ];
    }

    private function logToFile() {}
    private function openFile() {}
    private function logToRemote(){}
}
