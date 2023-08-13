<?php
$category = $args['category'];

$price = null;
$filter_value = isset($_SESSION['filter']) ? json_decode($_SESSION['filter'], true) : '';
$filter_value =  $filter_value['category'][0] == $category->slug ? $filter_value : '';

if (isset($filter_value['price'])) $price = $filter_value['price'];

$price_filter = get_max_and_min_price($category);
$price_from = $price?$price[0]:$price_filter['min'];
$price_to = $price?$price[1]:$price_filter['max'];

?>

<div class="filter__block">
    <div class="filter__label">Цена</div>

    <div class="filter__price">
        <div class="filter__input">
            <input
              id="priceFrom"
              type="number"
              class="input"
              step="10"
              value="<?= $price_from ?>"
              min="<?= $price_filter['min'] ?>"
              max="<?= $price_filter['max'] ?>"
            >
        </div>

        <div class="filter__separator">-</div>

        <div class="filter__input">
            <input
              id="priceTo"
              type="number"
              class="input"
              step="10"
              value="<?= $price_to ?>"
              min="<?= $price_filter['min'] ?>"
              max="<?= $price_filter['max'] ?>"
            >
        </div>
    </div>

    <div class="filter__range">
        <input
          type="text"
          class="filter__slider"
          data-type="double"
          data-from="<?= $price_from ?>"
          data-to="<?= $price_to ?>"
          data-min="<?= $price_filter['min'] ?>"
          data-max="<?= $price_filter['max'] ?>"
        />
    </div>
</div>