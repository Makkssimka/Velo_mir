<div id="modal_call" class="modal">
    <div class="modal__content">
        <img class="modal__close" src="<?= get_asset_path('images/icons', '/close-modal.svg') ?>" alt="">

        <form data-role="form">
            <div class="modal__header mb-2">Заказ обратного звонка</div>

            <div class="relative">
                <div class="input-form__message"></div>
                <input data-valid="required" name="tel" class="input-form w-full mb-1 phone-mask" type="text"
                       placeholder="Номер телефона">
            </div>

            <div class="relative">
                <div class="input-form__message"></div>
                <input data-valid="required" name="name" class="input-form w-full mb-1" type="text"
                       placeholder="Ваше имя">
            </div>

            <div class="input__checkbox mb-1">
                <input id="politic" type="checkbox" checked>
                <label class="modal__politic" for="politic">
                    Я подтверждаю, что ознакомлен и согласен с <a class="link_under" href="#">Политикой
                        конфиденциальности</a> и даю согласие на обработку своих персональных данных.
                </label>
            </div>

            <a class="buttons buttons_blue buttons_full buttons_upper modal__submit" href="#">Заказать</a>
        </form>

        <div class="modal__message">
            <div class="modal__header mb-2">Ваш запрос отправлен</div>
            <p class="text_center">Наш менеджер свяжется с Вами в ближайшее время!</p>
        </div>
    </div>
</div>