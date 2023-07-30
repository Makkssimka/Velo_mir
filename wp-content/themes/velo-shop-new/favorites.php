<?php
/* Template Name: Favorites */

global $post;

$favorites_ids = (isset($_SESSION['favorites'])) ? json_decode($_SESSION['favorites']) : array();

if ($favorites_ids) {
    $bikes = wc_get_products(array(
        'include' => $favorites_ids
    ));
}

?>

<?php get_header(); ?>

<div class="content-main article favorites">
    <div class="container">
        <h1><?= $post->post_title; ?></h1>
        <div class="article-subheader"><?= $post->post_excerpt; ?></div>
        <div class="article-content">
            <div class="article-text">
                <?php if (count($favorites_ids)) : ?>
                    <div class="favorites-list">
                        <?php foreach ($bikes as $bike) : ?>
                            <?= bike_widget($bike, true) ?>
                        <?php endforeach ?>
                    </div>
                <?php else : ?>
                    <div class="empty">
                        <img src="<?= get_asset_path('images', 'empty_page.svg') ?>">
                        <div class="empty-head">Нет избранных товаров!</div>
                        <p>Вы не добавили ни одного товара в избранные</p>
                        <div class="empty-more-btn">
                            <a class="btn btn-green" href="/">На главную</a>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
