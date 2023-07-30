<?php
/* Template Name: Search */

$search_word = isset($_GET['search']) ? $_GET['search'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$offset_page = isset($_GET['page_count']) ? $_GET['page_count'] : 1;

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

$categories = get_categories(array('taxonomy' => 'product_cat'));
?>

<?php get_header(); ?>

<div class="content-main article search">
    <div class="container">
        <?php if($search_word) : ?>
            <h1><?= $post->post_title; ?>: <?= $search_word ?></h1>
        <?php else : ?>
            <h1>Пустой запрос</h1>
        <?php endif ?>
        <div class="article-subheader"><?= $post->post_excerpt; ?></div>
        <form action="/search" method="get">
            <div class="search-input-wrapper">
                <input type="text" name="search" value="<?= $search_word ?>" placeholder="Искать">
                <button type="submit">Найти</button>
            </div>
        </form>
        <div class="search-result-wrapper">
            <?php if (count($result_search)) : ?>
                <div class="search-list-wrapper">
                    <div class="search-list-body">
                        <?php foreach ($result_search as $item) : ?>
                            <?php bike_widget($item, false) ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="search-list-header">
                        <h3>По вашему запросу найдено <?= num_word($products_obj->total) ?></h3>
                        <?php require_once "blocks/search/select_sort.php" ?>
                    </div>
                </div>
                <?php require_once "blocks/search/pagination.php" ?>
            <?php else : ?>
                <h3>По вашему запросу ничего не найдено...</h3>
            <?php endif ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
