<div class="mt-4">
    <?php get_template_part('blocks/all/catalog-menu') ?>
</div>

<?php get_template_part('blocks/breadcrumbs') ?>

<div class="container">
    <div class="grid grid-product gap-2">
        <?php get_template_part('woocommerce/blocks/product-preview') ?>
        <?php get_template_part('woocommerce/blocks/product-info') ?>
    </div>

    <div class="grid grid-product gap-2 mt-2">
        <?php get_template_part('woocommerce/blocks/product-table') ?>

        <div class="mt-4">
            <?php get_template_part('blocks/all/service-banner') ?>
        </div>
    </div>
</div>

<div class="mt-4">
    <?php get_template_part('blocks/all/similar') ?>
</div>
