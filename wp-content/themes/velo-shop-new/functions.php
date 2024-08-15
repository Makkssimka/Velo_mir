<?php

add_theme_support('title-tag');
add_post_type_support( 'page', 'excerpt' );

//Session function
require_once "option/session_function.php";

//Ajax function
require_once "option/ajax_function.php";

//Helper function
require_once "option/helper_function.php";
require_once "blocks/widget/widget_loader.php";

//Email format wp_mail
function set_wp_mail_format(){
    return "text/html";
}
add_filter( 'wp_mail_content_type','set_wp_mail_format' );

//Global js variables
function js_variables(){
    $variables = array (
        'ajax_url' => admin_url('admin-ajax.php'),
        'is_mobile' => wp_is_mobile()
    );
    echo(
        '<script type="text/javascript">window.wp_data = '.
            json_encode($variables).
        ';</script>'
    );
}

add_action('wp_head','js_variables');

//Adding CSS & JS
function velo_shop_custom(){
    wp_enqueue_style('slider', get_template_directory_uri()."/assets/styles/libraries/ion.rangeSlider.min.css", false, '1.0.0');
    wp_enqueue_style('carousel', get_template_directory_uri()."/assets/styles/libraries/owl.carousel.min.css", false, '1.0.0');
    wp_enqueue_style('carousel_theme', get_template_directory_uri()."/assets/styles/libraries/owl.theme.default.min.css", false, '1.0.0');
    wp_enqueue_style('app', get_template_directory_uri()."/assets/styles/app.css", false, '1.0.1');

    wp_enqueue_script('box', get_template_directory_uri()."/assets/scripts/libraries/fslightbox.js", array(), 1.0, true);
    wp_enqueue_script('slider', get_template_directory_uri()."/assets/scripts/libraries/ion.rangeSlider.min.js", array(), 1.0, true);
    wp_enqueue_script('mask', get_template_directory_uri()."/assets/scripts/libraries/jquery.mask.min.js", array(), 1.0, true);
    wp_enqueue_script('carousel', get_template_directory_uri()."/assets/scripts/libraries/owl.carousel.min.js", array(), 1.0, true);
    wp_enqueue_script('app', get_template_directory_uri()."/assets/scripts/app.js", array(), 1.0, true);
}

add_action('wp_enqueue_scripts', 'velo_shop_custom');

// Script admin panel
function admin_custom($hook){
    wp_enqueue_script('admin_my_script', get_template_directory_uri()."/assets/scripts/admin_script.js", array(), 1.0, true);

    wp_enqueue_style('admin_my_style', get_template_directory_uri()."/assets/styles/admin.css", false, '1.0.0');
    wp_enqueue_style('icon', "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css", false, '1.0.0');
}

add_action('admin_enqueue_scripts', 'admin_custom');

// Creating custom Menu
function velo_shop_custom_menu(){
    register_nav_menus([
        'location_menu' => 'Меню контактов',
        'main_menu' => "Основное меню",
        'top_menu' => "Верхнее меню",
        'bottom_main_menu' => "Нижнее главное меню",
        'bottom_menu' => "Нижнее меню"
    ]);
}

add_action( 'init', 'velo_shop_custom_menu');

// Add custom logo template
function custom_logo_setup() {
    $defaults = array(
        'flex-height' => true,
        'flex-width'  => true
    );
    add_theme_support( 'custom-logo', $defaults );
}

add_action( 'after_setup_theme', 'custom_logo_setup' );

// WooCommerce
 if(class_exists('WooCommerce')) {

    // WooCommerce support
    function woocommerce_add_support(){
        add_theme_support('woocommerce');
    }
    add_action('after_setup_theme', 'woocommerce_add_support');

    // Remove WooCommerce style
    add_filter('woocommerce_enqueue_style', '__return_false');

    // Remove WooCommerce title
    add_filter('woocommerce_show_page_title', '__return_false');


    // Remove WooCommerce breadcrumbs
    add_action( 'init', 'my_remove_breadcrumbs' );
    function my_remove_breadcrumbs() {
        remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
    }

 }

