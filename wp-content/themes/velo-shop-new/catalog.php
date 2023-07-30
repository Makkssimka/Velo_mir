<?php
/* Template Name: Catalog */

global $post;
$category = $args['category'];

// Основные фильтры для продуктов
$products_per_page = 20;
$offset_page = $_GET['page_count'] ?? 1;
$args_product = array(
    'paginate' => true,
    'limit' => $products_per_page,
    'offset' => ($offset_page-1) * $products_per_page,
    'order_by' => 'post_date',
    'order' => 'DESC',
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => 'product_cat',
            'field' => 'id',
            'terms' => $category->term_id,
            'operator' => 'IN',
        )
    )
);

// Сортировка товаров
$sort = $_SESSION['sort'] ?? '';

switch ($sort) {
    case 'new':
        $args_product['orderby'] = 'post_date';
        break;
    case 'low':
        $args_product['orderby'] = 'meta_value_num';
        $args_product['meta_key'] = '_price';
        $args_product['order'] = 'ASC';
        break;
    case 'costly':
        $args_product['orderby'] = 'meta_value_num';
        $args_product['meta_key'] = '_price';
        $args_product['order'] = 'DESC';
        break;
    case 'popular':
        $args_product['orderby'] = 'meta_value_num';
        $args_product['meta_key'] = 'total_sales';
        $args_product['order'] = 'DESC';
        break;
    default:
        $args_product['orderby'] = 'post_date';
}

// Получаем значения фильтра из сессий и фильтруем товары
$filter_value = json_decode($_SESSION['filter'] ?? '');

if ($filter_value && $filter_value->category[0] == $category->slug) {
    foreach ($filter_value as $key => $value) {
        if (in_array($key, array('price', 'have', 'category'))) continue;
        $query = array(
            'taxonomy' => $key,
            'field' => 'slug',
            'terms' => $value
        );
        array_push($args_product['tax_query'], $query);
    }
}

// Получение значения фильтра цен
if ($filter_value && $filter_value->price) {
    $args_product['price_range'] = $filter_value->price[0] . '|' . $filter_value->price[1];
}

// Выбираем продукты, которые есть в наличие
$args_product['stock_status'] = 'instock';

// Получаем продукты
$products_obj = wc_get_products($args_product);
$products = $products_obj->products;

?>

<?php get_header(); ?>

<div class="mt-4">
    <?php get_template_part('blocks/all/catalog-menu') ?>
</div>

<?php get_template_part('blocks/breadcrumbs_with_sort') ?>

<div class="container">
    <div class="grid grid-filter mt-05 pb-2">
        <?php get_template_part('blocks/catalog/filters/filter-main', null, ['category' => $category]) ?>

        <div class="products">
            <div class="catalog-list catalog-list_4">
                <?php foreach ($products as $product) : ?>
                    <?php get_template_part('blocks/all/product', null, ['product' => $product]) ?>
                <?php endforeach ?>
            </div>

            <?php get_template_part('blocks/catalog/pagination', null, [
                'products_obj' => $products_obj,
                'offset_page' => $offset_page
            ]) ?>
        </div>
    </div>

    <?php get_template_part('blocks/all/info-banner') ?>
</div>

<?php get_footer(); ?>