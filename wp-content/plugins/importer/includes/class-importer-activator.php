<?php

/**
 * Fired during plugin activation
 *
 * @since      1.0.0
 *
 * @package    Importer
 * @subpackage Importer/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Importer
 * @subpackage Importer/includes
 * @author     Makkssimka
 */
class Importer_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        $upload_dir = wp_upload_dir();
        $upload_basedir = $upload_dir['basedir'];

        if (!is_dir($upload_basedir."/importer-logs")) {
            mkdir($upload_basedir."/importer-logs", 0777);
        }

	    $file_path = $upload_basedir."/importer-logs/importer_log.txt";
        file_put_contents($file_path, '');
	}

}
