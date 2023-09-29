<?php
/* Template Name: Compare */

global $post;
global $cart_ids;

$compare_ids = (isset($_SESSION['compare'])) ? json_decode($_SESSION['compare']) : array();

if ($compare_ids) {
    $products = wc_get_products(array(
        'include' => $compare_ids
    ));

    $params_list = [];
    $product_list = [];

    foreach ($products as $product) {

        // Получаем основные данные продукта
        $product_list[$product->get_name()]['id'] = $product->get_id();
        $product_list[$product->get_name()]['image_link'] = get_image_link($product);
        $product_list[$product->get_name()]['price'] = $product->get_price();
        $product_list[$product->get_name()]['product'] = $product;
        $description = $product->get_description();

        // Перебираем основные параметры и создаем список параметров
        foreach ($product->get_attributes() as $attribute) {
            $key = wc_attribute_label($attribute->get_name());
            $value = $attribute->get_terms()[0]->name;

            if ($key === 'Цвет' || $key === 'Цвет_доп') continue;

            if ($value) {
                $product_list[$product->get_name()]['desc'][$key] = $value;
            }

            if (!in_array($key, $params_list) && $value) {
                $params_list[] = $key;
            }
        }

        // Перебираем описание и создаем список параметров
        foreach (explode(PHP_EOL, $description) as $item_description) {
            $item_description = explode(':', $item_description);

            $key = trim($item_description[0]);
            $value = isset($item_description[1]) ? trim($item_description[1]) : false;

            if ($value) {
                $product_list[$product->get_name()]['desc'][$key] = $value;
            }

            if (!in_array($key, $params_list) && $value) {
                $params_list[] = $key;
            }
        }
    }
}


?>

<?php get_header(); ?>

<?php get_template_part('blocks/breadcrumbs') ?>

<div class="container content">
    <h1 class="h3"><?= $post->post_title; ?></h1>
    <div class="h6"><?= $post->post_excerpt; ?></div>

    <?php if (count($compare_ids) > 1) : ?>
        <div class="compare">
            <div class="compare__list">
                <?php foreach($product_list as $key => $product) : ?>
                    <div class="compare__item">
                        <div
                            class="compare__img"
                            style="background-image: url(<?= $product['image_link'] ?>);">
                        </div>

                        <div class="compare__title mt-1">
                            <a href="<?= get_permalink($product['id']) ?>">
                                <?= $product['product']->get_name() ?>
                            </a>
                        </div>

                        <div class="compare__price mt-1 mb-2">
                            <div class="compare__price_sale">
                                <?= wc_price($product['product']->get_sale_price()) ?>
                            </div>

                            <div class="compare__price_regular">
                                <?= wc_price($product['product']->get_regular_price()) ?>
                            </div>
                        </div>

                        <div class="compare__button mb-2">
                            <a href="<?= get_permalink($product['id']) ?>" class="buttons buttons_orange">к товару</a>

                            <a data-compare="<?= $product['id'] ?>" class="compare__remove" href="#">удалить</a>
                        </div>

                        <?php foreach($params_list as $param) : ?>
                            <div class="compare__param">
                                <div class="compare__param-name">
                                    <?= $param ?>
                                </div>
                                <div class="compare__param-value">
                                    <?= $product['desc'][$param] ?? '-' ?>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    <?php else : ?>
        <div class="text_center">
            <img width="160px" src="<?= get_asset_path('images/content', 'order_empty.svg') ?>" alt="order empty">
            <div class="mt-2">У Вас товаров для сравнения!</div>
            <div class="mt-1">Выберите не менее двух товаров для сравнения</div>
            <div class=" mt-2 flex justify-center gap-1">
                <a href="/" class="buttons buttons_blue">На главную</a>
            </div>
        </div>
    <?php endif ?>
</div>

<?php get_footer(); ?>