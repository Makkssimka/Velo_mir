<?php

global $product;

$sale = round((1 - $product->get_sale_price() / $product->get_regular_price()) * 100);
?>

<div class="info">

    <?php get_template_part('woocommerce/blocks/product-variation') ?>

    <?php get_template_part('woocommerce/blocks/product-attributes') ?>

    <div class="info__price mt-2">
        <div class="flex align-center">
            <div class="info__price_old"><?= wc_price($product->get_regular_price()) ?></div>
            <div class="info__sale ml-1">-<?= $sale ?>%</div>
        </div>
        <div class="info__price_new mt-05"><?= wc_price($product->get_sale_price()) ?></div>
    </div>

    <div class="info__button mt-4">
        <a href="#" class="buttons buttons_upper buttons_orange">
            <img src="<?= get_asset_path('images/icons', 'cart-white.svg') ?>">
            <span class="ml-1">Добавить в корзину</span>
        </a>

        <a class="link_under mt-05" href="#">Купить в один клик</a>
    </div>
</div>