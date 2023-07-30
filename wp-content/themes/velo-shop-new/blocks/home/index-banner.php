<?php
$addresses = explode('?', get_option('address'));
?>

<div class="container">
    <div class="index-banner">
        <div class="index-banner__bg">
            <img src="<?= get_asset_path('images/app', 'index-bg.svg') ?>" alt="index background">
        </div>

        <div class="index-banner__title">
            <h1>
                <span>Самый большой</span> выбор велосипедов и запчастей в Волгограде!
            </h1>

            <a href="/product-category/velosipedy" data-target="mobile_menu" class="button button_orange button_upper">
                Каталог товаров
            </a>
        </div>

        <div class="index-banner__address">
            <h3>Приходите в магазин!</h3>

            <?php foreach ($addresses as $address) : ?>
                <a href="/contact" class="button button_blue"><?= $address ?></a>
            <?php endforeach ?>
        </div>
    </div>
</div>