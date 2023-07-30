<div class="wrap">
    <h1 class="wp-heading-inline">Каталог цветов</h1>
    <div id="col-container" class="wp-clearfix">
        <div id="col-left">
            <div class="col-wrap">
                <p>Управление отображением цветов по их названию.</p>
                <p>Для добавления нового цвета нужно указать его название <strong>с маленькой буквы символами киррилицы</strong> и добавьте его HEX значеня со полностью <strong>(с символом # и 6 символами)</strong>. Например: </p>
                <p>Название цвет - <strong>красный</strong>, HEX значение цвета - <strong>#ff0000</strong></p>

                <div class="form-wrap">
                    <h2>Добавить цвет</h2>
                    <form method="post" action="">
                        <div class="form-field">
                            <label for="tag-color">Название</label>
                            <input name="color" id="tag-color" type="text" value="" size="40">
                            <p>Название с маленькой буквы и символами киррилицы</p>
                        </div>
                        <div class="form-field">
                            <label for="tag-hex">HEX значение</label>
                            <input name="hex" id="tag-hex" type="text" value="" size="40">
                            <p>hex значение цвета с символом # и 6 символами</p>
                        </div>

                        <p class="submit">
                            <input type="submit" name="submit" class="button button-primary" value="Добавить цвет">
                        </p>
                    </form>
                </div>
            </div>
        </div>

        <div id="col-right">
            <div class="col-wrap">
                <table class="wp-list-table widefat fixed striped table-view-list">
                    <thead>
                    <tr>
                        <th>Название цвета</th>
                        <th>hex</th>
                        <th>Опции</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach($colors as $color) :?>
                        <tr>
                            <td><?= $color->color ?></td>
                            <td><?= $color->hex ?></td>
                            <td>
                                <form method="post" action="">
                                    <input type="hidden" name="method" value="delete">
                                    <input type="hidden" name="id" value="<?= $color->id ?>">
                                    <button type="submit" class="button-link button-link-delete">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>