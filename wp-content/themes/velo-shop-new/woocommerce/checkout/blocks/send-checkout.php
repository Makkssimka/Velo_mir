<?php

$cart = WC()->cart;
$coupon = '';
foreach ($cart->get_coupons() as $coup) {
    $coupon = $coup->get_code();
};

?>

<div>
    <div class="cart-result__list">
        <?php foreach ($cart->get_cart() as $cart_item) : ?>
        <?php $product = $cart_item['data'] ?>
            <div class="cart-result__item">
                <div>
                    <?= $product->get_title() ?>
                </div>
                <div class="text_right">
                    <div class="cart-result__old-price">
                        <?= wc_price($cart_item['quantity'] * $product->get_regular_price()) ?>
                    </div>
                    <div class="cart-result__new-price">
                        <?= wc_price($cart_item['line_subtotal']) ?>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <div class="cart-result__total mt-2">
        <div class="cart-result__total-item">
            <div></div>
            <div class="cart-result__label">
                <?= num_word($cart->get_cart_contents_count()) ?>
            </div>
            <div class="text_right">
                <?= $cart->get_cart_subtotal() ?>
            </div>
        </div>

        <div class="cart-result__total-item">
            <div></div>
            <div class="cart-result__label">Ваш промокод</div>
            <div class="text_right"><?= $coupon ? $coupon : 'нет' ?></div>
        </div>

        <div class="cart-result__total-item">
            <div></div>
            <div class="cart-result__label">Ваша скидка</div>
            <div class="text_right">
                <?= wc_price($cart->get_cart_discount_total()) ?>
            </div>
        </div>

        <div class="cart-result__total-item cart-result__total-item_total">
            <div></div>
            <div class="cart-result__label text_upper">Итого</div>
            <div class="text_right">
                <?= $cart->get_cart_total() ?>
            </div>
        </div>
    </div>
</div>
