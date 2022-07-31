<?php

$tags = wp_get_object_terms( $product->get_id(), 'product_tag');
$tag = array_shift($tags);

$product_diametr = $product->get_attribute('diametr-kolesaoboda');

// Объединение для двойных цветов
$cvet = $product->get_attribute('cvet');
$cvet_dop = $product->get_attribute('cvet_dop') ?? $product->get_attribute('dop-cvet');
$product_cvet = $cvet . $cvet_dop;


?>

<?php if ($tag) : ?>

<?php

$products_by_tag = wc_get_products(array(
    'product_tag' => $tag->slug,
    'stock_status' => 'instock',
));

$product_variations = [];

foreach ($products_by_tag as $prod) {
    $d = $prod->get_attribute('diametr-kolesaoboda');
    $c = $prod->get_attribute('cvet');
    $e = $prod->get_attribute('cvet_dop');
    if (!key_exists($d, $product_variations)) {
        $product_variations[$d] = [
            'id' => $prod->get_id(),
            'cvets' => [
                [
                    'id' => $prod->get_id(),
                    'full' => $c . $e
                ]
            ]
        ];
    } else {
        $product_variations[$d]['cvets'][] = [
            'id' => $prod->get_id(),
            'full' => $c . $e
        ];
    }
}

ksort($product_variations);

?>

<div class="product-size">
    <p>Размер колес:</p>
    <ul>
        <?php foreach($product_variations as $key => $item) : ?>
            <li class="<?= $key == $product_diametr ? 'active' : '' ?>">
                <a href="<?= get_permalink($item['id']) ?>">
                    <?= $key ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="product-color">
    <p>цвет:</p>
    <ul>
        <?php foreach ($product_variations[$product_diametr]['cvets'] as $item) : ?>
            <li class="<?= $item['id'] == $product->get_id() ? 'inactive-element' : '' ?>">
                <?= get_color_link($item['id']) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php endif ?>
