<?php

function catalog_banner_widget($key) {
    if (!get_option('is_show_banner')) return '';
    $banner_ids = json_decode(get_option('banner_list'));
    if ($key == 12 && count($banner_ids) > 1) {
        $banner_image_url = wp_get_attachment_image_url($banner_ids[1], 'full');
    } else {
        $banner_image_url = wp_get_attachment_image_url($banner_ids[0], 'full');
    }

    echo '
        <div class="catalog-banner-item">
            <a href="#">
                <img src="'.$banner_image_url.'" alt="">
            </a>
        </div>
        ';
}