<?php

$widgets = glob(get_template_directory()."/blocks/widget/*.widget.php");

foreach ($widgets as $widget) {
    require_once $widget;
}