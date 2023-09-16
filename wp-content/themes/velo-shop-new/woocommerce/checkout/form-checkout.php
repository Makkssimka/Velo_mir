<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

global $post;
if ( ! defined( 'ABSPATH' ) ) exit;

?>

<?php get_template_part('blocks/breadcrumbs') ?>

<div class="container">
    <h1 class="h3"><?= $post->post_title; ?></h1>
    <div class="h6"><?= $post->post_excerpt; ?></div>

    <div class="grid grid-cart-order">
        <?php require_once "blocks/form-checkout-block.php" ?>
        <?php require_once "blocks/send-checkout.php" ?>
    </div>
</div>
