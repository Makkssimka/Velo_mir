<div class="wrap importer-wrap">
    <h1 class="wp-heading-inline">Ручная проверка и обновление базы товаров</h1>
    <div id="col-container" class="wp-clearfix">
        <div id="col-left">
            <h2>Прогресс</h2>
            <p>Перед обновлением сделайте обмен с сайтом в 1С</p>
            <div class="progress-message display-none">
                <div class="active"></div>
                <p><strong>нет событий</strong></p>
            </div>
            <p>
                <button id="start-import" class="button button-primary">Импортировать данные</button>
                <button id="stop-import" class="button button-default disabled">Остановить импорт</button>
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
                    <td>Получение данных</td>
                    <td id="time-data">нет данных</td>
                    <td class="status-data">ожидает начала</td>
                </tr>
                <tr>
                    <td>Процесс миграции</td>
                    <td id="time-migrate">нет данных</td>
                    <td class="status-migrate">ожидает начала</td>
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