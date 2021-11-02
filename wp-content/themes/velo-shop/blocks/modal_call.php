<div class="modal-wrapper">
    <div class="modal">
        <div class="modal-close">
            <i class="las la-times"></i>
        </div>
        <div class="modal-form-wrapper">
            <div class="modal-header">Заказ обратного звонка</div>
            <div class="modal-input">
                <label class="errors">Обязательное поле</label>
                <input id="tel" type="text" name="tel" placeholder="Номер телефона">
            </div>
            <div class="modal-input">
                <label class="errors">Обязательное поле</label>
                <input id="name" type="text" name="name" placeholder="Ваше имя">
            </div>
            <div class="modal-desc">
                Нажимая на кнопку "Заказать", я подтверждаю, что ознакомлен и согласен с <a href="#">Политикой конфиденциальности</a> и даю письменное согласие на обработку своих персональных данных.
            </div>
            <div class="modal-button">
                <a href="#" class="btn btn-blue submit">Заказать</a>
            </div>
        </div>
        <div class="modal-message-wrapper modal-error modal-block-hide">
            <div class="modal-header">Что-то пошло не так!</div>
            <img src="<?= get_asset_path('images', 'error.svg') ?>">
            <p>Произошла ошибка! Повторите попытку позже.</p>
        </div>
        <div class="modal-message-wrapper modal-done modal-block-hide">
            <div class="modal-header">Заявка принята!</div>
            <img src="<?= get_asset_path('images', 'done.svg') ?>">
            <p>Спасибо за заявку! Ожидайте звонка нашего консультатнта.</p>
        </div>

    </div>
</div>