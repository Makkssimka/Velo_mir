<?php

$address_list = explode('?', get_option('address'));

?>

<form class="cart-form" data-role="form">
    <div class="cart-form__item">
        <label>Имя*</label>
        <div class="relative">
            <div class="input-form__message"></div>
            <input data-valid="required" name="name" class="input-form w-full" type="text" placeholder="Иван">
        </div>
    </div>

    <div class="cart-form__item">
        <label>Фамилия</label>
        <div class="relative">
            <div class="input-form__message"></div>
            <input name="last_name" class="input-form w-full" type="text" placeholder="Иванов">
        </div>
    </div>

    <div class="cart-form__item">
        <label>Электронная почта*</label>
        <div class="relative">
            <div class="input-form__message"></div>
            <input data-valid="required" name="email" class="input-form w-full" type="text" placeholder="IvanIvanov@mail.ru">
        </div>
    </div>

    <div class="cart-form__item">
        <label>Телефон*</label>
        <div class="relative">
            <div class="input-form__message"></div>
            <input data-valid="required" name="telephone" class="input-form w-full phone-mask" type="text" placeholder="+7(901)111-01-01">
        </div>
    </div>

    <div class="cart-form__item cart-form__item_top">
        <label>Комментарий к заказу</label>
        <div class="relative">
            <div class="input-form__message"></div>
            <textarea name="comment" rows="4" class="input-form w-full" placeholder="Ваш комментарий"></textarea>
        </div>
    </div>

    <div class="cart-form__item mt-2">
        <div></div>
        <a id="send-order" href="#" class="buttons buttons_upper buttons_orange text_center">Оформить заказ</a>
    </div>
</form>