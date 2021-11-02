<?php

$brands = get_terms('pa_brand');
$types = get_terms('pa_type_velo');
$colors = get_terms('pa_color');
$sizes = get_terms('pa_wheel_size');
$speeds = get_terms('pa_speed');
$tormozs = get_terms('pa_tormoz');

$category = get_term_by('slug', 'velosipedy', 'product_cat');

$select_price = get_max_and_min_price($category);

$products = wc_get_products(array('posts_per_page' => -1));
$products_count = count($products);

?>
<div class="home-bike-select">
    <div class="container">
        <div class="home-bike-select-wrapper">
            <h2>Какой велосипед <span>вам подходит?</span></h2>
            <div class="flex-wrapper">
                <div class="small-flex">
                    <div class="select-input" data-type="brand">
                        <div class="select-input-value">
                            <span></span>
                            <i class="las la-angle-down"></i>
                        </div>
                        <div class="select-input-option">
                            <div class="select-option-item option-item-select" data-value="">Бренд</div>
                            <?php foreach ($brands as $brand): ?>
                                <div class="select-option-item" data-value="<?= $brand->slug ?>"><?= $brand->name ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="small-flex">
                    <div class="select-input" data-type="type_velo">
                        <div class="select-input-value">
                            <span></span>
                            <i class="las la-angle-down"></i>
                        </div>
                        <div class="select-input-option">
                            <div class="select-option-item option-item-select" data-value="">Тип велосипеда</div>
                            <?php foreach ($types as $type): ?>
                                <div class="select-option-item" data-value="<?= $type->slug ?>"><?= $type->name ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="small-flex">
                    <div class="select-input" data-type="color">
                        <div class="select-input-value">
                            <span></span>
                            <i class="las la-angle-down"></i>
                        </div>
                        <div class="select-input-option">
                            <div class="select-option-item option-item-select" data-value="">Цвет</div>
                            <?php foreach ($colors as $color): ?>
                                <div class="select-option-item" data-value="<?= $color->slug ?>"><?= $color->name ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-wrapper">
                <div class="small-flex">
                    <div class="select-input" data-type="wheel_size">
                        <div class="select-input-value">
                            <span></span>
                            <i class="las la-angle-down"></i>
                        </div>
                        <div class="select-input-option">
                            <div class="select-option-item option-item-select" data-value="">Размер колес</div>
                            <?php foreach ($sizes as $size): ?>
                                <div class="select-option-item" data-value="<?= $size->slug ?>"><?= $size->name ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="small-flex">
                    <div class="select-input" data-type="speed">
                        <div class="select-input-value">
                            <span></span>
                            <i class="las la-angle-down"></i>
                        </div>
                        <div class="select-input-option">
                            <div class="select-option-item option-item-select" data-value="">Кол-во скоростей</div>
                            <?php foreach ($speeds as $speed): ?>
                                <div class="select-option-item" data-value="<?= $speed->slug ?>"><?= $speed->name ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="small-flex">
                    <div class="select-input" data-type="tormoz">
                        <div class="select-input-value">
                            <span></span>
                            <i class="las la-angle-down"></i>
                        </div>
                        <div class="select-input-option">
                            <div class="select-option-item option-item-select" data-value="">Тип тормаза</div>
                            <?php foreach ($tormozs as $tormoz): ?>
                                <div class="select-option-item" data-value="<?= $tormoz->slug ?>"><?= $tormoz->name ?></div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="home-range-wrapper">
                <input type="text" id="homeRange" class="js-range-slider" data-min="<?= $select_price['min'] ?>" data-max="<?= $select_price['max'] ?>" data-from="<?= $select_price['min'] ?>" data-to="<?= $select_price['max'] ?>"/>
            </div>
            <div class="home-bike-select-btn show-bike-select-btn">
                <div class="load-progress invisible-element">
                    <i class="las la-spinner"></i><span>идет загрузка...</span>
                </div>
                <a class="btn btn-blue count-product" href="/bikes-catalog">Показать <span><?= $products_count ?></span></a>
            </div>
        </div>
    </div>
</div>