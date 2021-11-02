<?php
add_action("admin_menu", "add_theme_menu_item");

function add_theme_menu_item(){
     add_menu_page("Старница параметров", "Параметры", "manage_options", "contact-theme-params");
     add_submenu_page("contact-theme-params", "Контакты для сайта", "Контакты", "manage_options", "contact-theme-params", "contact_setting_page_template");
    add_submenu_page("contact-theme-params", "Социальные сети", "Соц. сети", "manage_options", "social-theme-params", "social_setting_page_template");
    add_submenu_page("contact-theme-params", "Настройки статистики", "Статистика", "manage_options", "statistics-theme-params", "statistics_setting_page_template");
    add_submenu_page("contact-theme-params", "Настройки главной страницы", "Главная", "manage_options", "home-theme-params", "home_setting_page_template");

    add_settings_field(
            "maintenance_mode_id",
            "Режим разработки",
            "maintenance_mode_template",
            "general",
            "default"
    );

    add_action('admin_init', 'register_my_settings');
}

function register_my_settings(){
    register_setting("contact_settings", "address");
    register_setting("contact_settings", "map_script");
    register_setting("contact_settings", "ur_address");
    register_setting("contact_settings", "name_org");
    register_setting("contact_settings", "telephone_num");
    register_setting("contact_settings", "email");
    register_setting("contact_settings", "time_job");
    register_setting("contact_settings", "name_expert");
    register_setting("social_settings", "instagram");
    register_setting("social_settings", "vk");
    register_setting("home_settings", "ids_slider");
    register_setting("home_settings", "banner_list");
    register_setting("home_settings", "is_show_banner");
    register_setting("home_settings", "is_show_develop");
    register_setting( "general",  "maintenance_mode_active");
}

function maintenance_mode_template(){
    ?>
    <label for="maintenance_mode_active">
        <input name="maintenance_mode_active" type="checkbox" id="maintenance_mode_active" value="1" <?= get_option('maintenance_mode_active') ? "checked" : "" ?>>
        Активировать
    </label>
    <?php
}


function contact_setting_page_template(){ ?>
    <div class="wrap">
        <h1>Настройка контактов на сайте</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('contact_settings');
            ?>
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row">
                            <label for="address">Адреса магазинов</label>
                        </th>
                        <td>
                            <textarea rows="4" name="address" type="text" id="address" class="regular-text" placeholder="Волгоград, просп. Маршала Жукова, 121"><?= get_option('address') ?></textarea>
                            <p class="description" id="address">Адреса магазинов с разделителем ?</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="map_script">Скрипт карты</label>
                        </th>
                        <td>
                            <textarea rows="4" name="map_script" type="text" id="map_script" class="regular-text"><?= get_option('map_script') ?></textarea>
                            <p class="description" id="map_script">Скрипт карты Яндекс или Google</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="ur_address">Юридический адрес</label>
                        </th>
                        <td>
                            <textarea rows="4" name="ur_address" type="text" id="ur_address" class="regular-text" ><?= get_option('ur_address') ?></textarea>
                            <p class="description" id="ur_address">Юридический адрес организации</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="name_org">Наименование организации</label>
                        </th>
                        <td>
                            <textarea rows="4" name="name_org" type="text" id="name_org" class="regular-text"><?= get_option('name_org') ?></textarea>
                            <p class="description" id="name_org">Наименование организации с кратким описанием</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="telephone_num">Номера телефонов</label>
                        </th>
                        <td>
                            <input name="telephone_num" type="text" id="telephone_num" class="regular-text" placeholder="(905) 455-22-33, (902) 567-45-43" value="<?= get_option('telephone_num') ?>">
                            <p class="description" id="telefonenum">Номера телефонов через запятую без 8.</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="email">E-mail</label>
                        </th>
                        <td>
                            <input name="email" type="text" id="email" class="regular-text" placeholder="test@yandex.ru, test2@yandex.ru" value="<?= get_option('email') ?>">
                            <p class="description" id="email">E-mail адреса с разделителем ,</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="time_job">Время работы</label>
                        </th>
                        <td>
                            <input name="time_job" type="text" id="time_job" class="regular-text" placeholder="Пн-Пт/10:00 - 21:00?Сб-Вс/11:00 - 16:00" value="<?= get_option('time_job') ?>">
                            <p class="description" id="time_job">Обратите внимание на синтаксис, ? - разделяет блоки, / - разделяет блок времени</p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">
                            <label for="name_expert">Фамилия Имя эксперта</label>
                        </th>
                        <td>
                            <input name="name_expert" type="text" id="name_expert" class="regular-text" value="<?= get_option('name_expert') ?>">
                            <p class="description" id="name_expert">ФИ специалиста на баннере "Получить консультацию"</p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php
            submit_button();
            ?>
        </form>
    </div>
<?php }

