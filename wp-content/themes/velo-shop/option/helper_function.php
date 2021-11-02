<?php

function time_to_array($time) {
    $result_array = array();
    $first_array = explode('?', $time);
    foreach ($first_array as $item){
        $item_array = explode('/', $item);
        $result_array[] = [
            'label' => $item_array[0],
            'time'  => $item_array[1]
        ];
    }
    return $result_array;
}

function get_asset_path($folder, $file){
    return get_template_directory_uri()."/assets/$folder/$file";
}

function get_current_url(){
    $url = $_SERVER['REQUEST_URI'];
    $url = explode('?', $url);
    return $url[0];
}

function get_current_request($request){
    $url = $_SERVER['REQUEST_URI'];
    $url = explode('?', $url);
    $url = $url[0];

    return $url."?".http_build_query($request);
}

function get_full_url() {
    return $_SERVER['REQUEST_URI'];
}

function get_url_data(){
    $query = $_SERVER['QUERY_STRING'];
    $query_array = explode('&', $query);
    $result_array = array();
    foreach ($query_array as $index => $value_query) {
        if ($index == 0) continue;
        $value_query_array = explode('=', $value_query);
        $result_array[$value_query_array[0]] = explode(',', $value_query_array[1]);
    }
    return $result_array;
}

function price_form($price){
    return number_format($price, 0, "", " ");
}

