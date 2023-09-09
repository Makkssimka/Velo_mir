<?php
/* Template Name: Search */

global $post;
$search_word = $_GET['search'] ?? '';
$sort = $_GET['sort'] ?? '';
$offset_page = $_GET['page_count'] ?? 1;

$products_per_page = 20;

$args = array(
    'paginate' => true,
    'limit' => $products_per_page,
    'offset' => ($offset_page - 1)*$products_per_page,
    'like_title' => $search_word,
    'tax_query' => array(
        'relation' => 'AND'
    )
);

if ($sort) {
    $query = array(
        'taxonomy' => "product_cat",
        'field' => 'term_id',
        'terms' => $sort,
        'operator' => 'IN'
    );
    array_push($args['tax_query'], $query);
}

$products_obj = wc_get_products($args);

$result_search = $search_word ? $products_obj->products : [];

/**
 * Список категорий найденных товаров
 */
$categories = [];

foreach ($result_search as $product) {
    $categories[] = wp_get_post_terms($product->get_id(),'product_cat')[0];
}
$categories = array_unique($categories, SORT_REGULAR);
?>

<?php get_header(); ?>

<?php get_template_part('blocks/breadcrumbs') ?>

<div class="content-main article search">
    <div class="container">
        <?php if($search_word) : ?>
            <h1 class="h3"><?= $post->post_title; ?>: <?= $search_word ?></h1>
        <?php else : ?>
            <h1 class="h3">Пустой запрос</h1>
        <?php endif ?>
        <div class="h6"><?= $post->post_excerpt; ?></div>

        <form action="/search" method="get">
            <div class="search-input__wrapper">
                <input type="text" name="search" value="<?= $search_word ?>" placeholder="Искать">
                <button type="submit">Найти</button>
            </div>
        </form>

        <div class="search-result__wrapper">
            <?php if (count($result_search)) : ?>
                <div class="search-list__wrapper">
                    <div class="catalog-list catalog-list_5">
                        <?php foreach ($result_search as $item) : ?>
                            <?php get_template_part('blocks/all/product', null, ['product' => $item]) ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="search-list__header">
                        <h3>По вашему запросу найдено <?= num_word($products_obj->total) ?></h3>

                        <?php get_template_part('blocks/search/select_sort', null, [
                            'categories' => $categories,
                            'sort' => $sort,
                        ]) ?>
                    </div>
                </div>

                <?php get_template_part('blocks/catalog/pagination', null, [
                    'products_obj' => $products_obj,
                    'offset_page' => $offset_page
                ]) ?>
            <?php else : ?>
                <h3>По вашему запросу ничего не найдено...</h3>
            <?php endif ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
