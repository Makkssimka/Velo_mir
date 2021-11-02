<div class="wrap importer-wrap">
    <h1 class="wp-heading-inline">Заполнение артикулами пустых товаров</h1>
    <p>Заполнение артикула для товаров без него</p>
    <p>
        <a id="sku-generator" href="#" class="button button-primary">Генерировать артикулы</a>
    </p>
    <table id="sku-table" class="widefat striped">
        <tr>
            <td class="first-td-importer">
                <span class="importer-title">Товаров без артикула</span>
            </td>
            <td>
                <span class="importer-title"><?= $products_not_sku_counter ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <?php if ($products_not_sku_counter) :?>
                    <span class="status-not">Найдены товары без артикула</span> нажмите кнопку "Генерировать артикулы"
                <?php else: ?>
                    <span class="status-ok">У всех товаров есть артикул</span> никаких действий не требуется
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>