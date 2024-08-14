<?php
/* Template Name: Contact */

global $post;
$name_expert = get_option('name_expert');
$address = explode('?', get_option('address'));
$addresses_partner = explode('?', get_option('address_partner'));
$ur_address = get_option('ur_address');
$map_script = get_option('map_script');
$name_org = get_option('name_org');
$time_job_array = time_to_array(get_option('time_job'));

$telephone_array = explode(',', get_option('telephone_num'));
$telephone_with_address_array = [];
foreach ($telephone_array as $telephone) {
    $item = explode(':', $telephone);
    $telephone_with_address_array[] = [
        'telephone' => trim($item[0]),
        'address' => trim($item[1] ?? '')
    ];
}

$email_array = explode(', ', get_option('email'));

get_header();
?>

<?php get_template_part('blocks/breadcrumbs') ?>

<div class="container content">
    <h1 class="h3"><?= $post->post_title; ?></h1>
    <div class="h6"><?= $post->post_excerpt; ?></div>

    <div class="flex gap-1 block-m">
        <div class="w-full">
            <div class="contact__grid">
                <div>
                    <div class="h5">Адреса магазинов:</div>

                    <ul class="list_simple">
                        <?php foreach ($address as $item): ?>
                            <li><?= $item; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div>
                    <div class="h5">Часы работы:</div>

                    <ul class="list_simple">
                        <?php foreach ($time_job_array as $time_job) : ?>
                            <li><?= $time_job['label'] ?> <?= $time_job['time'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div>
                    <div class="h5">Адреса магазинов партнеров:</div>

                    <ul class="list_simple">
                        <?php foreach ($addresses_partner as $item): ?>
                            <li><?= $item; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div>
                    <div class="h5">Телефон:</div>

                    <ul class="list_simple">
                        <?php foreach ($telephone_with_address_array as $item) : ?>
                            <li>
                                <a class="link_under" href="tel:+7 <?= $item['telephone'] ?>">
                                    +7 <?= $item['telephone'] ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div>
                    <div class="h5">Электронная почта:</div>

                    <ul class="list_simple">
                        <li>
                            <?php foreach ($email_array as $email) : ?>
                                <a class="link_under" href="mailto: <?= $email ?>"><?= $email ?></a>
                            <?php endforeach; ?>
                        </li>
                        <li class="contact__social">
                            <a href="#">
                                <img src="<?= get_asset_path('images/icons', 'instagram.svg') ?>" alt="instagram">
                            </a>
                            <a href="#">
                                <img src="<?= get_asset_path('images/icons', 'whatsapp.svg') ?>" alt="whatsapp">
                            </a>
                            <a href="#">
                                <img src="<?= get_asset_path('images/icons', 'vk.svg') ?>" alt="vk">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="h5 mt-2">Наименование организации:</div>
            <p><?= $name_org ?></p>

            <div class="h5 mt-2">Юридический адрес:</div>
            <p><?= $ur_address ?></p>
        </div>

        <?php get_template_part('blocks/all/service-banner') ?>
    </div>

    <div class="separator">
        <span>Схема проезда</span>
    </div>

    <div class="contact__map">
        <?= $map_script ?>
    </div>
</div>

<?php get_footer(); ?>
