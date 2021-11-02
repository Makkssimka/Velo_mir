<?php

// Новые продукты
$new_products = wc_get_products(array(
    'post_type'     => 'product',
    'post_status'   => 'publish',
    'stock_status'  => 'instock',
    'orderby'       => 'post_date',
    'order'         => 'desc',
    'posts_per_page'      => 20,
));

// Популярные продукты, зависят от покупок
$popular_products = wc_get_products(array(
    'post_type'     => 'product',
    'post_status'   => 'publish',
    'stock_status'  => 'instock',
    'orderby'       => 'total_sales',
    'order'         => 'desc',
    'posts_per_page'      => 20,
));

?>

<div class="home-block">
    <div class="container">
        <div class="tabs-product">
            <a href="#popular" class="tabs-product-active">
                <h2>Популярные <span>товары</span></h2>
            </a>
            <a href="#new">
                <h2>Новинки <span>на сайте</span></h2>
            </a>
        </div>
        <div id="popular">
            <p class="home-block-subheader">Лучшие предложения на сайте. Ознакомьтесь с популярными товарами пользующихся наибольшим спросом среди наших покупателей.</p>
            <div class="home-list-product">
                <?php foreach ($popular_products as $key => $bike): ?>
                    <?php bike_widget($bike, false) ?>
                    <?php if ($key == 2 || $key == 12) : ?>
                        <?php catalog_banner_widget($key) ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <div id="new">
            <p class="home-block-subheader">Новинки на сайте. Ознакомьтесь с новыми товарами, возможно у нас появилось то, что Вы не могли найти прошлое посещение.</p>
            <div class="home-list-product">
                <?php foreach ($new_products as $key => $bike): ?>
                    <?php bike_widget($bike, false) ?>
                    <?php if ($key == 2 || $key == 12) : ?>
                        <?php catalog_banner_widget($key) ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>