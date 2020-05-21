<?php
error_reporting(-1); // that is every possible error will be trapped
set_error_handler('errorHandler', E_ALL | E_STRICT);
ini_set('display_errors', 'Off');
ini_set('log_errors', 'On');
if (preg_match("/localhost/", $_SERVER['HTTP_HOST']) == 1)
    // this is defined in C:\wamp64\bin\apache\apache2.4.41\bin\php.ini
    $logPath = "c:/wamp64/logs/php_error.log";
else
    $logPath = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "error_log.txt";

function ErrorHandler($errNo, $errStr, $errFile, $errLine)
{
    error_log("\n-------------------------------------------\n" .
        "ErrStr: " . $errStr . "\n" .
        "Locn: " . $errFile . "\n" .
        "Line: " . $errLine . "\n" .
        "ErrNo: " . $errNo . "\n" .
        "-------------------------------------------\n");
}

// this may have slightly sad effects when you have round-trip journeys
if (file_exists($logPath)) {
    unlink($logPath);
}