function get_max_and_min_price($category){
    global $wpdb;

    $price = $wpdb->get_row("
        SELECT MIN(min_price) as 'min_price', MAX(min_price) as 'max_price' 
        FROM {$wpdb->wc_product_meta_lookup}
        LEFT JOIN {$wpdb->term_relationships} ON {$wpdb->wc_product_meta_lookup}.product_id = {$wpdb->term_relationships}.object_id
        WHERE min_price > 0 AND 
        {$wpdb->wc_product_meta_lookup}.stock_quantity > 0 AND
        {$wpdb->term_relationships}.term_taxonomy_id = {$category->term_taxonomy_id}");

    return array(
        'min' => (int) $price->min_price,
        'max' => (int) $price->max_price,
    );
}

function terms_sort($array, $sort_by = "name")
{
    if ($sort_by == "name") {
        usort($array, function ($a, $b) {
            return $a->name > $b->name ? 1 : -1;
        });
    } else {
        usort($array, function ($a, $b) {
            return $a->count < $b->count ? 1 : -1;
        });
    }



    return $array;
}

function send_telegram($order_number){
    $token = '1655959307:AAGzDwGYkWVkBGs9-2J_fAr6Q__-IrrUbGM';
    $ids_user = explode(',', get_option('telegram_ids'));
    $message = "<b>Новый заказ:</b> №".$order_number;
    $mode = "html";

    foreach ($ids_user as $id_user) {
        $id_user = trim($id_user);
        file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$id_user&text=$message&parse_mode=$mode");
    }
}

function get_color_link($product_id){
    $colors = wc_get_product_terms($product_id, "pa_color" );

    if (!$colors) return '';

    if (count($colors) == 2) {
        $color_name = mb_strtolower($colors[0]->name."-".$colors[1]->name);
        return '<a class="title-show title-margin-30" data-title="'.$color_name.'" href="'.get_permalink($product_id).'">
                   <span style="background-color:'.$colors[0]->description.';"></span>
                   <span class="product-two-color" style="background-color:'.$colors[1]->description.';"></span>
                </a>';
    } else {
        $color_name = mb_strtolower($colors[0]->name);
        return '<a class="title-show title-margin-30" data-title="'.$color_name.'" href="'.get_permalink($product_id).'">
                   <span style="background-color:'.$colors[0]->description.';"></span>
                </a>';
    }
}

function get_image_link($product){
    if ($product->get_image_id()) {
        $default_image_link = wp_get_attachment_url($product->get_image_id());
    } else {
        $default_image_link = get_asset_path("images", "noimage.jpg");
    }

    return $default_image_link;
}

function num_word($value, $show = true)
{
    $words = ['товар', 'товара', 'товаров'];
    $num = $value % 100;
    if ($num > 19) {
        $num = $num % 10;
    }

    $out = ($show) ?  $value . ' ' : '';
    switch ($num) {
        case 1:  $out .= $words[0]; break;
        case 2:
        case 3:
        case 4:  $out .= $words[1]; break;
        default: $out .= $words[2]; break;
    }

    return $out;
}

function get_name_to_single($name)
{
    $words = explode(' ', $name);
    $result = array();

    foreach ($words as $word) {
        $word = preg_replace('/ы$/i', '', $word);
        $word = preg_replace('/е$/i', 'й', $word);
        $result[] = $word;
    }

    return implode(' ', $result);
}

function getAttributesByProductCategory($category_slug)
{
    $query_args = array(
        'status'    => 'publish',
        'limit'     => -1,
        'category'  => array( $category_slug ),
    );

    $data = array();
    foreach( wc_get_products($query_args) as $product ){
        foreach( $product->get_attributes() as $taxonomy => $attribute ){
            foreach ( $attribute->get_terms() as $term ){
                $data[$taxonomy][$term->term_id] = $term;
            }
        }
    }

    return $data;
}


function getHexColor($color)
{
    $colors_array = array(
        'бежевый' => '#f5f5dc',
        'белый' => '#ffffff',
        'бирюзовый' => '#30d5c8',
        'голубой' => '#42aaff',
        'желтый' => '#ffff00',
        'зеленый' => '#008000',
        'красный' => '#ff0000',
        'лайм' => '#00ff00',
        'малиновый' => '#dc143c',
        'морская волна' => '#00ffff',
        'мятный' => '#3eb489',
        'оранжевый' => '#ffa500',
        'розовый' => '#ffc0cb',
        'серибристый' => '#c0c0c0',
        'серый' => '#808080',
        'синий' => '#0000ff',
        'фиолетовый' => '#8b00ff',
        'черный' => '#000000',
    );

    $color = mb_strtolower($color);
    return $colors_array[$color];
}

function getMainCategoriesList() {
    $get_categories_product = get_terms("product_cat", [
        "hide_empty" => 0,
        "hierarchical" => 1,
        "parent" => 0
    ]);

    $list = '<ul>';

    foreach ($get_categories_product as $categories_item) {
        $link = esc_url(get_term_link($categories_item->term_id));
        $name = esc_html($categories_item->name);

        $list .= '<li>';
        $list .= '<a href="'.$link.'">'.$name.'</a>';
        $list .= '</li>';
    }

    $list .= '</ul>';

    return $list;
}

function getCategoriesList($parent_id = 0, $step = 0) {
    $categories_list = "";
    $step++;

    $get_categories_product = get_terms("product_cat", [
        "hide_empty" => 0, // Скрывать пустые. 1 - да, 0 - нет.
        "hierarchical" => 1,
        "parent" => $parent_id
    ]);

    if(count($get_categories_product) > 0) {

        if($parent_id == 0) {
            $categories_list .= '<ul class="main_categories_list">';
        } else {
            $categories_list .= '<ul class="sub_categories_list">';
        }

        foreach($get_categories_product as $categories_item) {
            $link = esc_url(get_term_link($categories_item->term_id));
            $name = esc_html($categories_item->name);

            $thumbnail_id = get_term_meta( $categories_item->term_id, 'thumbnail_id', true );
            $image_url = wp_get_attachment_url( $thumbnail_id );
            $image = $thumbnail_id && $step != 3 ? "<img src='$image_url'>" : "";

            $children_category = getCategoriesList($categories_item->term_id, $step);

            if ($children_category && !$categories_item->parent) {
                $categories_list .= "<li><a href='$link'>$image <span>$name</span> <i class='las la-angle-right'></i></a>";
                $categories_list .= $children_category;
            } else {
                $categories_list .= "<li><a href='$link'>$image $name</a>";
                $categories_list .= $children_category;
            }

            $categories_list .= '</li>';

        }

        $categories_list .= '</ul>';

    }

    return $categories_list;
}

function getCategoriesMobileList($parent_id = 0, $step = 0) {
    $categories_list = "";
    $step++;

    $get_categories_product = get_terms("product_cat", [
        "hide_empty" => 0, // Скрывать пустые. 1 - да, 0 - нет.
        "hierarchical" => 1,
        "parent" => $parent_id
    ]);

    if(count($get_categories_product) > 0) {
        $categories_list .= '<ul>';

        if ($step != 1) {
            $categories_list .= '<li class="mobile-menu-back"><i class="las la-arrow-left"></i><span>назад</span></li>';
        } else {
            $categories_list .= '<li class="mobile-menu-close"><i class="las la-times"></i><span>закрыть</span></li>';
        }

        foreach($get_categories_product as $categories_item) {
            $link = esc_url(get_term_link($categories_item->term_id));
            $name = esc_html($categories_item->name);

            $thumbnail_id = get_term_meta( $categories_item->term_id, 'thumbnail_id', true );
            $image_url = wp_get_attachment_url( $thumbnail_id );
            $image = $thumbnail_id && $step == 1 ? "<img src='$image_url'>" : "";

            $children_category = getCategoriesMobileList($categories_item->term_id, $step);

            if ($children_category) {
                $categories_list .= "<li><a href='#'>$image <span>$name</span> <i class='las la-angle-right'></i></a>";
                $categories_list .= $children_category;
            } else {
                $categories_list .= "<li><a href='$link'>$image $name</a>";
            }

            $categories_list .= '</li>';
        }

        if ($step == 1) {
            $categories_list .= getMenuByPos('top_menu');
        }
        $categories_list .= '</ul>';

    }
    return $categories_list;
}

function getMenuByPos($pos) {
    $result = wp_nav_menu([
        'theme_location' => $pos,
        'container' => false,
        'items_wrap' => '%3$s',
        'echo' => false
    ]);

    return $result;
}

function mb_lcfirst($string, $charset = 'UTF-8') {
    return mb_strtolower(mb_substr($string, 0, 1, $charset), $charset) .
        mb_substr($string, 1, mb_strlen($string, $charset), $charset);
}