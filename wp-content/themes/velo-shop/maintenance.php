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
            <span>Технические</span> работы на сайте
        </div>
        <div class="not-found-text">
            На нашем сайте проходят технические работы. В ближайшее время сайт станет доступен!
        </div>
    </div>
</div>
</body>
</html>