<?php

$instagram = get_option('instagram');
$whatsapp = get_option('whatsapp');
$vk = get_option('vk');

$times = time_to_array(get_option('time_job'));

$categories = getMainCategoriesList();
?>

<footer class="footer">
    <div class="container">

        <div class="footer__content">
            <div class="footer__logo">
                <img src="<?= get_asset_path('images/app', 'logo.svg') ?>" alt="logo">

                <a href="tel:+7 <?= get_option('telephone_num') ?>">+7 <?= get_option('telephone_num') ?></a>

                <div class="footer__time">
                  <?php foreach ($times as $time) : ?>
                      <div>
                          <?= $time['label'] ?>: <?= $time['time'] ?>
                      </div>
                  <?php endforeach ?>
                </div>

                <div class="footer__media">
                    <?php if ($instagram) : ?>
                        <a href="<?= $instagram ?>">
                            <img src="<?= get_asset_path('images/app', 'instagram.svg') ?>" alt="instagram">
                        </a>
                    <?php endif ?>
                    <?php if ($whatsapp) : ?>
                        <a href="<?= $whatsapp ?>">
                            <img src="<?= get_asset_path('images/app', 'whatsapp.svg') ?>" alt="whatsapp">
                        </a>
                    <?php endif ?>
                    <?php if ($vk) : ?>
                        <a href="<?= $vk ?>">
                            <img src="<?= get_asset_path('images/app', 'vk.svg') ?>" alt="vk">
                        </a>
                    <?php endif ?>
                </div>
            </div>

            <div class="footer__menu desktop">
                <div class="footer__menu-head">
                    Каталог
                </div>

                <div class="footer__links footer__links_upper footer__links_column">
                    <?= $categories ?>
                </div>
            </div>

            <div class="footer__menu">
                <div class="footer__menu-head">
                    НАШИМ ПОКУПАТЕЛЯМ
                </div>

                <?php wp_nav_menu(['theme_location' => 'bottom_menu', 'container' => false, 'menu_class' => 'footer__links']) ?>
            </div>
        </div>

        <div class="footer__copyright">
            <p>
                Производитель оставляет за собой право менять комплектацию, внешний вид и технические характеристики велосипедов без дополнительных уведомлений. Убедительно просим Вас при выборе модели проверять наличие желаемых функций и характеристик. Вся представленная на сайте информация приведена в ознакомительных целях и не является публичной офертой, определяемой положениями Статьи 437 Гражданского кодекса РФ.
            </p>
            <p>
                © 2017-2023 Интернет-магазин велосипедов в г. Волгоград "Веломир".
            </p>
        </div>

        <div class="footer__bg">
            <img class="footer__bg" src="<?= get_asset_path('images/app', 'footer-bg.svg') ?>" alt="footer background">
        </div>
    </div>
</footer>

<?php get_template_part('blocks/all/modal_call') ?>

<?php wp_footer() ?>
</body>
</html>
