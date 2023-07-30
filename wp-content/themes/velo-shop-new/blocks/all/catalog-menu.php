<?php

$categories = getMainCategories();
$item = $args['name'] ?? 'Велосипеды';

?>

<div class="mt-1">
    <div class="container">
        <nav class="main-menu">
            <ul data-default="<?= $item ?>" class="owl-carousel main-menu__list">
                <?php foreach ($categories as $id => $item) : ?>
                    <li>
                        <a
                            data-id="<?= $id ?>"
                            data-name="<?= $item['name'] ?>"
                            data-child="<?= $item['child'] ?>"
                            class="main-menu__item main-menu__item_active" href="<?= $item['link'] ?>">
                            <?= $item['name'] ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>
        </nav>
    </div>
</div>
