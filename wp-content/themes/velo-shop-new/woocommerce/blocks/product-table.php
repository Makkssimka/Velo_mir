<?php

global $product;

$description = $product->get_description();
$attributes_list = array();

foreach (explode(PHP_EOL, $description) as $item_description) {
    $item_description = explode(':', $item_description);

    if (!trim($item_description[0])) continue;

    $attributes_list[] = array(
        'name' => trim($item_description[0]),
        'value' => isset($item_description[1]) ? trim($item_description[1]) : ''
    );
}

?>
<div>
    <p class="text_bold text_upper">Характеристики</p>

    <div class="product-table">
        <?php foreach ($attributes_list as $item) : ?>
            <?php if ($item['value']) : ?>
                <div class="product-table__item">
                    <span><?= $item['name'] ?></span>
                    <span class="text_bold"><?= $item['value'] ?></span>
                </div>
            <?php else : ?>
                <div class="product-table__item">
                  <span class="product-table__subheader"><?= $item['name'] ?></span>
                </div>
            <?php endif ?>
        <?php endforeach ?>
    </div>
</div>