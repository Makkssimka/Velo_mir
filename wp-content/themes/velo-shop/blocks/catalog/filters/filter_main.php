<?php

$args = array(
    'limit' => -1,
    'stock_status' => 'instock',
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'product_cat',
            'field' => 'term_id',
            'terms' => $category->term_id,
            'operator' => 'IN'
        )
    )
);

// Получаем все продукты данной категории
$products_filter = wc_get_products($args);

// Список аттрибутов
$products_attribute_list = [];

// Перебираем продукты и собираем аттрибуты в массив
foreach ($products_filter as $product) {
    $attributes = $product->get_attributes();
    foreach ($attributes as $slug => $attribute) {
        if (in_array($slug, $products_attribute_list)) {
            $products_attribute_list[$slug]['terms'][] = $attribute;
        } else {
            $products_attribute_list[$slug]['name'] = wc_attribute_label($slug);
            $products_attribute_list[$slug]['slug'] = $slug;
            $products_attribute_list[$slug]['terms'][] = $attribute;
        }
    }
}

?>

<div class="catalog-filter-wrapper">
    <div class="catalog-filter-header">
        <span>Фильтры</span> <a href="?session_reset"><i class="las la-times"></i> сбросить</a>
    </div>
    <div class="catalog-filter-body">
        <?php require_once "filter_rage_price.php" ?>
        <?php foreach ($products_attribute_list as $item) : ?>
            <?php filter_item_widget($item) ?>
        <?php endforeach; ?>
    </div>
    <div class="catalog-filter-footer">
        <a id="filter_close" href="#>"><i class="las la-arrow-left"></i> закрыть</a>
        <a id="filter_submit" href="#>"><i class="las la-filter"></i> применить</a>
    </div>
</div>