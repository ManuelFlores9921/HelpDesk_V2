<?php

class Logger
{

    private static $logFile = __DIR__ . "/app.log";

    public static function writeLog($level, $message)
    {
        $date = date("Y-m-d H:i:s");
        $logMessage = "[$date] [$level] $message" . PHP_EOL;
        file_put_contents(self::$logFile, $logMessage, FILE_APPEND);
    }

    public static function info($message)
    {
        self::writeLog("INFO", $message);
    }
}