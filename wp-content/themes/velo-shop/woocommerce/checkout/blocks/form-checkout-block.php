<?php

$address_list = explode('?', get_option('address'));

?>
<div class="form-checkout">
   <div class="form-checkout-wrapper">
       <div class="form-wrapper">
           <label for="names">Имя<span>*</span></label>
           <input class="require" id="names" type="text" placeholder="Петр">
           <div class="info-wrapper">
               <i class="las la-question-circle title-show" data-title="Наш менеджер будет обращатся к Вам по этому имени"></i>
           </div>
       </div>
       <div class="form-wrapper">
           <label for="last-name">Фамилия</label>
           <input id="last-name" type="text" placeholder="Петров">
       </div>
       <div class="form-wrapper">
           <label for="email">Адрес электронной почты<span>*</span></label>
           <input class="require" id="email" type="text" placeholder="petr-petrov@yandex.ru">
           <div class="info-wrapper">
               <i class="las la-question-circle  title-show" data-title="На эту почту будет отправлено письмо с подробностями о заказе"></i>
           </div>
       </div>
       <div class="form-wrapper">
           <label for="telephone">Номер телефона<span>*</span></label>
           <input class="require" id="telephone" type="text" placeholder="+7 (988) 456-45-45">
           <div class="info-wrapper">
               <i class="las la-question-circle title-show" data-title="На данный номер позвонит наш менеджер для уточнения деталей заказа"></i>
           </div>
       </div>
       <div class="radio-box-wrapper">
            <label>Выберите магазин откуда забрать заказ<span>*</span></label>
           <div class="address-wrapper">
               <?php foreach ($address_list as $index => $address) : ?>
                   <div class="item-address">
                       <input id="adress<?= $index ?>" type="radio" name="address" value="<?= trim($address) ?>" <?= $index==0?'checked':'' ?>>
                       <label for="adress<?= $index ?>"><?= trim($address) ?></label>
                   </div>
               <?php endforeach; ?>
           </div>
       </div>
       <div class="form-wrapper comment-checkout">
           <label for="comment">Комментарий к заказу</label>
           <textarea id="comment" type="text" placeholder="Ваш комментарий" rows="6"></textarea>
       </div>
    </div>
</div>