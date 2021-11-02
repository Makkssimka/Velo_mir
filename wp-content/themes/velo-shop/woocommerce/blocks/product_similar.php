<?php

$similar_product_ids = wc_get_related_products($product->get_id(), 10);
$similar_products = array();

foreach ($similar_product_ids as $product_id) {
    $similar_products[] = wc_get_product($product_id);
}

?>

<?php if (count($similar_products)) : ?>
<div class="product-similar-header">
    <h3>Похожие товары</h3>
    <ul>
        <li><a data-nav="left" class="similar-caroussel-nav" href="#"><i class="las la-angle-left"></i></a></li>
        <li><a data-nav="right" class="similar-caroussel-nav" href="#"><i class="las la-angle-right"></i></a></li>
    </ul>
</div>
<ul id="similar-carousel" class="owl-carousel owl-theme">
<?php foreach ($similar_products as $similar_product) : ?>
    <?php bike_widget($similar_product) ?>
<?php endforeach; ?>
</ul>
<?php endif ?>
