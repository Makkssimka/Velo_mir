<?php

function filter_item_widget($attribute){

    $list_item = '';
    $open_block = '';

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
        print_r($term['options'][0]);
        $term = get_term($term['options'][0]);
        if (array_key_exists($term->term_id, $terms_list)) {
            $terms_list[$term->term_id]['count'] = $terms_list[$term->term_id]['count'] + 1;
        } else {
            $terms_list[$term->term_id]['id'] = $term->term_id;
            $terms_list[$term->term_id]['name'] = $term->name;
            $terms_list[$term->term_id]['slug'] = $term->slug;
            $terms_list[$term->term_id]['taxonomy'] = $term->taxonomy;
            $terms_list[$term->term_id]['count'] = 1;
        }
    }

    // Перебираем полученные значения и формируем список с чекбосами

    foreach ($terms_list as $item) {
        $list_item .= '
        <div>
            <input 
                type="checkbox" 
                name="'.$item['taxonomy'].'" 
                id="'.$item['id'].'" 
                value="'.$item['slug'].'"
                '.(in_array($item['slug'], $item_value_list) ? 'checked' : '').'>';
        $list_item .= '<label for="'.$item['id'].'">'.$item['name'].' <span>('.$item['count'].')</span></label>';
        $list_item .= '</div>';
    }

    // Если больше 5 разных значений добавляем кнопку развернуть
    if(count($terms_list) > 5) {
        $open_block = '
            <div>
                <a class="open-list-filter" href="#"><span>Развернуть</span> <i class="las la-angle-down"></i></a>
            </div>';
    }

    // Выводим результат
    echo '
    <div class="catalog-filter-block">
        <div class="catalog-filter-label">'.$attribute['name'].'</div>
        <div class="catalog-filter-option">
           '.$list_item.'
        </div>
        '.$open_block.'
    </div>
    ';
}
