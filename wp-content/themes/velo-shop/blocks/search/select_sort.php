<div class="search-filter">
    Категория товара
    <div id="search_sort" class="select-input">
        <div class="select-input-value">
            <span></span>
            <i class="las la-angle-down"></i>
        </div>
        <div class="select-input-option">
            <div data-value="" class="select-option-item <?= !$sort ? 'option-item-select' : ''  ?>">
                Выберите категорию
            </div>
            <?php foreach ($categories as $category): ?>
                <div data-value="<?= $category->term_id ?>" class="select-option-item <?= $category->term_id == $sort ? 'option-item-select' : ''  ?>"><?= $category->name ?></div>
            <?php endforeach; ?>
        </div>
    </div>
</div>