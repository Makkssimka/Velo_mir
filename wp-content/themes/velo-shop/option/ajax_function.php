<?php

//Добавляем в избранное
add_action('wp_ajax_add_favorites', 'add_favorites_callback');
add_action('wp_ajax_nopriv_add_favorites', 'add_favorites_callback');

function add_favorites_callback(){
    $status_list = array(
        'ADDED_IN_FAVORITES' => 1,
        'REMOVED_FROM_FAVORITES' => 0
    );
    $id = $_POST['id'];
    $session = isset($_SESSION['favorites'])?json_decode($_SESSION['favorites']):array();

    if (in_array($id, $session)) {
        $index = array_search($id, $session);
        array_splice($session, $index, 1);
        $status = $status_list['REMOVED_FROM_FAVORITES'];
    } else {
        array_push($session, $id);
        $status = $status_list['ADDED_IN_FAVORITES'];
    }

    $_SESSION['favorites'] = json_encode($session);
    echo json_encode(array(
        'status' => $status,
        'counter' => count($session)
    ));

    wp_die();
}

//Дабавляем в сравнение
add_action('wp_ajax_add_compare', 'add_compare_callback');
add_action('wp_ajax_nopriv_add_compare', 'add_compare_callback');

function add_compare_callback(){
    $status_list = array(
        'ADDED_IN_COMPARE' => 1,
        'REMOVED_FROM_COMPARE' => 0
    );
    $id = $_POST['id'];
    $session = isset($_SESSION['compare'])?json_decode($_SESSION['compare']):array();

    if (in_array($id, $session)) {
        $index = array_search($id, $session);
        array_splice($session, $index, 1);
        $status = $status_list['REMOVED_FROM_COMPARE'];
    } else {
        array_push($session, $id);
        $status = $status_list['ADDED_IN_COMPARE'];
    }

    $_SESSION['compare'] = json_encode($session);
    echo json_encode(array(
        'status' => $status,
        'counter' => count($session)
    ));

    wp_die();
}

//Получаем количество велосипедов для главной страницы
add_action('wp_ajax_get_products_count', 'get_products_count_callback');
add_action('wp_ajax_nopriv_get_products_count', 'get_products_count_callback');

function get_products_count_callback(){
    $query = $_POST['query'];

    //начало создания запроса
    $result = '';
    $args = array(
        'paginate' => false,
        'limit' => -1,
        'tax_query' => array(
            'relation' => 'AND'
        )
    );

    //перебираем все отправленные данные
    foreach($query as $item){
        //если не цена добавляем критерии, если цена добавляем фильтер по цене
        if ($item['type'] != 'price') {
            $filter = array(
                'taxonomy' => "pa_".$item['type'],
                'field' => 'slug',
                'terms' => $item['value']
            );
            array_push($args['tax_query'], $filter);
        } else {
            $args['price_rage'] = array(
                $item['value']['from'],
                $item['value']['to']
            );
        }
    }

    //получаем и отправляем количество продуктов
    echo(count(wc_get_products($args)));
    wp_die();
}

//Добавляем в корзину
add_action('wp_ajax_add_to_cart', 'add_to_cart_callback');
add_action('wp_ajax_nopriv_add_to_cart', 'add_to_cart_callback');

function add_to_cart_callback(){
    $id = $_POST['id'];

    $cart = WC()->cart;
    $cart->add_to_cart($id);

    echo $cart->get_cart_contents_count();
    wp_die();
}

//Увеличиваем корзину
add_action('wp_ajax_up_down_cart', 'up_down_cart_callback');
add_action('wp_ajax_nopriv_up_down_cart', 'up_down_cart_callback');

function up_down_cart_callback(){
    $key = $_POST['key'];
    $method = $_POST['method'];
    $cart = WC()->cart;
    $item = $cart->get_cart_item($key);
    $quantity = $item['quantity'];

    if ($method == 'up') {
        $cart->set_quantity($key, $quantity+1);
    } else {
        $cart->set_quantity($key, $quantity-1);
    }

    $new_item = $cart->get_cart_item($key);

    echo json_encode(array(
        'count' => $cart->get_cart_contents_count(),
        'subtotal' => $cart->get_cart_subtotal(),
        'sale' => wc_price($cart->get_cart_discount_total()),
        'total' => $cart->get_cart_total(),
        'item_subtotal' => wc_price($new_item['line_subtotal'])
    ));
    wp_die();
}

