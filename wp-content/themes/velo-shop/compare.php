<?php
/* Template Name: Compare */

global $post;

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

    <div class="content-main article compare">
        <div class="container">
            <h1><?= $post->post_title; ?></h1>
            <div class="article-subheader"><?= $post->post_excerpt; ?></div>
            <div class="article-content">
                <div class="article-text">
                    <div class="compare-wrapper">
                        <?php if (count($compare_ids)) : ?>
                            <div class="compare-desc">
                                <?php foreach ($params_list as $param) : ?>
                                    <div class="compare-desc-item"><?= $param ?></div>
                                <?php endforeach ?>
                                <div class="compare-desc-item"></div>
                            </div>
                            <?php foreach ($product_list as $name => $product) : ?>
                                <div class="compare-item">
                                    <div
                                            class="compare-img"
                                            style="background-image: url(<?= $product['image_link'] ?>);">
                                    </div>
                                    <div class="compare-price">
                                        <?= wc_price($product['price']) ?>
                                    </div>
                                    <div class="compare-title">
                                        <a href="<?= get_permalink($product['id']) ?>" target="_blank"><?= $name ?></a>
                                    </div>
                                    <div class="compare-btn">
                                        <?= add_cart_btn($product['product'], 'btn-blue') ?>
                                    </div>
                                    <?php foreach ($params_list as $param) : ?>
                                        <div class="compare-value">
                                            <?php if (isset($product['desc'][$param])) : ?>
                                                <?= $product['desc'][$param] ?>
                                            <?php else : ?>
                                                <i class="las la-minus"></i>
                                            <?php endif ?>
                                        </div>
                                    <?php endforeach ?>
                                    <div class="compare-value compare-remove">
                                        <a href='?compare_remove&id=".$bike->get_id()."'>убрать из списка</a>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        <?php else : ?>
                            <div class="empty">
                                <img src="<?= get_asset_path('images', 'empty_page.svg') ?>">
                                <div class="empty-head">Нет товаров для сравнения!</div>
                                <p>Вы не выбрали ни одного товара для сравенния</p>
                                <div class="empty-more-btn">
                                    <a class="btn btn-green" href="/">На главную</a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>