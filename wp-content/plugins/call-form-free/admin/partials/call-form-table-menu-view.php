<tr>
    <td id="cb" class="manage-column column-cb check-column">
        <label class="screen-reader-text" for="cb-select-all-1">Выделить все</label>
        <input id="cb-select-all-1" type="checkbox">
    </td>
    <th scope="col" id="name" class="manage-column column-title column-primary <?= $order_by == 'name' ? 'sorted' : 'sortable' ?> <?= $order ?>">
        <a href="<?= admin_url("admin.php?page=call-form&orderby=name&order=$new_order") ?>">
            <span>Имя</span>
            <span class="sorting-indicator"></span>
        </a>
    </th>
    <th scope="col" id="telephone" class="manage-column column-author">Номер телефона</th>
    <th scope="col" id="status" class="manage-column column-title column-primary <?= $order_by == 'status' ? 'sorted' : 'sortable' ?> <?= $order ?>">
        <a href="<?= admin_url("admin.php?page=call-form&orderby=status&order=$new_order") ?>">
            <span>Статус</span>
            <span class="sorting-indicator"></span>
        </a>
    </th>
    <th scope="col" id="date" class="manage-column column-title column-primary <?= $order_by == 'created_at' ? 'sorted' : 'sortable' ?> <?= $order ?>">
        <a href="<?= admin_url("admin.php?page=call-form&orderby=created_at&order=$new_order") ?>">
            <span>Дата заявки</span>
            <span class="sorting-indicator"></span>
        </a>
    </th>
    <th scope="col" id="date" class="manage-column column-title column-primary <?= $order_by == 'processed_at' ? 'sorted' : 'sortable' ?> <?= $order ?>">
        <a href="<?= admin_url("admin.php?page=call-form&orderby=processed_at&order=$new_order") ?>">
            <span>Дата обработки</span>
            <span class="sorting-indicator"></span>
        </a>
    </th>
</tr>