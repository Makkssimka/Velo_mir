<?php

global $product;

$attributes = $product->get_attributes();
$visible_attributes = getAttributesListVisible();
$attributes_array = [];

foreach ($attributes as $key => $attr) {
    if (!in_array($key, $visible_attributes) || !count($attr['options'])) continue;

    $term = get_term($attr['options'][0]);
    $attributes_array[] = [
        'name' => wc_attribute_label($key),
        'value' => $term->name
    ];
}

?>

<div class="info__description mt-2">
    <?php foreach ($attributes_array as $attribute) : ?>
        <span><?= $attribute['name'] ?></span>
        <span class="text_bold"><?= $attribute['value'] ?></span>
    <?php endforeach ?>
</div>
