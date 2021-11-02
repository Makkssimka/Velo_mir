<?php

$tags = wp_get_object_terms( $product->get_id(), 'product_tag');
$tag = array_shift($tags); ?>

<?php if ($tag) : ?>

<?php $wheel_size = $product->get_attribute('wheel_size');
$color = $product->get_attribute('color');

$products_color = array();
$products_wheel = array();
$products_frame = array();

$wheel_variation = array();
$frame_variation = array();
$color_variation = array();

$products_tag = wc_get_products(array(
    'product_tag' => $tag->slug,
));

foreach ($products_tag as $item) {
    $wheel_size_item = $item->get_attribute('wheel_size');
    $frame_size_item = $item->get_attribute('frame_size');
    $color_item = $item->get_attribute('color');

    if ($wheel_size_item == $wheel_size && !in_array($color_item, $color_variation)) {
        $products_color[] = $item;
        $color_variation[] = $color_item;
    }

    if (!in_array($wheel_size_item, $wheel_variation)) {
        $products_wheel[] = $item;
        $wheel_variation[] = $wheel_size_item;
    }

    if (!$frame_size_item) continue;

    if ($wheel_size_item == $wheel_size && $color_item == $color && !in_array($frame_size_item, $frame_variation)) {
        $products_frame[] = $item;
        $frame_variation[] = $frame_size_item;
    }
}

?>
<div class="product-color">
    <p>цвет:</p>
    <ul>
        <?php foreach ($products_color as $item) : ?>
            <li class="<?= $item->get_attribute('color') == $product->get_attribute('color')?'inactive-element':'' ?>">
                <?= get_color_link($item->get_id()) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="product-variation-wrapper">
    <?php if (count($products_frame)): ?>
        <div class="product-size">
            <p>размер рамы:</p>
            <ul>
                <?php foreach($products_frame as $item) : ?>
                    <li class="<?= $item->get_attribute('frame_size') == $product->get_attribute('frame_size')?'inactive-element':'' ?>">
                        <a href="<?= get_permalink($item->get_id()) ?>">
                            <?= $item->get_attribute('frame_size') ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif ?>

    <div class="product-size">
        <p>Размер колес:</p>
        <ul>
            <?php foreach($products_wheel as $item) : ?>
                <li class="<?= $item->get_attribute('wheel_size') == $product->get_attribute('wheel_size')?'inactive-element':'' ?>">
                    <a href="<?= get_permalink($item->get_id()) ?>">
                        <?= $item->get_attribute('wheel_size') ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<?php endif; ?>
