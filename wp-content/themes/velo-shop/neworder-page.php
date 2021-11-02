<?php
/* Template Name: New Order */

global $post;
$order_number = $_GET['order'];

?>

<?php get_header(); ?>
<div class="content-main article order">
    <h1><?= $post->post_title; ?></h1>
    <div class="article-subheader"><?= $post->post_excerpt; ?></div>
    <div class="article-content">
        <div class="article-text">
            <img src="<?= get_asset_path('images', 'cart.svg') ?>">
            <div class="order-number">Ваш заказ <span>№<?= $order_number ?></span> оформлен!</div>
            <?= $post->post_content ?>
            <div class="order-more-btn">
                <a class="btn btn-blue" href="/bikes-catalog">Продолжить покупки</a>
                <a class="btn btn-green" href="/">На главную</a>
            </div>
        </div>
        <div class="article-navbar">
            <?php expert_widget() ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
