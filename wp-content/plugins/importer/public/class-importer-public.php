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
     * Api key for the app
     *
     * @var string
     */
    private $api_key = '$2y$12$YOIEgLfL5jXoewLDR24Tj.3F/h3ksZ6sAH1f/6cERno10AYKNoZxi';

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

        add_action( 'init', array($this, "router") );

        add_action( 'rest_api_init', function () {
            register_rest_route( 'importer/v1', '/unzip', array(
                'methods' => 'POST',
                'callback' => array($this, 'unzip_callback'),
                'permission_callback' => __return_false()
            ));
            register_rest_route( 'importer/v1', '/categories-data', array(
                'methods' => 'POST',
                'callback' => array($this, 'categories_data_callback'),
                'permission_callback' => __return_false()
            ));
            register_rest_route( 'importer/v1', '/categories-import', array(
                'methods' => 'POST',
                'callback' => array($this, 'categories_import_callback'),
                'permission_callback' => __return_false()
            ));
            register_rest_route( 'importer/v1', '/products-data', array(
                'methods' => 'POST',
                'callback' => array($this, 'products_data_callback'),
                'permission_callback' => __return_false()
            ));
            register_rest_route( 'importer/v1', '/products-import', array(
                'methods' => 'POST',
                'callback' => array($this, 'products_import_callback'),
                'permission_callback' => __return_false()
            ));
            register_rest_route( 'importer/v1', '/clean-import', array(
                'methods' => 'POST',
                'callback' => array($this, 'clean_import_callback'),
                'permission_callback' => __return_false()
            ));
        });
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

    public function router()
    {
        $url = parse_url($_SERVER['REQUEST_URI']);
        $path = $url['path'];

        $get = [];
        if (isset($url['query'])) {
            parse_str($url['query'], $get);
        }

        $post = $_POST;

        $request = array_merge($get, $post);

        switch ($path) {
            case "/importer/loader":
                $this->load_price($request);
                break;
            case "/importer/auto-update":
                $this->auto_update();
                break;
            case "/importer/update-step":
                $this->update_step($request);
                break;
        }
    }

    public function load_price($request){

        $archive_dir = IMPORTER_PLUGIN_PATH."upload/archives/";

        $mode = $request['mode'];

        $log = new LogImporter();

        if ($mode == 'checkauth') {
            $val = md5(time());
            setcookie('hash', $val);
            echo "success\n";
            echo "hash\n";
            echo "$val\n";
        } elseif ($mode == 'init') {
            echo "zip=yes\n";
            echo "file_limit=204800\n";
        } elseif ($mode == 'file') {
            $filename = $_GET['filename'];
            $log->write($filename);
            $data = file_get_contents("php://input");
            file_put_contents($archive_dir.$filename ,$data, FILE_APPEND);
            echo "success";
        } elseif ($mode == 'import') {
            echo "success";
        }

        die();
    }

    public function unzip_callback($data) {
        $importer = new IM_FilesImport();
        $steps = $importer->unzip();

        return [
            'steps' => $steps,
            'key' => $data['api_key']
        ];
    }

    public function categories_data_callback($data) {
        $counter = $data['counter'];

        $category = new IM_CategoriesImport($counter);
        $category->runAjax();

        return [
            'categories' => $category->getCategoriesAjax()
        ];
    }

    public function categories_import_callback($data) {
        $categories = $data['categories'];
        $counter = count($categories);

        foreach ($categories as $item) {
            $id = $item['id'];
            $name = $item['name'];
            $parent = $item['parent'];

            $category = new IM_Category();
            $category->setId($id);
            $category->setName($name);
            $category->setParent($parent);
            $category->save();
        }

        return [
            'counter' => $counter
        ];
    }

    public function products_data_callback($data) {
        $counter = $data['counter'];
        $importer = new IM_FilesImport($counter);
        $data = $importer->getData();

        return [
            'products' => $data
        ];
    }

    public function products_import_callback($data) {
        $products = $data['products'];
        $counter = count($products);

        foreach ($products as $item) {
            $id = $item['id'];
            $name = $item['name'];
            $sku = $item['sku'];
            $price = $item['price'];
            $quantity = $item['quantity'];
            $category = IM_Helper::getSiteCategoryId($item['category']);
            $description = $item['description'];
            $images = key_exists('images', $item) ? $item['images'] : [];
            $properties = $item['properties'];
            $tags = key_exists('tags', $item) ? $item['tags']: [];
            $storages = $item['storages'];


            $product = new IM_Product();

            if ($properties) {
                $product->createAndAddProperties($properties);
            }

            $product->setId($id);
            $product->setName($name);
            $product->setSku($sku);
            $product->setPrice($price);
            $product->setQuantity($quantity);
            $product->setCategoryId($category);
            $product->setDescription($description);
            $product->setImages($images);
            $product->setTags($tags);
            $product->setStorages($storages);

            $product->save();
        }

        return [
            'counter' => $counter
        ];
    }

    public function clean_import_callback() {
        $importer = new IM_FilesImport();
        $importer->cleanDataFolders();

        return true;
    }
}
