<?php
/* Template Name: Contact */

global $post;
$name_expert = get_option('name_expert');
$address = explode('?', get_option('address'));
$ur_address = get_option('ur_address');
$map_script = get_option('map_script');
$name_org = get_option('name_org');
$time_job_array = time_to_array(get_option('time_job'));
$telephone_array = explode(', ', get_option('telephone_num'));
$email_array = explode(', ', get_option('email'));

get_header();
?>

<div class="content-main article">
    <div class="container">
        <h1><?= $post->post_title; ?></h1>
        <div class="article-subheader"><?= $post->post_excerpt; ?></div>
        <div class="article-content">
            <div class="article-text">
                <h2 class="margin-top-none">Магазин на Жукова</h2>
                <div class="flex-wrapper">
                    <div class="semi-flex">
                        <strong>Адрес:</strong>
                        <?php foreach ($address as $item): ?>
                            <div><?= $item; ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="semi-flex">
                        <strong>Часы работы:</strong>
                        <?php foreach ($time_job_array as $time_job) : ?>
                            <div><?= $time_job['label'] ?> <?= $time_job['time'] ?></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="semi-flex">
                        <strong>Телефон:</strong>
                        <?php foreach ($telephone_array as $telephone) : ?>
                            <div><a href="tel:+7 <?= $telephone ?>">+7 <?= $telephone ?></a></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="semi-flex">
                        <strong>Электронная почта:</strong>
                        <?php foreach ($email_array as $email) : ?>
                            <div><a href="mailto: <?= $email ?>"><?= $email ?></a></div>
                        <?php endforeach; ?>
                    </div>
                    <div class="semi-flex">
                        <strong>Наименование организации:</strong>
                        <div><?= $name_org ?></div>
                    </div>
                    <div class="semi-flex">
                        <strong>Юридический адрес:</strong>
                        <div><?= $ur_address ?></div>
                    </div>
                </div>
                <h2>Схема проезда</h2>
                <div class="article-map">
                    <?= $map_script ?>
                </div>
            </div>
            <div class="article-navbar">
                <?php expert_widget() ?>
                <div class="article-anchor-nav">
                    <p>Содержание:</p>
                    <ul class="anchor-list">

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
