<?php


class LogImporter
{
    private $log_path;
    private $log_url;

    public function __construct()
    {
        $upload_dir = wp_upload_dir();
        $upload_basedir = $upload_dir['basedir'];
        $upload_url= $upload_dir['baseurl'];
        $this->log_path = $upload_basedir."/importer-logs/importer_log.txt";
        $this->log_url = $upload_url."/importer-logs/importer_log.txt";
    }

    public function get_path(){
        return $this->log_path;
    }

    public function get_url(){
        return $this->log_url;
    }

    public function get_value(){
        return array_reverse(file($this->log_path));
    }

    public function write($massage){
        $time = date("d-m-Y H:i:s", time());
        $msg = "$time - $massage".PHP_EOL;
        file_put_contents($this->log_path, $msg, FILE_APPEND);
    }
}