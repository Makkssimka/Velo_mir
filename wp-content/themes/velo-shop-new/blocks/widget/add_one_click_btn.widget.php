<?php

function add_one_click_btn($product) {
    $btn = '<a class="product-one-click" data-id="'.$product->get_id().'" href="#">купить в один клик</a>';
    return $btn;
}

?>