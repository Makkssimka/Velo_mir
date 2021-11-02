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
<div class="catalog-list-sort">
    <div class="filter-open-wrapper">
        <a href="#">
            <i class="las la-filter"></i>
        </a>
    </div>
    <div id="sort" class="select-input">
        <div class="select-input-value">
            <span></span>
            <i class="las la-angle-down"></i>
        </div>
        <div class="select-input-option">
            <?php foreach ($value_list as $key => $value): ?>
            <div data-value="<?= $key ?>" class="select-option-item <?= $key == $sort ? 'option-item-select' : ''  ?>"><?= $value ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>