<?php
    $total_cart = WC()->cart;

    $coupon = '';
    foreach ($total_cart->get_coupons() as $coup) {
        $coupon = $coup->get_code();
    };
?>

<div class="cart-total">
    <div class="cart-total__item">
        <span>
            <?= num_word($total_cart->get_cart_contents_count()) ?>
        </span>
        <span class="text_bold"><?= $total_cart->get_cart_subtotal() ?></span>
    </div>

    <div class="cart-total__item">
        <span>Ваш купон</span>
        <span class="text_bold"><?= $coupon ? $coupon : 'нет' ?></span>
    </div>

    <div class="cart-total__item">
        <span>Скидка по купону</span>
        <span class="text_bold"><?= wc_price($total_cart->get_cart_discount_total()) ?></span>
    </div>

    <div class="cart-total__promo">
        <div class="text_bold">У меня есть промокод</div>

        <div class="cart-total__input my-1">
            <input data-coupon class="input_promo" type="text" placeholder="Промокод" value="<?= $coupon ?>">

            <a data-remove-coupon href="#">
                <img src="<?= get_asset_path('images/icons', 'remove.svg') ?>">
            </a>
        </div>

        <a data-send-coupon class="buttons buttons_blue-dark text_center w-full" href="#">Применить</a>
    </div>

    <div class="cart-total__result">
        <span class="text_upper">итого</span>
        <span class="text_bold"><?= $total_cart->get_cart_total() ?></span>
    </div>

    <a class="buttons buttons_orange buttons_upper text_center w-full mt-1" href="/checkout">ОФОРМИТЬ ЗАКАЗ</a>
</div>