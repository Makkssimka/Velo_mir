<?php

class Importer_Action{
    private $action_name = '';

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

    private function actionClearLogs(){
        $upload_dir = wp_upload_dir();
        $upload_basedir = $upload_dir['basedir'];
        $file_path = $upload_basedir."/importer-logs/importer_log.txt";
        file_put_contents($file_path, "");

        $this->redirect("import-log");
    }

    private function actionTestImport(){
        $log = new LogImporter();
        $log->write("Проверены изменения импорта");
    }

    private function actionUpdateImport(){
        $log = new LogImporter();
        $log->write("Произведен ручной импорт");
    }
}