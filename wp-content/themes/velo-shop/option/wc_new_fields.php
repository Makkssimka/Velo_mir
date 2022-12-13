<?php

add_action( 'woocommerce_product_options_advanced', 'product_options_custom_fields' );

function product_options_custom_fields() {
    ?>
    <div class="options_group hide_if_external hide_if_grouped">
        <?php woocommerce_wp_textarea_input( array(
                   'id'            => 'slider_text', // Идентификатор поля
                   'label'         => 'Подпись для слайдера', // Заголовок поля
                   'placeholder'   => 'Ввод текста', // Надпись внутри поля
                   'class'         => 'short', // Произвольный класс поля
                   'name'          => 'slider_text', // Имя поля
                   'rows'          => '5', //Высота поля в строках текста.
        )); ?>
    </div>
    <div class="options_group hide_if_external hide_if_grouped">
        <?php woocommerce_wp_text_input( array(
            'id'            => 'youtube_link', // Идентификатор поля
            'label'         => 'Ссылка на обзор ютуб', // Заголовок поля
            'placeholder'   => 'https://www.youtube.com/embed/jDBZ5VULL4Q', // Надпись внутри поля
            'class'         => 'short', // Произвольный класс поля
            'name'          => 'youtube_link', // Имя поля
        )); ?>
    </div>
    <div class="options_group hide_if_external hide_if_grouped">
        <?php woocommerce_wp_text_input( array(
            'id'            => '1c_id', // Идентификатор поля
            'label'         => '1с Ид', // Заголовок поля
            'placeholder'   => '7ad2ff2c-0343-11ec-80ea-0025222500a9', // Надпись внутри поля
            'class'         => 'short', // Произвольный класс поля
            'name'          => '1c_id', // Имя поля
        )); ?>
    </div>
  <div class="options_group hide_if_external hide_if_grouped">
      <?php woocommerce_wp_text_input( array(
          'id'            => 'storages', // Идентификатор поля
          'label'         => 'Склады', // Заголовок поля
          'placeholder'   => 'Названия складов', // Надпись внутри поля
          'class'         => 'short', // Произвольный класс поля
          'name'          => 'storages', // Имя поля
          'custom_attributes' => array('readonly' => 'readonly')
      )); ?>
  </div>
<?php }

add_action( 'woocommerce_process_product_meta', 'custom_fields_save', 10 );

function custom_fields_save( $post_id ) {
    $woocommerce_slider_text = $_POST['slider_text'];
    $woocommerce_youtube_link = $_POST['youtube_link'];
    $woocommerce_1c_id = $_POST['1c_id'];
    $woocommerce_storage = $_POST['storages'];

    if ( !empty($woocommerce_slider_text) ) {
        update_post_meta($post_id, 'slider_text', esc_attr($woocommerce_slider_text));
    }
    if ( !empty($woocommerce_youtube_link) ) {
        update_post_meta($post_id, 'youtube_link', esc_attr($woocommerce_youtube_link));
    }
    if ( !empty($woocommerce_1c_id) ) {
        update_post_meta($post_id, '1c_id', esc_attr($woocommerce_1c_id));
    }

    if ( !empty($woocommerce_storage) ) {
        update_post_meta($post_id, 'storages', esc_attr($woocommerce_storage));
    }
}