<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Call_Form_Free
 * @subpackage Call_Form_Free/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Call_Form_Free
 * @subpackage Call_Form_Free/includes
 * @author     Your Name <email@example.com>
 */
class Call_Form_Free_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {

        //dynamic table generating code...
        global $wpdb;
        $table_name = CALL_FORM_TABLE_NAME;

        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            $table_query = "CREATE TABLE `$table_name` (
                `id` bigint(20) unsigned NOT NULL auto_increment,
                `name` text NOT NULL DEFAULT '',
                `telephone` varchar(25) NOT NULL DEFAULT '',
                `status` int(1) NOT NULL DEFAULT 0,
                `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                `processed_at` timestamp DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) DEFAULT CHARACTER SET {$wpdb->charset} COLLATE {$wpdb->collate}";

            require_once(ABSPATH . "wp-admin/includes/upgrade.php");
            dbDelta($table_query);
        }

	}

}
