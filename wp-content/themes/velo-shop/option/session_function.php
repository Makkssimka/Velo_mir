<?php

function myStartSession() {
    if (!session_id()) {
        ini_set('session.gc_maxlifetime', 60*60*24*7);
        ini_set('session.cookie_lifetime', 0);
        session_set_cookie_params(0);
        session_start();
    }
}

add_action('init', 'myStartSession', 1);

//Сброс сессий
function myResetSession() {
    if (isset($_GET['session_reset'])) {
        $url = get_current_url();
        unset($_SESSION['filter']);
        wp_redirect($url);
        die();
    }
}
add_action('init', 'myResetSession', 1);

//Установка сесий фильтра
function filterAddSession() {
    if (isset($_GET['session_filter'])) {
        myCleanFilter();
        $data = get_url_data();
        $filter_array = array();
        foreach ($data as $data_key => $data_value) {
            $filter_array[$data_key] = $data_value;
        }
        $_SESSION['filter'] = json_encode($filter_array);
        $url = get_current_url();
        wp_redirect($url);
        die();
    }
}
add_action('init', 'filterAddSession', 1);

function myCleanFilter(){
    if(isset($_SESSION['filter'])) {
        unset($_SESSION['filter']);
    }
}

//Установка сесии сортировки
function sortAddSession(){
    $sort = isset($_GET['session_sort']) ? $_GET['session_sort'] : '';

    if ($sort) {
        $_SESSION['sort'] = $sort;
        $url = get_current_url();
        wp_redirect($url);
        die();
    }

}
add_action('init', 'sortAddSession', 1);


//Регистрация дополнительных запросов
require_once "wc_custom_query.php";

//Удаляем из сравнения
function compareRemove(){
    if (isset($_GET['compare_remove'])) {
        $id = $_GET['id'];

        $compare_array = isset($_SESSION['compare'])?json_decode($_SESSION['compare']):array();
        $index = array_search($id, $compare_array);
        array_splice($compare_array, $index, 1);

        $_SESSION['compare'] = json_encode($compare_array);

        $url = get_current_url();
        wp_redirect($url);
        die();
    }
}

add_action('init', 'compareRemove', 1);