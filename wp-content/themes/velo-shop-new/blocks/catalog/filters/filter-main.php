<?php
$category = $args['category'];

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
        if (in_array($slug, ['pa_cvet_dop', 'pa_', 'pa_dop-cvet']) || empty($attribute['options'])) continue;

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

<div class="filter">
    <div class="filter__head">
        <div class="filter__header">
            <img src="<?= get_asset_path('images/icons', 'filter.svg') ?>">
            Фильтры
        </div>

        <a href="#" class="filter__close mobile">
            <img src="<?= get_asset_path('images/icons', 'close-modal.svg') ?>" alt="close">
        </a>
    </div>

    <?php get_template_part('blocks/catalog/filters/filter-rage-price', null, ['category' => $category]) ?>

    <?php foreach ($products_attribute_list as $item) : ?>
        <?php get_template_part('blocks/catalog/filters/filter-item', null, ['attribute' => $item, 'category' => $category]) ?>
    <?php endforeach ?>

    <div class="filter__block">
        <a id="filter_submit" href="#" class="button button_blue-dark button_full button_sm" data-category="<?= $category->slug ?>">Применить</a>
        <a href="?session_reset" class="link_center link_sm mt-05">Сбросить фильтры</a>
    </div>
</div>