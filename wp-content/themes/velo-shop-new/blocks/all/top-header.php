<div class="container">
    <div class="top-header">
        <div class="top-header__logo">
            <a href="/">
                <img src="<?= get_asset_path('images/app', 'logo.svg') ?>" alt="logo">
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
                    <a href="#" class="link_under" data-modal="call">Заказать звонок</a>
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

                <a href="/compare">
                    <img src="<?= get_asset_path('images/icons', 'compare.svg') ?>" alt="compare">
                    Сравнение
                </a>

                <a href="/favorites">
                    <img src="<?= get_asset_path('images/icons', 'heart.svg') ?>" alt="compare">
                    Избранное
                </a>

                <a href="/cart">
                    <img src="<?= get_asset_path('images/icons', 'cart.svg') ?>" alt="compare">
                    Корзина
                </a>
            </div>
        </div>
    </div>
</div>