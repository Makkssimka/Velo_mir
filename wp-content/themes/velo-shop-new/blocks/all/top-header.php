<?php
global $favorite_ids;
global $compare_ids;

$cart = WC()->cart;
$cart_count = $cart->get_cart_contents_count();
?>

<div class="container">
    <div class="top-header">
        <div class="top-header__logo">
            <a href="/">
                <img src="<?= get_asset_path('images/app', 'logo_new.svg') ?>" alt="logo">
            </a>
        </div>

        <div class="top-header__search">
            <div class="search__ajax">
                <input class="search-input" type="text" placeholder="Поиск товаров">

                <a href="#" class="top-header__icon">
                    <img src="<?= get_asset_path('images/icons', 'search-white.svg') ?>" alt="search">
                </a>

                <div class="search-result-ajax">
                    <ul>
                    </ul>

                    <div class="search-all">
                        <a href="#">Все результаты</a>
                    </div>
                </div>
            </div>

            <a href="#" class="top-header__submenu mobile" data-target="top-submenu">
                <img src="<?= get_asset_path('images/icons', 'menu-dot.svg') ?>" alt="menu dot">
            </a>
        </div>

        <div class="top-header__menu">
            <div class="top-header__bg">
                <img src="<?= get_asset_path('images/app', 'cloud.svg') ?>" alt="cloud">
            </div>
            <div class="top-header__call">
                <img src="<?= get_asset_path('images/icons', 'phone.svg') ?>" alt="phone">

                <div>
                    <a href="tel:+7 <?= get_option('telephone_num') ?>">+7 <?= get_option('telephone_num') ?></a>
                    <a data-modal="modal_call" href="#" class="link_under">Заказать звонок</a>
                    <div class="top-header__time">
                        Ежедневно: <span>с 10:00 до 18:00</span>
                    </div>
                </div>
            </div>

            <div class="top-header__compare">
                <a href="#" data-target="mobile_menu" class="mobile">
                    <img src="<?= get_asset_path('images/icons', 'menu-burger.svg') ?>" alt="compare">
                    КАТАЛОГ
                </a>

                <a class="top-header__item" href="/compare">
                    <img src="<?= get_asset_path('images/icons', 'compare.svg') ?>" alt="compare">
                    Сравнение
                    <span class="top-header__counter"></span>
                    <span
                        data-counter="compare"
                        data-count="<?= count($compare_ids) ?>"
                        class="top-header__counter">
                    </span>
                </a>

                <a class="top-header__item" href="/favorites">
                    <img src="<?= get_asset_path('images/icons', 'heart.svg') ?>" alt="compare">
                    Избранное
                    <span class="top-header__counter"></span>
                    <span
                        data-counter="favorites"
                        data-count="<?= count($favorite_ids) ?>"
                        class="top-header__counter">
                    </span>
                </a>

                <a class="top-header__item" href="/cart">
                    <img src="<?= get_asset_path('images/icons', 'cart.svg') ?>" alt="compare">
                    Корзина
                    <span
                        data-counter="cart"
                        data-count="<?= $cart_count ?>"
                        class="top-header__counter">
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>