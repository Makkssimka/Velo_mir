<?php

$cart = WC()->cart;

?>
<div class="send-checkout">
    <div class="send-checkout-wrapper">
        <div class="checkout-product-list">
    <?php foreach ($cart->get_cart() as $cart_item_key => $cart_item) : ?>
        <?php $product = wc_get_product($cart_item['product_id']) ?>
        <div class="checkout-product-item">
            <div class="checkout-product-title">
                <span>
                    <?= $product->get_title() ?>
                </span>
                <i class="las la-times"></i>
                <?= $cart_item['quantity'] ?>
            </div>
            <div class="checkout-product-price">
                <?= wc_price($cart_item['line_subtotal']) ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="checkout-total-wrapper">
        <div class="checkout-subtotal">
            Всего:
            <?= $cart->get_cart_subtotal() ?>
        </div>
        <div class="checkout-sale">
            Скидка:
            <?= wc_price($cart->get_cart_discount_total()) ?>
        </div>
        <div class="checkout-total">
            Итого:
            <?= $cart->get_cart_total() ?>
        </div>
    </div>
    <div class="checkout-btn-wrapper">
        <a href="#" class="btn btn-green send-order">Оформить заказ</a>
    </div>
</div>
    </div>
</div>
