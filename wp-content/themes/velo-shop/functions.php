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
    wp_enqueue_style('fonts', "https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&family=Raleway:wght@500;600&display=swap", false, '1.0.0');
    wp_enqueue_style('icon', "https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css", false, '1.0.0');
    wp_enqueue_style('slider', "https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css", false, '1.0.0');
    wp_enqueue_style('velo', get_template_directory_uri()."/assets/styles/main.css", false, '1.0.0');


    wp_enqueue_script('carousel', get_template_directory_uri()."/assets/scripts/owl.carousel.min.js", array(), 1.0, true);
    wp_enqueue_script('lightbox', get_template_directory_uri()."/assets/scripts/fslightbox.js", array(), 1.0, true);
    wp_enqueue_script('masked', "https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js", array(), 1.0, true);
    wp_enqueue_script('slider', "https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js", array(), 1.0, true);

    wp_enqueue_script('velo', get_template_directory_uri()."/assets/scripts/script.js", array(), 1.0, true);
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