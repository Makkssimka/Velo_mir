<div class="wrap log-wrap">
    <h1 class="wp-heading-inline">Логи импорта 1С</h1>
    <p>Здесь Вы сможете увидеть данные по импорту из 1С</p>
    <form method="get">
        <input type="hidden" name="page" value="import-log">
        <p>
            <a href="<?= $file_url ?>" id="submit" class="button button-primary" download="Файл логов Importer">Скачать файл логов</a>
            <button type="submit" name="action" class="button" value="clear-logs">Очистить логи</button>
        </p>
        <?php if (count($file_data)) : ?>
        <table class="widefat striped health-check-table">
            <?php foreach ($file_data as $line) : ?>
            <tr>
                <td><?= $line ?></td>
            </tr>
            <?php endforeach ?>
        </table>
        <?php else : ?>
            <table class="widefat striped health-check-table">
               <tr>
                   <th>Файл логов пуст</th>
               </tr>
            </table>
        <?php endif ?>
        <p>
            <a href="<?= $file_url ?>" id="submit" class="button button-primary" download="Файл логов Importer">Скачать файл логов</a>
            <button type="submit" name="action" class="button" value="clear-logs">Очистить логи</button>
        </p>
    </form>
</div>