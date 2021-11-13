<?php
require_once 'cron_write_log_function.php';

$path_archives_folder = __DIR__ . '/../wp-content/plugins/importer/upload/archives';
$patch_history_archives_folder =  __DIR__ . '/history_archives/';

$di = new RecursiveDirectoryIterator($path_archives_folder, FilesystemIterator::SKIP_DOTS);
$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);

foreach ( $ri as $file ) {
    $file_name = basename($file);
    copy($file, $patch_history_archives_folder . $file_name);
    unlink($file);
}

write_log('Выполнена очистка папки импорта');
