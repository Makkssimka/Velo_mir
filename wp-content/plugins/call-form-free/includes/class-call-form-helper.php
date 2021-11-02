<?php

class Call_Form_Helper{

    public static function getTemplate(){

    }

    public static function getElemNum($count){
        $titles = array('елемент', 'елемента', 'елементов');
        $cases = array(2, 0, 1, 1, 1, 2);
        return $titles[($count % 100 > 4 && $count % 100 < 20) ? 2 : $cases[min($count % 10, 5)]];
    }

    public static function counterRound($counter){
        return round($counter, 0, PHP_ROUND_HALF_DOWN);
    }

    public static function getNavUrl($paged){
        $get = $_SERVER['QUERY_STRING'];
        parse_str($get, $query_array);
        $query_array['paged'] = $paged;
        return admin_url("admin.php?".http_build_query($query_array));
    }

    public static function sendEmail($name, $telephone){
        $emails = get_option('emails');
        $subject = "Новая заявка на обратный звонок";

        ob_start();
        require_once "call-form-free-email-layout.php";
        $message = ob_get_clean();

        add_filter('wp_mail_content_type', function( $content_type ) {
            return 'text/html';
        });

        if ($emails) {
            wp_mail($emails, $subject, $message);
        }
    }

    public static function sendTelegram($name, $telephone){
        $telephone = '8'.mb_substr($telephone, 2);
        $token = '1655959307:AAGzDwGYkWVkBGs9-2J_fAr6Q__-IrrUbGM';
        $ids_user = explode(',', get_option('telegram_ids'));
        $message = "<b>Новая заявка на звонок:</b>%0A$name%0A<a href='tel:$telephone'>$telephone</a>";
        $mode = "html";

        foreach ($ids_user as $id_user) {
            $id_user = trim($id_user);
            file_get_contents("https://api.telegram.org/bot$token/sendMessage?chat_id=$id_user&text=$message&parse_mode=$mode");
        }
    }

}