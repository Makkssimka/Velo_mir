<?php

$path_archives_folder = __DIR__.'/../wp-content/plugins/importer/upload/archives';

$di = new RecursiveDirectoryIterator($path_archives_folder, FilesystemIterator::SKIP_DOTS);
$ri = new RecursiveIteratorIterator($di, RecursiveIteratorIterator::CHILD_FIRST);
foreach ( $ri as $file ) {
    $file->isDir() ?  rmdir($file) : unlink($file);
}
