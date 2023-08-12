<?php

$attribute = $args['attribute'];

// Старые значения фильтров
$item_value_list = array();
$filter_value = isset($_SESSION['filter']) ? json_decode($_SESSION['filter']) : '';
$filter_slug = $attribute['slug'];

if (property_exists($filter_value, $attribute['slug'])) {
    $item_value_list = $filter_value->$filter_slug;
}

// Перебираем все значения аттрибутов и собираем одинаковые в массив и подсчитываем количество
$terms_list = [];
foreach ($attribute['terms'] as $term) {
    if(!isset($term['options'][0])) continue;

    $term = get_term($term['options'][0]);
    if (array_key_exists($term->term_id, $terms_list)) {
        $terms_list[$term->term_id]['count'] = $terms_list[$term->term_id]['count'] + 1;
    } else {
        $terms_list[$term->term_id]['id'] = $term->term_id;
        $terms_list[$term->term_id]['name'] = string_crop($term->name, 26);
        $terms_list[$term->term_id]['slug'] = $term->slug;
        $terms_list[$term->term_id]['taxonomy'] = $term->taxonomy;
        $terms_list[$term->term_id]['count'] = 1;
    }
}

?>

<div class="filter__block">
    <div class="filter__label">
        <?= $attribute['name'] ?>
    </div>

    <div class="filter__option">
        <div class="filter__list">
            <?php foreach ($terms_list as $item) : ?>
                <div class="filter__item">
                    <input
                        id="<?= $item['slug'] ?>"
                        name="<?= $item['taxonomy'] ?>"
                        type="checkbox"
                        value="<?= $item['slug'] ?>"
                        <?= in_array($item['slug'], $item_value_list) ? 'checked' : '' ?>
                    >

                    <label for="<?= $item['slug'] ?>">
                        <?= $item['name'] ?> <span>(<?= $item['count'] ?>)</span>
                    </label>
                </div>
            <?php endforeach ?>
        </div>

        <div class="filter__button mt-05">
            <a href="#" class="filter__link link link_sm">Показать все</a>
        </div>
    </div>
</div>
