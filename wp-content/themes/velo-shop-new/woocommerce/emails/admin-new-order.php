<?php
/**
 * Admin new order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/admin-new-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates\Emails\HTML
 * @version 3.7.0
 */

defined( 'ABSPATH' ) || exit;

?>

<style>
    .email-header__logo{
        text-transform: uppercase;
        font-size: 2rem;
        text-align: center;
    }
    .email-header__logo a{
        color: #212529;
        text-decoration: none;
        font-weight: normal;
    }
    .email-header__logo span{
        font-weight: bold;
    }
    .email-head__head {
        font-size: 1.6rem;
        color: #212529;
        text-align: center;
    }
    .email-head p{
        font-size: 1.2rem;
        color: #6c757d;
        margin: 0;
        padding: 3px 0;
    }
    .email-head a, .email-head span{
        color: #609abd
    }
    .email-body{
        margin-top: 30px;
    }
    .email-body table{
        width: 100%;
    }
    .email-body th{
        text-transform: uppercase;
    }
    .email-body tr{
        border: 1px solid #000;
    }
    .email-body__table-row p{
        color: #609abd;
        font-size: 0.8rem;
        margin: 5px 0 0;
    }
    .email-footer{
        text-align: center;
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 30px;
    }
</style>
<body body style="width:100%;font-family:roboto, 'helvetica neue', helvetica, arial, sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;padding:0;Margin:0">
<div class="wrapper-email" style="max-width: 600px; margin: 0 auto; padding: 15px;">
    <div class="email-header">
        <div class="email-header__logo">
            <a href="https://velomir34.ru">
                <span>Веломир</span>34
            </a>
        </div>
    </div>
    <div class="email-head">
        <div class="email-head__head">Новый заказ №<?= $order->get_order_number() ?></div>
        <section>
            <p>У вас новый заказ на сайте!</p>
            <p>Заказчик: <span><?= $order->get_billing_first_name() ?> <?= $order->get_billing_last_name() ?></span></p>
            <p>Телефон: <a href="tel:<?= $order->get_billing_phone() ?>"><?= $order->get_billing_phone() ?></a></p>
            <p>Эл. почта: <a href="<?= $order->get_billing_email() ?>"><?= $order->get_billing_email() ?></a></p>
        </section>
    </div>
    <div class="email-body">
        <table>
            <tr>
                <th>Товар</th>
                <th>Кол-во</th>
                <th>Цена</th>
            </tr>
            <tr>
                <td class="email-separator" colspan="3">
                    <hr>
                </td>
            </tr>
            <?php foreach ($order->get_items() as $item) : ?>
                <?php $product = wc_get_product($item['product_id']) ?>
                <tr class="email-body__table-row">
                    <td>
                        <?= $item['name'] ?>
                        <p>#<?= $product->get_sku() ?></p>
                        <p>id 1C: <?= get_post_field('post_content_filtered', $product->get_id()) ?></p>
                    </td>
                    <td style="text-align: center;"><?= $item['quantity'] ?></td>
                    <td style="text-align: center;"><?= wc_price($item['subtotal']) ?></td>
                </tr>
                <tr>
                    <td class="email-separator" colspan="3">
                        <hr>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td>Подытог:</td>
                <td style="text-align: center; font-weight: bold;"><?= wc_price($order->get_subtotal()) ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Скидка:</td>
                <td style="text-align: center; font-weight: bold;"><?= wc_price($order->get_discount_total()) ?></td>
            </tr>
            <tr>
                <td></td>
                <td>Итог:</td>
                <td style="text-align: center; font-weight: bold;"><?= wc_price($order->get_total()) ?></td>
            </tr>
        </table>
    </div>
    <div class="email-footer">
        <p>Веломир 34 - продажа и обслуживание велосипедов в Волгограде</p>
    </div>
</div>
</body>