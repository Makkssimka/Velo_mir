<?php

function sub_categories_widget($sub_cat) {
    $thumbnail_id = get_term_meta( $sub_cat->term_id, 'thumbnail_id', true );
    $image_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : get_asset_path("images", "noimage_sqd.jpg");
    $image = "<img src='$image_url'>";

    echo '
        <a href="'. esc_url(get_term_link($sub_cat->term_id)) .'" class="sub_categories_item">
            '. $image .'
            <span>'. $sub_cat->name .'</span>
        </a>
    ';
}