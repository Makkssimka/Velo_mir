<?php

$attributes = $product->get_attributes();
$visible_attributes = getAttributesListVisible();

$attributes_array = [];

foreach ($attributes as $key => $attr) {
    if (array_key_exists($key, $visible_attributes)) {

        $term = get_term($attr['options'][0]);
        $attributes_array[] = [
            'icon' => $visible_attributes[$key],
            'name' => wc_attribute_label($key),
            'value' => $term->name
        ];
    }
}

?>

<ul class="product-attributes-value">
    <?php foreach ($attributes_array as $item) : ?>
        <li>
            <span>
                <i class="las <?= $item['icon'] ?>"></i>
                <?= $item['name'] ?>:
            </span>
            <span><?= $item['value'] ?></span>
        </li>
    <?php endforeach ?>
</ul>
