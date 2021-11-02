<?php
$telephone_array = explode(', ', get_option('telephone_num'));
$time_job_array = time_to_array(get_option('time_job'));
$vk_url = get_option('vk');
$inst_url = get_option('instagram');
?>

<div class="bottom-sidebar">
    <div class="container">
        <div class="logo-bottom-sidebar">
            <div class="logo-bottom-sidebar-wrapper">
                <?= get_custom_logo(); ?>
            </div>
            <ul>
                <?php foreach ($telephone_array as $telephone) : ?>
                    <li><a href="tel:+7 <?= $telephone ?>" class="bottom-sidebar-tel">+7 <?= $telephone ?></a></li>
                <?php endforeach; ?>
                <li class="bottom-sidebar-time">
                    <?php foreach ($time_job_array as $time_job) : ?>
                        <div>
                            <?= $time_job['label'] ?> <span><?= $time_job['time'] ?></span>
                        </div>
                    <?php endforeach; ?>
                </li>
                <?php if (get_option('call_show')) : ?>
                    <li><a href="#" class="open-modal">Обратный звонок</a></li>
                <?php endif; ?>
            </ul>
        </div>
        <div class="main-menu-bottom-sidebar">
            <p>Каталог</p>
            <?= getMainCategoriesList() ?>
        </div>
        <div class="right-menu-bottom-sidebar">
            <div class="bottom-sidebar-submenu">
                <p>Помощь</p>
                <?php wp_nav_menu(['theme_location' => 'bottom_menu', 'container' => false ]);?>
            </div>
            <div class="icons-bottom-sidebar">
                <div>
                    <p>Мы в соцсетях:</p>
                    <ul>
                        <li><a target="_blank" href="<?= $inst_url ?>"><i class="lab la-instagram"></i> Instagram</a></li>
                        <li><a target="_blank" href="<?= $vk_url ?>"><i class="lab la-vk"></i> Vkontakte</a></li>
                    </ul>
                </div>
                <div class="copy-bottom-sidebar">
                    © 2004 - <?= date('Y') ?>, ВелоМир. <span>Все права защищены</span>
                </div>
            </div>
        </div>
    </div>
</div>