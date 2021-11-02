<?php

class Call_Form_Action{

    private $action_name = '';
    private $table_name = CALL_FORM_TABLE_NAME;

    public function __construct($action_name){
        $this->action_name = $action_name;
        $this->set_name();
    }

    public function set_name(){
        $action_array = explode("-", $this->action_name);
        foreach ($action_array as $key => $value) {
            $action_array[$key] = ucfirst($value);
        }
        $this->action_name = "action".implode("", $action_array);
    }

    public function run_action(){
        $action = $this->action_name;
        $this->$action();
    }

    private function redirect($page_name){
        wp_redirect(admin_url("admin.php?page=$page_name"));
    }

    public function actionCallDelete(){
        global $wpdb;
        $id = $_GET['id'];

        $wpdb->query("DELETE FROM {$this->table_name} WHERE `id` = $id");

        $this->redirect("call-form");
        wp_die();
    }

    public function actionCallsDelete(){
        global $wpdb;
        $calls = implode(",", $_GET['call']);

        $wpdb->query("DELETE FROM {$this->table_name} WHERE `id` IN($calls)");

        $this->redirect("call-form");
        wp_die();
    }

    public function actionCallChangeStatus(){
        global $wpdb;
        $id = $_GET['id'];

        $status = $wpdb->get_var("SELECT `status` FROM {$this->table_name} WHERE id = $id")? 0 : 1;
        $time = date('Y-m-d H:i:s');

        if ($status) {
            $wpdb->query("UPDATE {$this->table_name} SET `status` = $status, `processed_at` = '$time' WHERE `id` = $id");
        } else {
            $wpdb->query("UPDATE {$this->table_name} SET `status` = $status, `processed_at` = NULL WHERE `id` = $id");
        }

        $this->redirect("call-form");
        wp_die();
    }

    public function actionCallsChangeStatus(){
        global $wpdb;
        $calls = implode(",", $_GET['call']);

        $time = date('Y-m-d H:i:s');

        $wpdb->query("UPDATE {$this->table_name} SET `status` = 1, `processed_at` = '$time' WHERE `id` IN($calls)");

        $this->redirect("call-form");
        wp_die();
    }

}