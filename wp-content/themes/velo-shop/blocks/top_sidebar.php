<?php
$cart = WC()->cart;

$cart_count = $cart->get_cart_contents_count();

$telephone_array = explode(', ', get_option('telephone_num'));
$time_job_array = time_to_array(get_option('time_job'));

$favorites_array = isset($_SESSION['favorites'])?json_decode($_SESSION['favorites']):array();
$compare_array = isset($_SESSION['compare'])?json_decode($_SESSION['compare']):array();

?>
<div class="top-sidebar">
    <div class="container">
        <div class="logo-search-wrapper">
            <div class="logo-block">
                <a href="/"><img src="<?= get_asset_path('images', 'logo_new.svg') ?>" alt=""></a>
            </div>
            <div class="search-block">
                <div class="contact-top">
                    <ul>
                        <?php foreach ($telephone_array as $telephone) : ?>
                            <li><a href="tel:+7 <?= $telephone ?>" class="top-sidebar-tel">+7 <?= $telephone ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php get_template_part('blocks/all/search') ?>
    <div class="menu-top-wrapper">
        <div class="container">
            <div class="menu-open-btn">
                <i class="las la-bars"></i> Каталог товаров
            </div>
            <div class="menu-top">
                <?php wp_nav_menu(['theme_location' => 'top_menu', 'container' => false, 'menu_class' => 'top-sidebar-menu']);?>
            </div>
            <div class="menu-bookmarks">
                <ul>
                    <li>
                        <a href="/compare">
                            <i class="las la-balance-scale-left"></i>
                            <div id="compare" class="label-number <?= count($compare_array)?'':'hidden-block' ?>">
                                <?= count($compare_array) ?>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/favorites">
                            <i class="lar la-star"></i>
                            <div id="favorites" class="label-number <?= count($favorites_array)?'':'hidden-block' ?>">
                                <?= count($favorites_array) ?>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="/cart">
                            <i class="las la-shopping-cart"></i>
                            <div id="cart" class="label-number <?= $cart_count?'':'hidden-block' ?>">
                                <?= $cart_count ?>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-top-menu">
        <div class="container">
            <?= getCategoriesList() ?>
        </div>
    </div>
    <div class="main-top-mobile-menu">
        <div class="container">
            <?= getCategoriesMobileList() ?>
        </div>
    </div>
</div>