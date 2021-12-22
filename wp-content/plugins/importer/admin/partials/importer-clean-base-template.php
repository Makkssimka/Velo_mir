<div class="wrap">
    <h1 class="wp-heading-inline">Очистка базы</h1>
    <div id="col-container" class="wp-clearfix">
        <div id="col-left">
            <h2>Прогресс</h2>
            <p><strong>Важно!!!</strong> Перед обновлением сделайте обмен с сайтом в 1С</p>
            <div class="progress-message display-none">
                <div class="active-load"></div>
                <p><strong>нет событий</strong></p>
            </div>
            <p>
                <button id="start-clean" class="button button-primary">Начать очистку</button>
                <button id="stop-clean" class="button button-default disabled">Остановить очистку</button>
            </p>
        </div>
        <div id="col-right">
            <h2>Статус</h2>
            <table class="widefat attributes-table wp-list-table ui-sortable" style="width:100%">
                <thead>
                <tr>
                    <th scope="col">Процесс</th>
                    <th scope="col">Затраченное время</th>
                    <th scope="col">Статус</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Распаковка архива</td>
                    <td id="time-unzip">нет данных</td>
                    <td width="200px" class="status-unzip">ожидает начала</td>
                </tr>
                <tr>
                    <td>Получение списка товаров с сайта</td>
                    <td id="time-products-data">нет данных</td>
                    <td width="200px" class="status-products-data">ожидает начала</td>
                </tr>
                <tr>
                    <td>Получение списка товаров импорта</td>
                    <td id="time-import-data">нет данных</td>
                    <td width="200px" class="status-import-data">ожидает начала</td>
                </tr>
                <tr>
                    <td>Получение списка товаров для удаления</td>
                    <td id="time-remove-data">нет данных</td>
                    <td width="200px" class="status-remove-data">ожидает начала</td>
                </tr>
                <tr>
                    <td>Процесс удаления</td>
                    <td id="time-cleaner">нет данных</td>
                    <td width="200px" class="status-cleaner">ожидает начала</td>
                </tr>
                <tr>
                    <td>Удаление временных файлов</td>
                    <td id="time-clean">нет данных</td>
                    <td class="status-clean">ожидает начала</td>
                </tr>
                <tr>
                    <td>Запись логов импорта</td>
                    <td id="time-logs">нет данных</td>
                    <td class="status-logs">ожидает начала</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>