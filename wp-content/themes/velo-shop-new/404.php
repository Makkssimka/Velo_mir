<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" />
    <?php wp_head(); ?>
</head>
<body>
    <div id="app" class="not-found">
        <div class="not-found-wrapper">
            <img src="<?= get_asset_path('images', '404.svg') ?>" alt="">
            <div class="not-found-header">
                <span>404</span> not found
            </div>
            <div class="not-found-text">
                Страница которую вы хотели посетить не найдена! Вы можете перейти на главную страницу или в каталог товаров!
            </div>
            <div class="not-found-btn">
                <a class="btn btn-blue" href="/bikes-catalog">Каталог</a>
                <a class="btn btn-green" href="/">На главную</a>
            </div>
        </div>
    </div>
</body>
</html>