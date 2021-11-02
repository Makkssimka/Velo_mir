<?php

// Получаем все характеристики продукта и исключаем без значения
$table_array = array();
$description = $product->get_description();

foreach (explode(PHP_EOL, $description) as $item_description) {
    $item_description = explode(':', $item_description);
    $table_array[] = array(
        'name' => trim($item_description[0]),
        'value' => isset($item_description[1]) ? trim($item_description[1]) : ''
    );
}

?>

<div class="product-tabs">
    <div class="product-tabs-header">
        <ul>
            <li data-tab="1" class="active"><a href="#">
                    <i class="las la-list"></i> Характеристики
                </a></li>
            <li data-tab="2"><a href="#">
                    <i class="las la-file-alt"></i> Описание
                </a></li>
            <li data-tab="3"><a href="#">
                    <i class="las la-film"></i> Видеообзор
                </a></li>
        </ul>
    </div>
    <div class="product-tabs-body">
        <ul>
            <li data-tabcontent="1" class="active">
                <table class="product-tabs-table">
                    <tbody>
                    <?php if ($description) : ?>
                        <?php foreach ($table_array as $desc_item): ?>
                        <?php if ($desc_item['value']) : ?>
                            <tr>
                                <td><?= $desc_item['name'] ?>:</td>
                                <td><?= $desc_item['value'] ?></td>
                            </tr>
                        <?php else : ?>
                            <tr>
                                <th class="product-tabs-table-up" colspan="2"><?= $desc_item['name'] ?></th>
                            </tr>
                        <?php endif ?>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="product-tabs-empty">Харарактеристики пока не добавлены на сайт</p>
                    <?php endif ?>
                    </tbody>
                </table>
            </li>
            <li data-tabcontent="2">
                <?php if ($product->get_short_description()) : ?>
                    <?= $product->get_short_description(); ?>
                <?php else : ?>
                    <p class="product-tabs-empty">Описание пока не добавлено на сайт</p>
                <?php endif ?>
            </li>
            <li data-tabcontent="3" class="product-tabs-video">
                <?php if ($product->get_meta('youtube_link', true)) : ?>
                <iframe src="<?= $product->get_meta('youtube_link', true); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                <?php else : ?>
                <p class="product-tabs-empty">Видео-обзор пока не добавлен на сайт</p>
                <?php endif ?>
            </li>
        </ul>
    </div>
</div>