<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Importer
 * @subpackage Importer/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Importer
 * @subpackage Importer/public
 * @author     Makkssimka
 */
class Importer_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $importer    The ID of this plugin.
	 */
	private $importer;

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
	 * @param      string    $importer       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $importer, $version ) {

		$this->importer = $importer;
		$this->version = $version;

        add_action( 'init', array($this, "load_price") );

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
		 * defined in Importer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Importer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->importer, plugin_dir_url( __FILE__ ) . 'css/importer-public.css', array(), $this->version, 'all' );

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
		 * defined in Importer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Importer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->importer, plugin_dir_url( __FILE__ ) . 'js/importer-public.js', array( 'jquery' ), $this->version, false );

	}

    public function load_price(){
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('?', $url);
        $url = $url[0];

        if ($url != "/importer/loader") return;

        $archive_dir = IMPORTER_PLUGIN_PATH."upload/archives/";

        $log = new LogImporter();

        $mode = $_REQUEST['mode'];
        $hash = isset($_REQUEST['sessid']);

        $log->write('Выгрузка архивов с сервера '.json_encode($_REQUEST));

        if ($mode == 'checkauth') {

            if (!$hash) {
                IM_FilesImport::cleanDir($archive_dir);
            }

            $val = md5(time());
            setcookie('hash', $val);
            echo "success\n";
            echo "hash\n";
            echo "$val\n";

        } elseif ($mode == 'init') {
            echo "zip=yes\n";
            echo "file_limit=52428800\n";

        } elseif ($mode == 'file') {
            $filename = $_GET['filename'];
            $data = file_get_contents("php://input");
            file_put_contents($archive_dir.$filename ,$data, FILE_APPEND);
            echo "success";

        } elseif ($mode == 'import') {
            echo "success";
        }

        die();
    }

}
