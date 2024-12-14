<?php
global $cart_ids;
global $favorite_ids;
global $compare_ids;
$product = $args['product'];

$product_term = get_the_terms($product->get_id(), 'product_tag')[0]->name ?? '';
$tip = $product->get_attribute('tip-ts');

if ($tip) {
    $name = $tip . ' ' . $product_term;
} else {
    $name = $product->get_name();
}
?>

<div class="catalog-item">
    <div>
      <div class="catalog-item__icons">
        <a
            href="#"
            data-compare="<?= $product->get_id() ?>"
            class="<?= in_array($product->get_id(), $compare_ids) ? 'selected_blue' : '' ?>"
        >
          <img src="<?= get_asset_path('images/icons', 'compare.svg') ?>" alt="compare">
        </a>

        <a
            href="#"
            data-favorite="<?= $product->get_id() ?>"
            class="<?= in_array($product->get_id(), $favorite_ids) ? 'selected_orange' : '' ?>"
        >
          <img src="<?= get_asset_path('images/icons', 'heart.svg') ?>" alt="heart">
        </a>
      </div>

      <div
        class="catalog-item__image"
        style="background-image: url('<?= get_image_link($product) ?>');">
      </div>

      <div class="catalog-item__slug mt-1">
        Артикул <?= $product->get_sku() ?>
      </div>

      <div class="catalog-item__title">
        <a href="<?= get_permalink($product->get_id()) ?>"><?= $product->get_name() ?></a>
      </div>
    </div>

    <div class="catalog-item__info">
        <div class="catalog-item__price">
            <div class="catalog-item__price_old"><?= wc_price($product->get_regular_price()) ?></div>
            <div class="catalog-item__price_new"><?= wc_price($product->get_sale_price()) ?></div>
        </div>

        <a
            <?= in_array($product->get_id(), $cart_ids) ? '' : 'data-add-cart' ?>
            data-product="<?= $product->get_id() ?>"
            href="/cart"
            class="catalog-item__button <?= in_array($product->get_id(), $cart_ids) ? 'catalog-item__button_active' : '' ?>"
        >
            <img src="<?= get_asset_path('images/icons', 'cart.svg') ?>" alt="cart">
            <img src="<?= get_asset_path('images/icons', 'cart-check.svg') ?>" alt="cart">
        </a>
    </div>
</div>