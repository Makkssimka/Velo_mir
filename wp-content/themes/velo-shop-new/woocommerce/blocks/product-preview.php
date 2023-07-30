<?php

global $product;
$attachment_ids = $product->get_gallery_image_ids();

$image_links[] = get_image_link($product);

foreach ($attachment_ids as $attachment_id) {
    $image_links[] = wp_get_attachment_url( $attachment_id );
}

?>


<div class="w-full">
    <div class="product__title">
        <?= $product->get_name() ?>
    </div>

    <div class="product__sub-title">
        <div class="product__slug">Артикул <?= $product->get_sku() ?></div>

        <div class="product__compare">
            <a href="#">
                <img src="<?= get_asset_path('images/icons', 'compare.svg') ?>" alt="product compare">
                <span class="desktop">Сравнение</span>
            </a>

            <a href="#">
                <img src="<?= get_asset_path('images/icons', 'heart.svg') ?>" alt="product heart">
                <span class="desktop">Избранное</span>
            </a>
        </div>
    </div>

    <div class="gallery mt-1">
        <ul class="gallery__slider owl-carousel">
            <?php foreach ($image_links as $image_link) : ?>
              <li>
                  <a
                      class="gallery__item"
                      style="background-image: url('<?= $image_link ?>');"
                      data-fslightbox="gallery"
                      href="<?= $image_link ?>">
                  </a>
              </li>
            <?php endforeach ?>
        </ul>
        <div class="gallery__counter">
            <span class="gallery__counter_step">1</span>
            /
            <span class="gallery__counter_all">1</span>
        </div>
    </div>

    <div class="preview desktop">
        <ul class="preview__list">
            <?php foreach ($image_links as $image_link) : ?>
                <li>
                    <a
                        href="#"
                        class="preview__item preview__item_active"
                        data-index="0"
                        style="background-image: url('<?= $image_link ?>');">
                    </a>
                </li>
            <?php endforeach ?>
        </ul>
    </div>
</div>