<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

if ( wc_get_page_id( 'cart' ) > 0 ) : ?>

<?php get_template_part('blocks/breadcrumbs') ?>

<div class="container">
    <h1 class="h3">Ваша корзина пуста</h1>
    <div class="h6">Вы не добавили не одного товара</div>
    <div class="text_center">
        <img width="250px" src="<?= get_asset_path('images/content', 'order_empty.svg') ?>" alt="order empty">
        <div class="mt-2">Ваша корзина пуста!</div>
        <div class="mt-2">Выберите товар для продолжения оформления заказа</div>
        <div class=" mt-2 flex justify-center gap-1">
            <a href="/" class="buttons buttons_blue">На главную</a>
        </div>
    </div>
</div>

<?php endif; ?>
