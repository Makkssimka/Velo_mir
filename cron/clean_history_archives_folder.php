<?php
require_once 'cron_write_log_function.php';

$patch_history_archives_folder =  __DIR__ . '/history_archives';

$di = new RecursiveDirectoryIterator($patch_history_archives_folder, FilesystemIterator::SKIP_DOTS);
$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);

foreach ( $ri as $file ) {
    unlink($file);
}

write_log('Выполнена очистка папки истории импорта');