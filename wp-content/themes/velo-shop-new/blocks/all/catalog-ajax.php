<?php

$categories = getMainCategories();

?>

<div class="mt-1">
    <div class="container">
        <nav class="main-menu">
            <ul data-default="Велосипеды" class="owl-carousel main-menu__list">
                <?php foreach ($categories as $id => $category) : ?>
                    <li>
                        <a
                          data-id="<?= $id ?>"
                          data-name="<?= $category['name'] ?>"
                          data-child="<?= $category['child'] ?>"
                          class="main-menu__item main-menu__item_active" href="<?= $category['link'] ?>">
                              <?= $category['name'] ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </nav>
    </div>
</div>

<div data-catalog="loader" class="container catalog-list__wrapper">
    <div class="loader catalog__loader">
      <img src="<?= get_asset_path('images/app', 'loader.svg') ?>" alt="loader">
    </div>

    <div class="separator mb-1">
        <span data-catalog="head">Велосипеды</span>
    </div>

    <div class="catalog-list catalog-list_5" data-catalog="list"></div>
</div>