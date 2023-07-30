<?php

global $product;
$similar_product_ids = wc_get_related_products($product->get_id(), 10);
$similar_products = array();

foreach ($similar_product_ids as $product_id) {
    $similar_products[] = wc_get_product($product_id);
}

?>

<?php if (count($similar_products)) : ?>
    <div class="container">
        <div class="separator">
            <span>Похожие товары</span>
        </div>

        <div class="catalog-list catalog-list_5 mt-1">
            <?php foreach ($similar_products as $product) : ?>
                <?php get_template_part('blocks/all/product', null, ['product' => $product]) ?>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>
