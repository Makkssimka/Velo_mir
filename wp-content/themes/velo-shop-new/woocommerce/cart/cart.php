<?php
/**
 * Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.8.0
 */
global $post;
defined( 'ABSPATH' ) || exit; ?>

<div class="content-main article cart">
    <h1><?= $post->post_title; ?></h1>
    <div class="article-subheader"><?= $post->post_excerpt; ?></div>
    <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
        <div class="product-cart-wrapper">
            <div class="loading cart-loading">
                <i class="las la-spinner"></i><span>
            </div>
            <?php require_once "blocks/cart_list.php" ?>
            <?php require_once "blocks/cart_total.php" ?>
        </div>
    </form>

</div>

