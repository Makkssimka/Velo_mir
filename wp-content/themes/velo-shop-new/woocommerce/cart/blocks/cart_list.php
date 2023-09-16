<div class="cart-table">
    <div class="cart-table__item cart-table__head">
        <div class="desktop">Товар</div>
        <div class="text_center desktop">Количество</div>
        <div class="desktop">Цена</div>
        <div class="desktop"></div>
    </div>

    <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) : ?>
    <?php $product = $cart_item['data'] ?>
        <div class="cart-table__item cart-table__product">
            <div class="flex align-center">
                <div
                    class="cart-table__preview"
                    style="background-image: url('<?= get_image_link($product) ?>');">
                </div>

                <a href="<?= get_permalink($product->get_id()) ?>">
                    <?= $product->get_title() ?>
                </a>
            </div>

            <div class="cart-table__counter">
                <a data-cart-counter="down" data-key="<?= $cart_item['key'] ?>" href="#">
                    <img src="<?= get_asset_path('images/icons', 'minus.svg') ?>">
                </a>

                <div data-cart-count class="cart-table__count">
                    <?= $cart_item['quantity'] ?>
                </div>

                <a data-cart-counter="up" data-key="<?= $cart_item['key'] ?>" href="#">
                    <img src="<?= get_asset_path('images/icons', 'plus.svg') ?>">
                </a>
            </div>

            <div class="cart-table__price">
                <div class="cart-table__price_old">
                    <?= wc_price($cart_item['quantity'] * $product->get_regular_price()) ?>
                </div>
                <div class="cart-table__price_new">
                    <?= wc_price($cart_item['line_subtotal']) ?>
                </div>
            </div>

            <div class="cart-table__remove">
                <a data-cart-remove data-key="<?= $cart_item['key'] ?>" href="#">
                    <img src="<?= get_asset_path('images/icons', 'remove.svg') ?>">
                </a>
            </div>
        </div>
    <?php endforeach ?>
</div>