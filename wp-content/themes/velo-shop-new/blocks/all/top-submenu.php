<header class="container">
    <div class="top-submenu">
        <a href="#" class="top-submenu__close">
            <img src="<?= get_asset_path('images/icons', 'close-modal.svg') ?>" alt="close">
        </a>

        <div class="top-submenu__location">
            <img src="<?= get_asset_path('images/icons', 'location.svg') ?>" alt="location">
            Волгоград
        </div>

        <?php wp_nav_menu(['theme_location' => 'top_menu', 'container' => false, 'menu_class' => 'top-submenu__nav']) ?>
    </div>
</header>