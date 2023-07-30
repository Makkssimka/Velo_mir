<?php
    $total_cart = WC()->cart;
    $coupon = '';
    foreach ($total_cart->get_coupons() as $coup) {
        $coupon = $coup->get_code();
    };
?>
<div class="cart-total">
    <div class="cart-total-wrapper">

        <div class="cart-total-subtotal">
            Стоимость товара: <span><?= $total_cart->get_cart_subtotal() ?></span>
        </div>
        <div class="cart-total-my-coupon">
            Ваш купон: <span><?= $coupon ? $coupon : 'нет' ?></span>
        </div>
        <div class="cart-total-sale">
            Скидка: <span><?= wc_price($total_cart->get_cart_discount_total()) ?></span>
        </div>
        <hr>
        <div class="cart-total-header">У меня есть промокод:</div>
        <div class="cart-total-coupon">
            <div class="cart-coupon-input">
                <input id="coupon" type="text" placeholder="промокод" value="<?= $coupon ?>">
                <i class="las la-times cart-coupon-remove"></i>
            </div>
            <a href="#" class="btn btn-blue btn-coupon">Применить</a>
        </div>
        <hr>
        <div class="cart-total-header cart-total-sum">Итого: <span><?= $total_cart->get_cart_total() ?><span></div>
        <div class="cart-total-submit">
            <a href="/checkout" class="btn btn-green">Оформить заказ</a>
        </div>
    </div>
</div>