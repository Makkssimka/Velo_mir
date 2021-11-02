<?php

function bike_widget($bike, $delete_btn = false) {

    // Проверяем есть ли товар в избранных
    $favorites_array = isset($_SESSION['favorites'])?json_decode($_SESSION['favorites']):array();
    $is_favorites = in_array($bike->get_id(), $favorites_array)?'added-item':'';

    // Проверяем есть ли товар в сравнении
    $compare_array = isset($_SESSION['compare'])?json_decode($_SESSION['compare']):array();
    $is_compare = in_array($bike->get_id(), $compare_array)?'added-item':'';

    // Выводить или нет кнопку удалить
    if($delete_btn){
        $btn = '<a href="#" data-id="'.$bike->get_id().'" class="btn btn-blue favorite-delete">Удалить</a>';
    } else {
        $btn = '<a href="'. get_permalink($bike->get_id()) .'#description" class="btn btn-blue">Подробнее</a>';
    }

    // Выводим результат
    echo '
        <div class="widget-bike-item">
            <div class="widget-bike-body">
                <a class="widget-bike-image-wrapper" href="'.get_permalink($bike->get_id()) .'" style="background-image: url('.get_image_link($bike).');"></a>
                <a href="'.get_permalink($bike->get_id()) .'" class="widget-bike-name">
                    <span>'.$bike->get_name().'</span>
                </a>
            </div>
            <div class="widget-bike-button">
                <div class="widget-bike-price">
                    <div class="widget-bike-price-num">'.wc_price($bike->get_price()).'</div>
                    <ul>
                        <li><a href="#" class="add-compare title-show '.$is_compare.'" data-title="в сравнение" data-id="'.$bike->get_id().'"><i class="las la-balance-scale-left"></i></a></li>
                        <li><a href="#" class="add-favorites title-show '.$is_favorites.'" data-title="в избранное" data-id="'.$bike->get_id().'"><i class="lar la-star"></i></a></li>
                    </ul>
                </div>
                '. add_cart_btn($bike).'
                '.$btn.'
            </div>
        </div>
    ';
}