<?php

$options = array('hide_empty' => false);
$brands = get_terms('pa_brand', array('hide_empty' => true));
$wheel_sizes = get_terms('pa_wheel_size', $options);
$frame_size = get_terms('pa_frame_size', $options);
$material = get_terms('pa_material', $options);
$types = get_terms('pa_type_velo', $options);
$tormozs = get_terms('pa_tormoz', $options);
$speed = get_terms('pa_speed', $options);
$colors = get_terms('pa_color', array('hide_empty' => true));


// сортировка массивов параметров
$brands = terms_sort($brands, 'count');
$wheel_sizes = terms_sort($wheel_sizes);
$frame_size = terms_sort($frame_size);
$material = terms_sort($material, 'count');
$types = terms_sort($types, 'count');
$tormozs = terms_sort($tormozs, 'count');
$speed = terms_sort($speed);
$colors = terms_sort($colors, 'count');

?>
<div class="catalog-filter-wrapper">
    <div class="catalog-filter-header">
        <span>Фильтры</span> <a href="?session_reset"><i class="las la-times"></i> сбросить</a>
    </div>
    <div class="catalog-filter-body">
        <?php require "filter_rage_price.php" ?>
        <?php filter_item_widget('brand','Производители', $brands, true) ?>
        <?php filter_item_widget('wheel_size','Размеры колес', $wheel_sizes, true) ?>
        <?php filter_item_widget('type_velo', 'Назначение', $types, true) ?>
        <?php filter_item_widget('material', 'Материал', $material) ?>
        <?php filter_item_widget('color', 'Цвет', $colors, true) ?>
        <?php filter_item_widget('frame_size','Размеры рамы', $frame_size, true) ?>
        <?php filter_item_widget('tormoz','Тип тормоза', $tormozs, true) ?>
        <?php filter_item_widget('speed','Кол-во скоростей', $speed, true) ?>
    </div>
    <div class="catalog-filter-footer">
        <a id="filter_close" href="#>"><i class="las la-arrow-left"></i> закрыть</a>
        <a id="filter_submit" href="#>"><i class="las la-filter"></i> применить</a>
    </div>
</div>