<div class="wrap">
    <h1 class="wp-heading-inline">Список обратных звонков</h1>
    <form method="post" action="options.php">
        <?php settings_fields('call-form-settings') ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="emails">Список email</label>
                    </th>
                    <td>
                        <textarea rows="2" name="emails" id="emails" class="regular-text" placeholder="petrov@mail.ru, ivanov@mail.ru"><?= get_option('emails') ?></textarea>
                        <p class="description" id="emails">Список email адресов для рассылки заявок, через запятую</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="telegram_ids">Список telegram id</label>
                    </th>
                    <td>
                        <input name="telegram_ids" type="text" id="telegram_ids" class="regular-text" placeholder="56777445664, 34445665776" value="<?= get_option('telegram_ids') ?>">
                        <p class="description" id="telegram_ids">Список id для рассылки заявок в telegram, через запятую</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="call_show">Форма обратной связи</label>
                    </th>
                    <td>
                        <label for="call_show">
                            <input name="call_show" type="checkbox" id="call_show" <?= get_option('call_show') ? "checked" : "" ?> value="1">
                            Показать форму обратной связи
                        </label>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php submit_button() ?>
    </form>
</div>