<?php

defined( 'ABSPATH' ) || exit;

global $product;
$attachment_ids = $product->get_gallery_image_ids();

?>

<div class="product-gallery">
    <div class="product-gallery-slider">
        <ul id="product-carousel" class="owl-carousel owl-theme">
            <li>
                <a href="<?= get_image_link($product) ?>" data-fslightbox>
                    <div
                        style="background-image: url(<?= get_image_link($product) ?>);"
                        class="gallery-image">
                    </div>
                </a>
            </li>
            <?php foreach ($attachment_ids as $attachment_id) : ?>
                <?php $image_link = wp_get_attachment_url( $attachment_id ); ?>
                <li>
                    <a href="<?= $image_link ?>" data-fslightbox>
                        <div
                            style="background-image: url(<?= $image_link ?>);"
                            class="gallery-image">
                        </div>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <div class="product-gallery-thumbnail">
        <ul>
            <li class="active" data-numb="0">
                <a href="#">
                    <img src="<?= get_image_link($product) ?>" alt="">
                </a>
            </li>
            <?php foreach ($attachment_ids as $key => $attachment_id) : ?>
                <?php $image_link = wp_get_attachment_url( $attachment_id ); ?>
                <li data-numb="<?= $key+1 ?>">
                    <a href="#">
                        <img src="<?= $image_link ?>" alt="">
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>