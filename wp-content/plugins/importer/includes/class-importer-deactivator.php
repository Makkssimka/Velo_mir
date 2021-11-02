<?php

/**
 * Fired during plugin deactivation
 *
 * @since      1.0.0
 *
 * @package    Importer
 * @subpackage Importer/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Importer
 * @subpackage Importer/includes
 * @author     Makkssimka
 */
class Importer_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        $upload_dir = wp_upload_dir();
        $upload_basedir = $upload_dir['basedir'];
        $file_path = $upload_basedir."/importer-logs/importer_log.txt";

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        if (is_dir($upload_basedir."/importer-logs")) {
            rmdir($upload_basedir."/importer-logs");
        }
	}

}
