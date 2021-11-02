<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Call_Form_Free
 * @subpackage Call_Form_Free/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Call_Form_Free
 * @subpackage Call_Form_Free/admin
 * @author     Your Name <email@example.com>
 */
class Call_Form_Free_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $call_form_free    The ID of this plugin.
	 */
	private $call_form_free;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $call_form_free       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $call_form_free, $version ) {

		$this->call_form_free = $call_form_free;
		$this->version = $version;

        add_action('admin_init', array($this, 'register_call_form_settings'));

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Call_Form_Free_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Call_Form_Free_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->call_form_free, plugin_dir_url( __FILE__ ) . 'css/call-form-free-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Call_Form_Free_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Call_Form_Free_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->call_form_free, plugin_dir_url( __FILE__ ) . 'js/call-form-free-admin.js', array( 'jquery' ), $this->version, false );

	}

	//create menu method
    public function call_form_free_menu() {

        add_menu_page("Обратные звонки", "Звонки", "manage_options", "call-form", null, 'dashicons-phone', 58);

        //create submenu
        add_submenu_page("call-form", "Менеджер звонков", "Менеджер звонков", "manage_options", "call-form", array($this, "call_form_menage"));
        add_submenu_page("call-form", "Настройки для обратных звонков", "Настройки", "manage_options", "call-form-settings", array($this, "call_form_settings"));
    }

    //create menage_call_form page
    public function call_form_menage() {

	    //run action
	    include_once(CALL_FORM_PLUGIN_PATH."admin/class_call_form_action.php");
	    if (isset($_GET['action'])) {
	        $action = new Call_Form_Action($_GET['action']);
	        $action->run_action();
        }

	    global $wpdb;
        $table_name = CALL_FORM_TABLE_NAME;

        //varible
        $call_per_page = 20;
        $call_page = isset($_GET['paged']) ? $_GET['paged'] : 1;
        $call_offset = ($call_page-1)*$call_per_page;


        //get calls list
        $order_by = isset($_GET['orderby']) ? $_GET['orderby'] : 'created_at';
        $order = isset($_GET['order']) ? $_GET['order'] : 'desc';
        $new_order = $order == 'asc' ? 'desc' : 'asc';

        //query call list
	    $call_list = $wpdb->get_results("SELECT * FROM `$table_name` ORDER BY `$order_by` $order LIMIT $call_offset, $call_per_page");

	    //counter calls
	    $all_count = $wpdb->get_var("SELECT COUNT(`name`) FROM $table_name");
	    $not_processed = $wpdb->get_var("SELECT COUNT(`name`) FROM $table_name WHERE `status` = 0");
	    $processed = $all_count - $not_processed;

	    $pages = Call_Form_Helper::counterRound($all_count/$call_per_page);
        $prev_page = $call_page - 1 <= 0 ? 0 : $call_page - 1;
	    $next_page = $call_page + 1 >= $pages ? $pages : $call_page + 1;

	    //template includes
        ob_start();
        include_once(CALL_FORM_PLUGIN_PATH."admin/partials/call-form-table-menu-view.php");
        $menu_table = ob_get_contents();
        ob_end_clean();

        ob_start();
        include_once(CALL_FORM_PLUGIN_PATH."admin/partials/call-form-menu-view.php");
        $menu = ob_get_contents();
        ob_end_clean();

	    ob_start();
	    include_once(CALL_FORM_PLUGIN_PATH."admin/partials/call-form-table-view.php");
	    $template = ob_get_contents();
	    ob_end_clean();

	    echo $template;

	}

    //create menage_call_form page
    public function call_form_settings() {

	    //template include
        ob_start();
        include_once(CALL_FORM_PLUGIN_PATH."admin/partials/call-form-settings-view.php");
        $template = ob_get_contents();
        ob_end_clean();

        echo $template;
	}

	//settings list
	public function register_call_form_settings(){
        register_setting("call-form-settings", "emails");
        register_setting("call-form-settings", "telegram_ids");
        register_setting("call-form-settings", "call_show");
    }

}
