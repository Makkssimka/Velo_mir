<?php
/* Template Name: Catalog */

get_header();

global $post;

$category = $args['category'];

// Основные фильтры для продуктов
$products_per_page = 21;
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

// Получаем значения фильтра из сессий  и фильтруем товары
$filter_value = json_decode($_SESSION['filter'] ?? '');

if ($filter_value) {
    foreach ($filter_value as $key => $value) {
        if (in_array($key, array('price', 'have'))) continue;
        $query = array(
            'taxonomy' => $key,
            'field' => 'slug',
            'terms' => $value
        );
        array_push($args_product['tax_query'], $query);
    }
}

// Выбираем продукты которые есть в наличие
$args_product['stock_status'] = 'instock';

// Получаем продукты
$products_obj = wc_get_products($args_product);
$products = $products_obj->products;

?>

<div class="content-main catalog">
    <div class="container">
        <?php require_once "blocks/catalog/filters/filter_main.php" ?>
        <div class="catalog-list-wrapper">
            <div class="catalog-list-header">
                <h1>Каталог <?= mb_lcfirst($category->name) ?></h1>
                <?php require_once "blocks/catalog/select_sort.php" ?>
            </div>
            <div class="catalog-list-body">
                <?php if (count($products)) : ?>
                    <?php foreach ($products as $key => $bike): ?>
                        <?php bike_widget($bike, false) ?>
                        <?php if ($key == 3 || $key == 13): ?>
                            <?php catalog_banner_widget($key) ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="empty-query">По данным параметрам не найдено велосипедов</p>
                <?php endif ?>
            </div>
            <?php require "blocks/catalog/pagination.php" ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>