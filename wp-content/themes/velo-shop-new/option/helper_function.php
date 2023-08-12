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
    $colors = wc_get_product_terms($product_id, "pa_cvet" );

    $dop_colors = wc_get_product_terms($product_id, 'pa_cvet_dop');
    $dop_colors = $dop_colors ? $dop_colors : wc_get_product_terms($product_id, 'pa_dop-cvet');

    if (!$colors) return '';

    $color_name = mb_strtolower($colors[0]->name);
    $color_dop_name = $dop_colors ? mb_strtolower($dop_colors[0]->name) : '';

    if ($color_dop_name) {
        $link = '<a href="'.get_permalink($product_id).'">
                      <span class="info__color_first" style="background-color: '.getHexColor($color_name).';"></span>
                      <span class="info__color_two" style="background-color: '.getHexColor($color_dop_name).';"></span>
                 </a>';
    } else {
        $link = '<a href="'.get_permalink($product_id).'">
                      <span class="info__color_first" style="background-color: '.getHexColor($color_name).';"></span>
                 </a>';
    }

    return $link;
}

function get_image_link($product){
    if ($product->get_image_id()) {
        $default_image_link = wp_get_attachment_url($product->get_image_id());
    } else {
        $default_image_link = get_asset_path("images/app", "no-image.svg");
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

function getAttributesListVisible()
{
    return array(
        'pa_proizvoditel',
        'pa_diametr-kolesaoboda',
        'pa_kolichestvo-skorostey',
        'pa_razmer-ramy',
        'pa_material-ramy',
        'pa_tormoza',
    );
}

function getHexColor($color)
{
    $colors_array = array(
        'алый' => '#ff2400',
        'аметистовый' => '#9966cc',
        'баклажановый' => '#990066',
        'бежевый' => '#f5f5dc',
        'белый' => '#ffffff',
        'белo' => '#ffffff',
        'бензин' => '#7442C8',
        'бирюзовый' => '#30d5c8',
        'бронзовый' => '#cd7f32',
        'вишневый' => '#911e42',
        'голубой' => '#42aaff',
        'желтый' => '#ffff00',
        'зеленый' => '#008000',
        'зеркальный' => '#e6e6e6',
        'золотистый' => '#fafad2',
        'золотой' => '#ffd700',
        'изумрудный' => '#50c878',
        'коралловый' => '#ff7f50',
        'коричневый' => '#964b00',
        'красный' => '#ff0000',
        'лазурный' => '#007fff',
        'лайм' => '#00ff00',
        'лиловый' => '#db7093',
        'лимонный' => '#fde910',
        'малиновый' => '#dc143c',
        'морская волна' => '#00ffff',
        'мятный' => '#3eb489',
        'оливковый' => '#808000',
        'оранжевый' => '#ffa500',
        'персиковый' => '#ffe5b4',
        'пурпурный' => '#800080',
        'розовый' => '#ffc0cb',
        'салатовый' => '#99ff99',
        'серебристый' => '#c0c0c0',
        'серый' => '#808080',
        'синий' => '#0000ff',
        'сиреневый' => '#c8a2c8',
        'сливовый' => '#660066',
        'слоновая-кость' => '#fffff0',
        'темно-оливковый' => '#556832',
        'темно-розовый' => '#e75480',
        'терракотовыйй' => '#904d30',
        'фиолетовый' => '#8b00ff',
        'фисташковый' => '#bef574',
        'хакки' => '#806b2a',
        'хром' => '#dbe2e9',
        'черный' => '#000000',
    );

    $color = mb_strtolower($color);

    if (array_key_exists($color, $colors_array)) {
        return $colors_array[$color];
    } else {
        global $wpdb;
        $color = $wpdb->get_var('SELECT `hex` FROM ' . $wpdb->prefix . 'colors WHERE `color` = "' . $color . '"');
        return $color;
    }
}

function getMainCategoriesList() {
    $get_categories_product = get_terms("product_cat", [
        "hide_empty" => 0,
        "hierarchical" => 1,
        "parent" => 0
    ]);

    $list = '';

    foreach ($get_categories_product as $categories_item) {
        $link = esc_url(get_term_link($categories_item->term_id));
        $name = esc_html($categories_item->name);

        $list .= '<a href="'.$link.'">'.$name.'</a>';
    }

    return $list;
}

function getMainCategories($parent = 0) {
    $get_categories_product = get_terms("product_cat", [
        "hide_empty" => 0,
        "hierarchical" => 1,
        "parent" => $parent,
    ]);

    $categories = [];

    foreach ($get_categories_product as $category) {
        $child = get_term_children($category->term_id, "product_cat");

        $categories[$category->term_id]['name'] = esc_html($category->name);
        $categories[$category->term_id]['link'] = esc_url(get_term_link($category->term_id));
        $categories[$category->term_id]['child'] = (bool)count($child);

        if (count($child)) {
            $categories[$category->term_id]['child_list'] = getMainCategories($category->term_id);
        }
    }

    return $categories;
}

function getChildrenMenu($id) {
    $get_categories_product = get_terms("product_cat", [
        "hide_empty" => 0,
        "hierarchical" => 1,
        "parent" => $id
    ]);

    $categories = [];

    foreach ($get_categories_product as $category) {
        $categories[] = [
            'name'          => esc_html($category->name),
            'link'          => esc_url(get_term_link($category->term_id)),
            'thumbnail'     => getThumbnail($category->term_id),
        ];
    }

    return $categories;
}

function getThumbnail($id) {
    $thumbnail_id = get_term_meta($id, 'thumbnail_id', true);
    return esc_url(wp_get_attachment_url( $thumbnail_id ));
}

function getNewProduct() {
    return wc_get_products(array(
        'post_type'     => 'product',
        'post_status'   => 'publish',
        'stock_status'  => 'instock',
        'orderby'       => 'post_date',
        'order'         => 'desc',
        'posts_per_page'      => 20,
    ));
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

function string_crop($string, $len) {
    if (strlen($string) > $len)
    {
        $string = wordwrap($string, $len);
        $string = substr($string, 0, strpos($string, "\n"));
    }

    return $string;
}