function social_setting_page_template(){ ?>
    <div class="wrap">
        <h1>Социальные сети</h1>
        <h2 class="title">Настройка ссылок</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('social_settings');
            ?>
            <table class="form-table">
                <tbody>
                    <tr scope="row">
                        <th>
                            <label for="instagram">Instagram</label>
                        </th>
                        <td>
                            <input name="instagram" type="text" id="instagram" class="regular-text" placeholder="https://" value="<?= get_option('instagram') ?>">
                        </td>
                    </tr>
                    <tr scope="row">
                        <th>
                            <label for="vk">Vk</label>
                        </th>
                        <td>
                            <input name="vk" type="text" id="vk" class="regular-text" placeholder="https://" value="<?= get_option('vk') ?>">
                        </td>
                    </tr>
                </tbody>
            </table>
            <?php
            submit_button();
            ?>
        </form>
    </div>
<?php }

function statistics_setting_page_template(){ ?>
    <div class="wrap">
        <h1>Настройки статистики</h1>
    </div>
<?php }

function home_setting_page_template(){ ?>
    <?php $banner_ids = json_decode(get_option('banner_list')); ?>
    <div class="wrap">
        <h1>Настройки главной страницы</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('home_settings');
            ?>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="ids_slider">ID для слайдера</label>
                    </th>
                    <td>
                        <input name="ids_slider" type="text" id="ids_slider" class="regular-text" placeholder="32, 45, 67, 89" value="<?= get_option('ids_slider') ?>">
                        <p class="description" id="ids_slider">ID товаров для слайдера через запятую</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        Сайт в разработке
                    </th>
                    <td>
                        <label for="is_show_develop">
                            <input name="is_show_develop" type="checkbox" id="is_show_develop" <?= get_option('is_show_develop') ? "checked" : "" ?> value="1">
                            Вывести предупреждение
                        </label>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        Показывать баннер
                    </th>
                    <td>
                        <label for="is_show_banner">
                            <input name="is_show_banner" type="checkbox" id="is_show_banner" <?= get_option('is_show_banner') ? "checked" : "" ?> value="1">
                            Показывать баннер в каталоге
                        </label>
                    </td>
                </tr>
                <tr>
                    <th class="row">
                        <label>Изображения для баннеров (размер кратный 500х420 px)</label>
                    </th>
                    <td>
                        <?php if (count($banner_ids)): ?>
                        <a id="select-image" href="#">Добавить изображения</a>
                        <?php else: ?>
                        <a id="select-image" href="#">Выбрать изображения</a>
                        <?php endif; ?>
                        <input type="hidden" name="banner_list" value="<?= get_option('banner_list') ?>">
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <ul class="banner_images">
                            <?php foreach ($banner_ids as $id): ?>
                            <li class="image" data-attachment_id="<?= $id ?>">
                                <img src="<?= wp_get_attachment_image_url($id, 'thumbnail') ?>">
                                <div class="close-icon"><i class="las la-times"></i></div>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            </table>
            <?php
            submit_button();
            ?>
        </form>
    </div>
<?php }
