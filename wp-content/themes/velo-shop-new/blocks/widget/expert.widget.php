<?php

function expert_widget(){
    $name_expert = get_option('name_expert');

    echo '
    <div class="article-img-master">
        <img src="'.get_asset_path('images', 'expert.jpg').'" alt="">
        <div class="product-expert">
            <p>Эксперт "Веломир"</p>
            <p class="product-expert-name">'.$name_expert.'</p>
            <a href="#" class="btn btn-green open-modal">Получить консультацию</a>
        </div>
    </div>
    ';
}