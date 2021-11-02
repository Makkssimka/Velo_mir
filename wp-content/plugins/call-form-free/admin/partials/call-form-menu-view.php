<div class="tablenav top">
    <div class="alignleft actions bulkactions">
        <label for="bulk-action-selector-top" class="screen-reader-text">Выберите массовое действие</label>
        <select name="action" id="bulk-action-selector-top">
            <option disabled selected>Действия</option>
            <option value="calls-change-status">Обработан</option>
            <option value="calls-delete">Удалить</option>
        </select>
        <input type="submit" class="button" value="Применить">
    </div>
    <?php if ($pages) : ?>
    <div class="tablenav-pages">
        <span class="displaying-num"><?= $all_count ?> <?= Call_Form_Helper::getElemNum($all_count) ?></span>
        <span class="pagination-links">
            <?php if ($call_page > 1) : ?>
            <a class="prev-page button" href="<?= Call_Form_Helper::getNavUrl(1) ?>">
                <span class="screen-reader-text">Следующая страница</span><span aria-hidden="true">«</span>
            </a>
                <a class="prev-page button" href="<?= Call_Form_Helper::getNavUrl($prev_page) ?>">
                    <span class="screen-reader-text">Следующая страница</span><span aria-hidden="true">‹</span>
                </a>
            <?php else : ?>
            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
            <span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
            <?php endif ?>
            <span class="paging-input">
                <label for="current-page-selector" class="screen-reader-text">Текущая страница</label>
                <input class="current-page" id="current-page-selector" type="text" name="paged" value="<?= $call_page ?>" size="1" aria-describedby="table-paging">
                <span class="tablenav-paging-text"> из <span class="total-pages"><?= $pages ?></span></span>
            </span>
            <?php if ($call_page != $pages) :?>
                <a class="next-page button" href="<?= Call_Form_Helper::getNavUrl($next_page) ?>">
                    <span class="screen-reader-text">Следующая страница</span><span aria-hidden="true">›</span>
                </a>
                <a class="next-page button" href="<?= Call_Form_Helper::getNavUrl($pages) ?>">
                    <span class="screen-reader-text">Следующая страница</span><span aria-hidden="true">»</span>
                </a>
            <?php else : ?>
                <span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span>
                <span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
            <?php endif ?>

        </span>
    </div>
    <?php endif ?>
</div>