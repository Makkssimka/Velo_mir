<?php
$sort = 'new';

if (isset($_SESSION['sort'])) {
    $sort = $_SESSION['sort'];
}

$value_list = [
    "new"       => "Сначала новинки",
    "low"       => "Сначала дешевые",
    "costly"    => "Сначала дорогие",
    "popular"   => "Сначала популярные"
];
?>

<div class="container flex space-between align-center">
    <div class="breadcrumbs breadcrumbs_small desktop">
        <?php woocommerce_breadcrumb([
            'delimiter' => '<i><img src="' . get_asset_path('images/icons', 'breadcrumbs.svg') . '" alt="breadcrumbs"></i>'
        ]); ?>
    </div>

    <a href="#" class="filter__show mobile">
        <img src="<?= get_asset_path('images/icons', 'filter.svg') ?>">
        Фильтры
    </a>

    <div id="sort" class="select">
        <div class="select__result"></div>

        <div class="select__arrow">
            <img src="<?= get_asset_path('images/icons', 'select-arrow.svg') ?>" />
        </div>

        <div class="select__list">
            <?php foreach ($value_list as $key => $item) : ?>
                <a
                    href="<?= get_current_request(['session_sort' => $key]) ?>"
                    data-value="<?= $key ?>"
                    class="select__item <?= $key == $sort ? 'select__item_select' : '' ?>"
                >
                    <?= $item ?>
                </a>
            <?php endforeach ?>
        </div>
    </div>
</div>