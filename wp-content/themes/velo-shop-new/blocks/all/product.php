<?php
$product = $args['product'];
?>

<div class="catalog-item">
    <div>
      <div class="catalog-item__icons">
        <a href="#">
          <img src="<?= get_asset_path('images/icons', 'compare.svg') ?>" alt="compare">
        </a>

        <a href="#">
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

        <a href="#" class="catalog-item__button">
            <img src="<?= get_asset_path('images/icons', 'cart.svg') ?>" alt="cart">
        </a>
    </div>
</div>