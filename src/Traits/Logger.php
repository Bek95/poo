<?php

namespace App\Traits;

trait Logger
{
    protected $logDir = __DIR__ . '/../../storage/logs/';

    public function log(string $message, string $level = 'INFO')
    {
        $logFile = $this->logDir . date('d-m-Y') . '-logs.txt';

        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0777, true);
        }

        $formattedMessage = sprintf("[%s] [%s] %s%s", date('Y-m-d H:i:s'), $level, $message, PHP_EOL);
        file_put_contents($logFile, $formattedMessage, FILE_APPEND);
    }
}
