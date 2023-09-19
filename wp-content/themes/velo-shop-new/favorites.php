<?php
/* Template Name: Favorites */

global $post;
global $favorite_ids;

if ($favorite_ids) {
    $products = wc_get_products(array(
        'include' => $favorite_ids
    ));
}

?>

<?php get_header(); ?>

<?php get_template_part('blocks/breadcrumbs') ?>

<div class="container content">
    <h1 class="h3"><?= $post->post_title; ?></h1>
    <div class="h6"><?= $post->post_excerpt; ?></div>

    <?php if (count($favorite_ids)) : ?>
        <div class="catalog-list catalog-list_5">
            <?php foreach ($products as $product) : ?>
                <?php get_template_part('blocks/all/product', null, ['product' => $product]) ?>
            <?php endforeach ?>
        </div>
    <?php else : ?>
        <div class="text_center">
            <img width="160px" src="<?= get_asset_path('images/content', 'order_empty.svg') ?>" alt="order empty">
            <div class="mt-2">У Вас нет избранных товаров!</div>
            <div class="mt-1">Добавьте товары в избранные, чтобы не потерять их</div>
            <div class=" mt-2 flex justify-center gap-1">
                <a href="/" class="buttons buttons_blue">На главную</a>
            </div>
        </div>
    <?php endif ?>
</div>

<?php get_footer(); ?>
