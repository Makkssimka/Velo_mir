<?php

function add_cart_btn($product, $class = 'btn-green') {
    $cart = WC()->cart;

    $name = $product->get_title();
    $id = $product->get_id();
    $carts_ids = array();

    foreach ($cart->get_cart_contents() as $product) {
        array_push($carts_ids, $product['product_id']);
    };

    if(in_array($id, $carts_ids)) {
        $btn = '<a class="btn '.$class.'" href="/cart">в корзине</a>';
    } else {
        $btn = '<a data-id="'.$id.'" data-name="'.$name.'" class="btn '.$class.' add-cart" href="/cart">в корзину</a>';
    }

    return $btn;
}