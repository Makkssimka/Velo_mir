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

<div class="content-main article cart-empty">
    <h1>Ваша корзина пуста</h1>
    <div class="article-subheader">Вы не добавили не одного товара</div>
    <div class="article-content">
        <div class="article-text">
            <img src="<?= get_asset_path('images', 'empty_cart.svg') ?>">
            <div class="empty-head">Ваша корзина пуста!</div>
            <p>Выберите товар для продолжения оформления заказа</p>
            <div class="empty-more-btn">
                <a class="btn btn-green" href="/">На главную</a>
            </div>
        </div>
        <div class="article-navbar">
            <?php expert_widget() ?>
        </div>
    </div>
</div>

<?php endif; ?>
