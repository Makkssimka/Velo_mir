<?php

require_once ('cron_write_log_function.php');

$message = $argv[1];
write_log($message);


