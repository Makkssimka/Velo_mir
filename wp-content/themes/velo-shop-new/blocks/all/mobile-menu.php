<?php
$categories = getMainCategories();

?>

<nav class="mobile mobile-menu">
    <div class="mobile-menu__header">
        Каталог товаров

        <a href="#" class="mobile-menu__close">
            <img src="<?= get_asset_path('images/icons', 'close-modal.svg') ?>" alt="Close mobile menu">
        </a>
    </div>

    <ul class="mobile-menu__list">
        <?php foreach ($categories as $category) : ?>
            <li>
                <a href="<?= $category['link'] ?>"><?= $category['name'] ?></a>

                <?php if ($category['child']) : ?>
                    <ul>
                        <?php foreach ($category['child_list'] as $subcategory) : ?>
                            <li>
                                <a href="<?= $subcategory['link'] ?>"><?= $subcategory['name'] ?></a>
                            </li>
                        <?php endforeach ?>
                    </ul>
                <?php endif ?>
            </li>
        <?php endforeach ?>
    </ul>
</nav>