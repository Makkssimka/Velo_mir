<div class="wrap">
    <h1 class="wp-heading-inline">Импорт категорий</h1>
    <div id="col-container" class="wp-clearfix">
        <div id="col-left" class="pos-sticky">
            <div class="col-wrap">
                <p>Здесь вы можете управлять импортом категорий. Перед импортированием категорий Вы можете объединить или переименовать категории в новые категории.</p>
                <div class="form-wrap">
                    <h2>Импорт</h2>
                    <p>Во время импорта будт добавлены новые категории и обновлены старые</p>
                    <div class="progress-categories display-none">
                        <progress class="my-30" max="0" value="0"></progress>
                        Импортировано <span id="step-categories">0</span> из <span id="all-categories">18</span> категорий
                    </div>
                    <div class="form-button">
                        <button id="importCat" class="button button-primary">Импортировать</button>
                    </div>
                </div>
                <div class="form-wrap mt-30">
                    <h2>Перименование и объединение</h2>
                    <p class="description">Для переименования выделите нужную категорию в таблице справа, введите новое название и нажмите переименовать. Для обединения выделите несколько категорий из таблицы справа и нажмите объединить.</p>
                    <h2>Выбрано элементов: <span class="counter-categories">0</span></h2>
                    <div class="form-field form-required term-name-wrap">
                        <label for="cat-name">Новое название</label>
                        <input id="cat-name" type="text" size="40">
                        <p>Название определяет, как категория будет отображаться на вашем сайте.</p>
                    </div>
                    <div class="form-button">
                        <button class="button button-primary categories-concat disabled">Объединить</button>
                        <button class="button category-rename disabled">Переименовать</button>
                    </div>
                </div>
            </div>
        </div>
        <div id="col-right">
            <div class="col-wrap">
                <table class="wp-list-table widefat fixed striped posts">
                    <thead>
                        <tr>
                            <td id="cb" class="manage-column column-cb check-column">
                                <label class="screen-reader-text" for="cb-select-all-1">Выделить все</label>
                                <input id="cb-select-all-1" type="checkbox">
                            </td>
                            <th scope="col" class="manage-column">Название в 1с</th>
                            <th scope="col" class="manage-column">Ид в 1с</th>
                            <th scope="col" class="manage-column">Наличие на сайте</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $category) : ?>
                        <tr>
                            <th scope="row" class="check-column">
                                <input
                                    class="category-edit"
                                    type="checkbox"
                                    data-name="<?= $category->getName() ?>"
                                    data-parent="<?= $category->getParent() ?>"
                                    value="<?= $category->getId() ?>"
                                >
                            </th>
                            <td>
                                <strong class="category-name-wrap">
                                    <span class="category-prefix">
                                        <?= IM_Helper::tabNameCategory($category, $categories) ?>
                                    </span>
                                    <span class="category-name">
                                        <?= $category->getName(); ?>
                                    </span>
                                </strong>
                            </td>
                            <td class="category-id"><?= $category->getId() ?></td>
                            <td>
                                <?php if (isset($site_categories[$category->getId()])) : ?>
                                    <span class="status-ok">
                                        есть,
                                    </span>
                                    название <strong><?= $site_categories[$category->getId()]['name'] ?></strong>
                                <?php else : ?>
                                    <span class="status-not">
                                        нет
                                    </span>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php endforeach ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td id="cb" class="manage-column column-cb check-column">
                                <label class="screen-reader-text" for="cb-select-all-1">Выделить все</label>
                                <input id="cb-select-all-1" type="checkbox">
                            </td>
                            <th scope="col" class="manage-column">Название в 1с</th>
                            <th scope="col" class="manage-column">Ид в 1с</th>
                            <th scope="col" class="manage-column">Наличие на сайте</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
