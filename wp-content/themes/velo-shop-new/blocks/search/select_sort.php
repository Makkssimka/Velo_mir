<?php
$categories = $args['categories'];
$sort = $args['sort'];
?>

<div id="search_sort" class="select">
    <div class="select__result"></div>

    <div class="select__arrow">
        <img src="<?= get_asset_path('images/icons', 'select-arrow.svg') ?>" />
    </div>

    <div class="select__list">
            <a
                href="#"
                data-value=""
                class="select__item <?= !$sort ? 'select__item_select' : '' ?>"
            >
                Без категории
            </a>
        <?php foreach ($categories as $category) : ?>
            <a
                href="#"
                data-value="<?= $category->term_id ?>"
                class="select__item <?= $category->term_id == $sort ? 'select__item_select' : '' ?>"
            >
                <?= $category->name ?>
            </a>
        <?php endforeach ?>
    </div>
</div>