// Global variables
function add_global_variables(){

    // Глобальная переменная с id продуктов в корзине
    global $cart_ids;
    $cart_ids = [];

    if (WC()->cart) {
        foreach (WC()->cart->get_cart() as $item) {
            $cart_ids[] = $item['product_id'];
        }
    }

    // Глобальная переменная с id избранных продуктов
    global $favorite_ids;
    $favorite_ids = [];

    if(isset($_SESSION['favorites'])) {
        $favorite_ids =  json_decode($_SESSION['favorites']);
    }

    // Глобальная переменная с id продуктами для сравнения
    global $compare_ids;
    $compare_ids = [];

    if(isset($_SESSION['compare'])) {
        $compare_ids =  json_decode($_SESSION['compare']);
    }
}
add_action('wp_loaded', 'add_global_variables');

 // Custom menu template
add_filter('wp_nav_menu_objects', 'custom_menu', 10, 2);
 function custom_menu($items){
     foreach($items as $item){
         $icon = $item->post_content?'<span class="'.$item->post_content.'"></span>':'';
         $item->title = "$item->title $icon";
     }
     return $items;
 }

 //Settings site page
require_once "option/admin_menu.php";

 //Woocommerce files
require_once "option/wc_new_fields.php";

// Maintenance mode activation
function wp_maintenance_mode(){
    if (get_option('maintenance_mode_active') && (!current_user_can('edit_themes') || !is_user_logged_in())){
        load_template(get_template_directory().'/maintenance.php');
        die();
    }
}

add_action('get_header', 'wp_maintenance_mode');

add_filter( 'pre_wp_unique_post_slug',
    function( $override_slug, $slug, $post_id, $post_status, $post_type, $post_parent ) {
        return IM_Helper::translit($slug);
    }, 10, 6
);


add_action( 'woocommerce_before_product_object_save', 'before_product_save', 10, 2 );
function before_product_save( $that, $data_store ){
    $sku = $that->get_sku();
    $that->set_slug('ar-'.$sku);
}

// Функция исключения из списка похожих товаров, товаров которых нет в наличие
add_filter( 'woocommerce_related_products', 'mysite_filter_related_products', 10, 1 );
function mysite_filter_related_products( $related_product_ids ) {

    foreach( $related_product_ids as $key => $value ) {
        $relatedProduct = wc_get_product( $value );
        if( ! $relatedProduct->is_in_stock() ) {
            unset( $related_product_ids["$key"] );
        }
    }

    return $related_product_ids;
}

// Функция фильтрации товара по цене
add_filter( 'woocommerce_product_data_store_cpt_get_products_query', 'handle_price_range_query_var', 10, 2 );

function handle_price_range_query_var( $query, $query_vars ) {
    if ( ! empty( $query_vars['price_range'] ) ) {
        $price_range = explode( '|', esc_attr($query_vars['price_range']) );

        if ( is_array($price_range) && count($price_range) == 2 ) {
            $query['meta_query']['relation'] = 'AND';

            $query['meta_query'][] = array(
                'key'     => '_price',
                'value'   => reset($price_range), // From price value
                'compare' => '>=',
                'type'    => 'NUMERIC'
            );

            $query['meta_query'][] = array(
                'key'     => '_price',
                'value'   => end($price_range), // To price value
                'compare' => '<=',
                'type'    => 'NUMERIC'
            );

            $query['orderby'] = 'meta_value_num'; // sort by price
            $query['order'] = 'ASC'; // In ascending order
        }
    }
    return $query;
}


add_action('template_redirect', 'redirect_to_404_page');

function redirect_to_404_page() {
    if(is_product()) {
        $product = wc_get_product();
        if(!$product->get_stock_quantity()) {
            wp_safe_redirect('/404');
            exit();
        };
    }
}

// Добавляем меню цветов
add_action('admin_menu', 'register_colors_page');

function register_colors_page() {
    add_menu_page('Каталог цветов', 'Каталог цветов', 'manage_options', 'colors-catalog', 'colorRender', 'dashicons-color-picker');
}

function colorRender() {
    global $wpdb;
    $table = $wpdb->prefix . 'colors';

    if (isset($_POST['hex']) && isset($_POST['color'])) {
        $wpdb->query('INSERT INTO ' . $table . ' (`color`, `hex`) VALUES("' . $_POST['color'] . '", "' . $_POST['hex'] . '")');
    }

    if (isset($_POST['method']) && $_POST['method'] === 'delete') {
        $wpdb->query('DELETE FROM ' . $table . ' WHERE `id` = ' . $_POST['id']);
    }

    $colors = $wpdb->get_results('SELECT * FROM ' . $table . ' ORDER BY `color` ASC');

    ob_start();
    include_once(get_template_directory() . '/templates/admin/colors_catalog.php');
    $template = ob_get_contents();
    ob_end_clean();

    echo $template;
}