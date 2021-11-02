<div class="wrap">
    <h1 class="wp-heading-inline">Список обратных звонков</h1>
    <hr class="wp-header-end">
    <ul class="subsubsub">
        <li class="all">
            <a href="#" class="current" aria-current="page">Все <span class="count">(<?= $all_count ?>)</span></a> |
        </li>
        <li class="not-processed">
            <a href="#">Необработанные <span class="count">(<?= $not_processed ?>)</span></a> |
        </li>
        <li class="processed">
            <a href="#">Обработанные <span class="count">(<?= $processed ?>)</span></a>
        </li>
    </ul>
    <form id="posts-filter" method="get">
        <input type="hidden" name="page" value="call-form">
        <?= $menu ?>
        <table class="wp-list-table widefat fixed striped table-view-list pages">
            <thead>
                <?= $menu_table ?>
            </thead>
            <tbody>
            <?php if (count($call_list)) : ?>
                <?php foreach ($call_list as $call_item) : ?>
                <tr id="call-<?= $call_item->id ?>" class="iedit author-self">
                    <th scope="row" class="check-column">
                        <input id="cb-select-<?= $call_item->id ?>" type="checkbox" name="call[]" value="<?= $call_item->id ?>">
                    </th>
                    <td class="title column-title has-row-actions column-primary page-title" data-colname="Имя">
                        <strong class="<?= $call_item->status ? "inactive-name" : "" ?>"><?= $call_item->name ?></strong>
                        <div class="row-actions">
                            <span class="id">ID: <?= $call_item->id ?> | </span>
                            <span class="delete">
                                <a href="<?= admin_url("admin.php?page=call-form&action=call-delete&id={$call_item->id}") ?>">Удалить</a> |
                            </span>
                            <span class="edit">
                                <a href="<?= admin_url("admin.php?page=call-form&action=call-change-status&id={$call_item->id}") ?>">
                                    Отметить <?= $call_item->status ? "необработанным" : "обработанным" ?>
                                </a>
                            </span>
                        </div>
                    </td>
                    <td class="telephone column-telephone" data-colname="Телефон">
                        <?= $call_item->telephone ?>
                    </td>
                    <td class="status column-status" data-colname="Статус">
                        <?php if ($call_item->status) : ?>
                        <span class="status-ok">Обработана</span>
                        <?php else : ?>
                        <span class="status-not">Не обработана</span>
                        <?php endif ?>
                    </td>
                    <td class="date-create column-date-create" data-colname="Дата заявки">
                        <?= date("d.m.Y \в H:i", strtotime($call_item->created_at)) ?>
                    </td>
                    <td class="date-processed column-date-processed" data-colname="Дата обработки">
                        <?php if ($call_item->processed_at) : ?>
                        <?= date("d.m.Y \в H:i", strtotime($call_item->processed_at)) ?>
                        <?php else : ?>
                        <span>Нет</span>
                        <?php endif ?>
                    </td>
                </tr>
                <?php endforeach ?>
            <?php else : ?>
                <tr class="no-items">
                    <td class="colspanchange" colspan="5">Заявок на звонок не найдено.</td>
                </tr>
            <?php endif ?>
            </tbody>

            <tfoot>
                <?= $menu_table ?>
            </tfoot>

        </table>
        <?= $menu ?>
    </form>
</div>