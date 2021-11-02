<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Call_Form_Free
 * @subpackage Call_Form_Free/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Call_Form_Free
 * @subpackage Call_Form_Free/includes
 * @author     Your Name <email@example.com>
 */
class Call_Form_Free_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function deactivate() {

        //dynamic drop table code...
        global $wpdb;
        $table_name = CALL_FORM_TABLE_NAME;

        $wpdb->query("DROP TABLE IF EXISTS $table_name");
	}

}
