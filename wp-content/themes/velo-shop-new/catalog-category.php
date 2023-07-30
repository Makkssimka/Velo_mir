<?php

$category = $args['category'];
$children = $args['children'];

?>

<?php get_header() ?>

<div class="mt-4">
    <?php get_template_part('blocks/all/catalog-menu', null, ['name' => $category->name]) ?>

    <div class="container catalog-list__wrapper">
        <div class="separator mb-1">
            <span data-catalog="head">
                <?= $category->name ?>
            </span>
        </div>

        <div class="catalog-list catalog-list_5">
            <?php foreach ($children as $child) : ?>
                <a href="<?= get_term_link($child->term_id) ?>" class="catalog-category__item">
                    <span><?= $child->name ?></span>

                    <div
                        class="catalog-category__bg"
                        style="background-image: url('<?= getThumbnail($child->term_id) ?>');">
                    </div>
                </a>
            <?php endforeach ?>
        </div>
    </div>
</div>

<?php get_footer() ?>