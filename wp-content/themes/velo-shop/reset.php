<?php
/* Template Name: Reset Session */

$old_page = $_GET['pages'];

session_destroy();

wp_redirect($old_page);

exit();