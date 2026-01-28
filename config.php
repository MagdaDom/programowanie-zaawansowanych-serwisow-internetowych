<?php
$logDir = __DIR__ . '/logs';
$logFile = $logDir . '/php-error.log';

if (!is_dir($logDir)) {
    mkdir($logDir, 0775, true);
}

ini_set('log_errors', '1');
ini_set('error_log', $logFile);

//ini_set('display_errors', '0'); //nie pokazuj błędów na stronie
error_reporting(E_ALL);
