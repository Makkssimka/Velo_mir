<?php
/**
 * The template for displaying product content in the single-product_importer.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product_importer.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}


$favorites_array = isset($_SESSION['favorites'])?json_decode($_SESSION['favorites']):array();
$is_favorites = in_array($product->get_id(), $favorites_array)?'Добавлен в избранное':'В избранное';

$compare_array = isset($_SESSION['compare'])?json_decode($_SESSION['compare']):array();
$is_compare = in_array($product->get_id(), $compare_array)?'Добавлен к сравнению':'В сравнение';

$product_category = get_term($product->get_category_ids()[0], 'product_cat');

?>

<div id="product-<?php the_ID(); ?>" class="content-main product">
    <div class="container">
        <h1><?= $product->get_name() ?></h1>
        <div class="product-sku">Артикул <?= $product->get_sku() ?></div>
        <div class="product-header">
            <?php require_once "blocks/product_gallery.php" ?>
            <div class="product-price">
                <div class="product-item-price-wrapper">
                    <div class="product-price-item">
                        <div class="product-old-price"><?= wc_price($product->get_regular_price()) ?></div>
                        <div class="product-new-price"><?= wc_price($product->get_price()) ?></div>
                    </div>
                </div>
                <?php require_once  "blocks/product_variation.php" ?>
                <?php require_once  "blocks/product_attributes.php" ?>
                <div class="product-button">
                    <?= add_cart_btn($product) ?>
                    <div>
                        <?= add_one_click_btn($product) ?>
                    </div>
                </div>
                <div class="product-action">
                    <ul>
                        <li><a class="add-compare" data-id="<?php the_ID(); ?>"href="#">
                                <i class="las la-balance-scale-left"></i>
                                <span class="result-text"><?= $is_compare ?></span>
                            </a>
                        </li>
                        <li>
                            <a class="add-favorites" data-id="<?php the_ID(); ?>" href="#">
                                <i class="lar la-star"></i>
                                <span class="result-text"><?= $is_favorites ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="product-more-info">
                    Возможна доставка и самовывоз. Оплата возможна наличным и безналичным расчетом. <a href="#">Подробнее...</a>
                </div>
            </div>
        </div>
        <div id="description" class="product-desription">
            <div class="product-decription-left">
                <?php require_once "blocks/product_tabs.php" ?>
            </div>
            <div class="product-decription-right">
                <?php expert_widget() ?>
            </div>
        </div>
        <div class="product-similar">
            <?php require_once "blocks/product_similar.php" ?>
        </div>
    </div>
</div>
