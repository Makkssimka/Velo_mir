<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Call_Form_Free
 * @subpackage Call_Form_Free/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Call_Form_Free
 * @subpackage Call_Form_Free/public
 * @author     Your Name <email@example.com>
 */
class Call_Form_Free_Public {

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
	 * @param      string    $call_form_free       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $call_form_free, $version ) {

		$this->call_form_free = $call_form_free;
		$this->version = $version;

		add_action('wp_ajax_call_form_add_request', array($this, 'add_request_callback'));
        add_action('wp_ajax_nopriv_call_form_add_request', array($this, 'add_request_callback'));
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->call_form_free, plugin_dir_url( __FILE__ ) . 'css/call-form-free-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->call_form_free, plugin_dir_url( __FILE__ ) . 'js/call-form-free-public.js', array( 'jquery' ), $this->version, false );

	}

	//ajax add call request
    public function add_request_callback(){
        $telephone = filter_input(INPUT_POST,'tel', FILTER_SANITIZE_STRING);
        $name = filter_input(INPUT_POST,'name', FILTER_SANITIZE_STRING);

        global $wpdb;
        $table_name = CALL_FORM_TABLE_NAME;

        $data_array = array(
            'name' => $name,
            'telephone' => $telephone,
            'status' => 0
        );

        $data_type = array('%s', '%s', '%d');

        $result = $wpdb->insert($table_name , $data_array, $data_type);

        if ($result) {
            Call_Form_Helper::sendEmail($name, $telephone);
            Call_Form_Helper::sendTelegram($name, $telephone);
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }

	    wp_die();
    }

}
