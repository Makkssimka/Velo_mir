<?php

$tags = wp_get_object_terms( $product->get_id(), 'product_tag');
$tag = array_shift($tags); ?>

<?php if ($tag) : ?>

<?php

$products_tag = wc_get_products(array(
    'product_tag' => $tag->slug,
));

$product_colors = array();
$colors = array();

foreach ($products_tag as $item) {
    $color = $item->get_attribute('cvet');
    if (!in_array($color, $colors)) {
        $colors[] = $color;
        $product_colors[] = $item;
    }
}

?>

<div class="product-color">
    <p>цвет:</p>
    <ul>
        <?php foreach ($product_colors as $item) : ?>
            <li class="<?= $item->get_attribute('cvet') == $product->get_attribute('cvet')?'inactive-element':'' ?>">
                <?= get_color_link($item->get_id()) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php endif; ?>