//Удаляем из корзины
add_action('wp_ajax_cart_item_remove', 'cart_item_remove_callback');
add_action('wp_ajax_nopriv_cart_item_remove', 'cart_item_remove_callback');

function cart_item_remove_callback(){
    $cart = WC()->cart;
    $key = $_POST['key'];

    $cart->remove_cart_item($key);

    $result = array(
        'cart' => array(
            'count' => $cart->get_cart_contents_count(),
            'subtotal' => $cart->get_cart_subtotal(),
            'sale' => wc_price($cart->get_cart_discount_total()),
            'total' => $cart->get_cart_total(),
        )
    );

    echo json_encode($result);
    wp_die();
}


//Применение купона
add_action('wp_ajax_add_coupon', 'add_coupon_callback');
add_action('wp_ajax_nopriv_add_coupon', 'add_coupon_callback');

function add_coupon_callback(){
    $coupon = $_POST['coupon'];
    $coupon_obj = new WC_Coupon($coupon);
    $cart = WC()->cart;
    $result = array();

    //Удаляем купон если вводится другой
    $coupon_old = '';
    foreach ($cart->get_coupons() as $coup) {
        $coupon_old = $coup->get_code();
    };

    if ($coupon_old != $coupon) {
        $cart->remove_coupon($coupon_old);
    }

    if ($cart->has_discount($coupon)) {
        $result['error'] = array(
            'code' => 1,
            'message' => 'Вы уже используете данный купон'
        );
    } elseif ($coupon_obj->is_valid()) {
        $cart->add_discount($coupon);
        $result = array(
            'error' => array(
                'code' => 0
            ),
            'cart' => array(
                'coupon' => $coupon,
                'sale' => wc_price($cart->get_cart_discount_total()),
                'total' => $cart->get_cart_total()
            )
        );
    } else {
        $result = array(
            'error' => array(
                'code' => 1,
                'message' => 'Такого купона не существует'
            )
        );
    }

    echo json_encode($result);
    wp_die();
}

//Удаление купона
add_action('wp_ajax_remove_coupon', 'remove_coupon_callback');
add_action('wp_ajax_nopriv_remove_coupon', 'remove_coupon_callback');

function remove_coupon_callback(){
    $cart = WC()->cart;
    $cart->remove_coupons();

    $result = array(
        'cart' => array(
            'sale' => wc_price(0),
            'total' => $cart->get_cart_subtotal()
        )
    );

    echo json_encode($result);
    wp_die();
}

//Оформление заказа
add_action('wp_ajax_send_order', 'send_order_callback');
add_action('wp_ajax_nopriv_send_order', 'send_order_callback');

function send_order_callback(){

    // Очистка ввода
    $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $comment = filter_input(INPUT_POST, 'comment', FILTER_SANITIZE_STRING);

    // Проверка ввода
    $errors = array();
    if (!trim($name)) {
       array_push($errors, array(
           'field' => "имя",
           'error' => 1
       ));
    }

    if (!trim($email)) {
        array_push($errors, array(
            'field' => "адрес электронной почты",
            'error' => 1
        ));
    }

    if (!trim($telephone)) {
        array_push($errors, array(
            'field' => "номер телефона",
            'error' => 1
        ));
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, array(
            'field' => "адрес электронной почты",
            'error' => 2
        ));
    }

    // Если есть ошибки, возвращаем код ошибки
    if (count($errors)) {
        echo json_encode(array(
            'type' => 'error',
            'errors' => $errors
        ));
        wp_die();
    }

    $new_order = wc_create_order();
    $cart = WC()->cart;
    $new_order->set_billing_first_name($name);
    $new_order->set_billing_last_name($last_name);
    $new_order->set_billing_email($email);
    $new_order->set_billing_phone($telephone);
    $new_order->set_shipping_address_1($address);
    $new_order->set_customer_note($comment);

    foreach ($cart->get_cart() as $product) {
        $new_order->add_product(wc_get_product($product['product_id']), $product['quantity']);
    }

    foreach ($cart->get_coupons() as $coupon) {
        $new_order->apply_coupon($coupon->get_code());
    }

    $new_order->calculate_totals();
    $new_order->save();
    $cart->empty_cart();

    $email_new_order = WC()->mailer()->get_emails()['WC_Email_New_Order'];
    $email_new_order->trigger($new_order->get_id());

    // отправка в telegramm
    send_telegram($new_order->get_order_number());

    echo json_encode(array(
        'type' => 'success',
        'order_number' => $new_order->get_order_number()
    ));
    wp_die();
}




