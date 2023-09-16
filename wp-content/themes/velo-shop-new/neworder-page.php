<?php
/* Template Name: New Order */

global $post;
$order_number = $_GET['order'];

?>

<?php get_header(); ?>

<?php get_template_part('blocks/breadcrumbs') ?>

<div class="container">
    <h1 class="h3"><?= $post->post_title; ?></h1>
    <div class="h6"><?= $post->post_excerpt; ?></div>
    <div class="text_center">
        <img width="250px" src="<?= get_asset_path('images/content', 'order_success.svg') ?>" alt="order success">
        <div class="mt-2">Ваш заказ <span class="h3">№<?= $order_number ?></span> оформлен!</div>
        <div class="mt-2">В ближайшее время с Вами свяжется наш консультант для уточнения заказа. После его обработки на указанную Вами почту придет письмо с деталями заказа.</div>
        <div class=" mt-2 flex justify-center gap-1">
            <a href="/product-category/velosipedy/" class="buttons buttons_orange">Продолжить покупки</a>
            <a href="/" class="buttons buttons_blue">На главную</a>
        </div>
    </div>
</div>

<?php get_footer(); ?>
