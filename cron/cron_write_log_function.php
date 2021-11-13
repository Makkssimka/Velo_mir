<?php

function write_log($message) {
    $log_file_path = __DIR__ . '/logs/cron_log.log';
    $data = date('d-m-Y H:i:s') . ' ' . $message . PHP_EOL;
    file_put_contents($log_file_path, $data, FILE_APPEND);
}