<?php

$price_filter = get_max_and_min_price($category);
//$price = property_exists($filter_value, 'price')?$filter_value->price:null;
$price = null;
$price_from = $price?$price[0]:$price_filter['min'];
$price_to = $price?$price[1]:$price_filter['max'];

?>

<div class="catalog-filter-block">
    <div class="catalog-filter-label">Цена</div>
    <div class="catalog-filter-price-range">
        <input type="text" id="priceRange" class="js-range-slider" />
    </div>
    <div class="catalog-filter-price">
        <input type="text" id="priceFrom" data-price-min="<?= $price_filter['min'] ?>" data-price-from="<?= $price_from ?>">
        <i class="las la-minus"></i>
        <input type="text" id="priceTo" data-price-max="<?= $price_filter['max'] ?>" data-price-to="<?= $price_to ?>">
    </div>
</div>