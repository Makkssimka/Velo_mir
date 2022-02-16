<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Importer
 * @subpackage Importer/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Importer
 * @subpackage Importer/admin
 * @author     Makkssimka
 */
class Importer_Admin {

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
	 * @param      string    $importer       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	public function __construct( $importer, $version ) {

		$this->importer = $importer;
		$this->version = $version;

        add_action( 'wp_ajax_sku_generated', array($this, "sku_ajax_request"));
        add_action( 'wp_ajax_importer_unzip', array($this, "importer_ajax_unzip"));
        add_action( 'wp_ajax_importer_category_data', array($this, "importer_ajax_category_data"));
        add_action( 'wp_ajax_importer_category_migrate', array($this, "importer_ajax_category_migrate"));
        add_action( 'wp_ajax_importer_data', array($this, "importer_ajax_data"));
        add_action( 'wp_ajax_importer_csv', array($this, "importer_ajax_csv"));
        add_action( 'wp_ajax_importer_migrate', array($this, "importer_ajax_migrate"));
        add_action( 'wp_ajax_importer_categories', array($this, "importer_ajax_categories"));
        add_action( 'wp_ajax_importer_clean', array($this, "importer_ajax_clean"));
        add_action( 'wp_ajax_importer_logs', array($this, "importer_ajax_logs"));
        add_action( 'wp_ajax_importer_products_data', array($this, "importer_ajax_products_data"));
        add_action( 'wp_ajax_importer_import_data', array($this, "importer_ajax_import_data"));
        add_action( 'wp_ajax_importer_cleaner', array($this, "importer_ajax_cleaner"));

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
		 * defined in Importer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Importer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->importer, plugin_dir_url( __FILE__ ) . 'css/importer-admin.css', array(), $this->version, 'all' );

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
		 * defined in Importer_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Importer_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->importer, plugin_dir_url( __FILE__ ) . 'js/importer-admin.js', array( 'jquery' ), $this->version, false );

	}

    public function importer_menu() {
        add_menu_page("Импорт 1С", "Импорт 1С", "manage_options", "import-1c", null, 'dashicons-download', 58);

        //create submenu
        add_submenu_page("import-1c", "Ручное обновление", "Ручное обновление", "manage_options", "import-1c", array($this, "import_update"));
        add_submenu_page("import-1c", "Импорт категорий", "Импорт категорий", "manage_options", "import-categories", array($this, "import_categories"));
        add_submenu_page("import-1c", "Очистка базы", "Очистка базы", "manage_options", "clean_base", array($this, "clean_base"));
        add_submenu_page("import-1c", "Логи импорта", "Логи импорта", "manage_options", "import-log", array($this, "import_log"));
        add_submenu_page("import-1c", "Генератор артикула", "Генератор артикула", "manage_options", "import_sku", array($this, "import_sku"));
    }

    public function import_update() {

        //template include
        ob_start();
        include_once(IMPORTER_PLUGIN_PATH."admin/partials/importer-update-template.php");
        $template = ob_get_contents();
        ob_end_clean();

        echo $template;
    }

    public function import_categories() {

        $importer = new IM_FilesImport();
        $importer->unzip();

	    $importer = new IM_CategoriesImport();
	    $importer->run();

	    $categories = $importer->getCategories();
	    $site_categories = IM_CategoriesImport::getSiteCategories();

        ob_start();
        include_once(IMPORTER_PLUGIN_PATH."admin/partials/importer-category-template.php");
        $template = ob_get_contents();
        ob_end_clean();

        echo $template;
    }

    public function clean_base() {

        ob_start();
        include_once(IMPORTER_PLUGIN_PATH."admin/partials/importer-clean-base-template.php");
        $template = ob_get_contents();
        ob_end_clean();

        echo $template;
    }

        public function import_log() {

        //run action
        if (isset($_GET['action'])) {
            $action = new Importer_Action($_GET['action']);
            $action->run_action();
        }

        $log = new LogImporter();
        $file_path = $log->get_path();
        $file_url = $log->get_url();
        $file_data = $log->get_value();

        //template include
        ob_start();
        include_once(IMPORTER_PLUGIN_PATH."admin/partials/importer-log-template.php");
        $template = ob_get_contents();
        ob_end_clean();

        echo $template;
    }

    public function import_sku() {

	    $products_not_sku_counter = SkuImporter::getProductNotSku();

        //template include
        ob_start();
        include_once(IMPORTER_PLUGIN_PATH."admin/partials/importer-sku-template.php");
        $template = ob_get_contents();
        ob_end_clean();

        echo $template;

    }

    //ajax add call request
    public function sku_ajax_request()
    {
        $products = wc_get_products(array(
            'limit'  => -1,
            'meta_key' => '_sku',
            'meta_value' => 'undefined'
        ));

        $sku_count = 0;

        $skuGenerater = new IM_Sku();
        foreach ($products as $product) {
            $sku_count++;
            $sku = $skuGenerater->getGeneratedSku();
            $product->set_sku($sku);
            $product->save();
        }
        $skuGenerater->setSkuConfig();

        echo json_encode($sku_count);
        wp_die();
    }


    // ajax import product
    public function importer_ajax_unzip()
    {
        $importer = new IM_FilesImport();
        $importer->unzip();

        $result = array(
            'status' => 2
        );
        echo json_encode($result);
        wp_die();
    }

    public function importer_ajax_category_data()
    {
        $category = new IM_CategoriesImport();
        $category->runAjax();

        $result = array(
            'status' => 2,
            'data' => $category->getCategoriesAjax()
        );
        echo json_encode($result);
        wp_die();
    }

    public function importer_ajax_category_migrate()
    {
        $categories = $_REQUEST['categories'];
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

        $result = array(
            'status' => 2,
            'data' => $counter,
        );

        echo json_encode($result);
        wp_die();
    }

    public function importer_ajax_data()
    {
        $importer = new IM_FilesImport();
        $data = $importer->getData();


        $result = array(
            'status' => 2,
            'data' => $data
        );

        echo json_encode($result);
        wp_die();
    }

    public function importer_ajax_migrate()
    {
        $products = $_REQUEST['products'];
        $counter = count($products);

        foreach ($products as $item) {
            $id = $item['id'];
            $name = $item['name'];
            $price = $item['price'];
            $quantity = $item['quantity'];
            $category = IM_Helper::getSiteCategoryId($item['category']);
            $description = $item['description'];
            $image = $item['image'];
            $properties = $item['properties'];


            $product = new IM_Product();

            if ($properties) {
                $product->createAndAddProperties($properties);
            }

            $product->setId($id);
            $product->setName($name);
            $product->setPrice($price);
            $product->setQuantity($quantity);
            $product->setCategoryId($category);
            $product->setDescription($description);
            $product->setImagePath($image);

            $product->save();
        }

        $result = array(
            'status' => 2,
            'data' => $counter,
        );

        echo json_encode($result);
        wp_die();
    }

    public function importer_ajax_csv()
    {
        $products = $_REQUEST['products'];

        $csv_generator = new IM_CSVImport();
        $csv_generator->createHeader();

        foreach ($products as $product) {
            $csv_generator->addRowProduct($product);
        }

        $csv_generator->close();


        $result = array(
            'status' => 2,
            'data' => count($products)
        );
        echo json_encode($result);
        wp_die();
    }

    public function importer_ajax_clean()
    {
        $importer = new IM_FilesImport();
        $importer->cleanDataFolders();

        $result = array(
            'status' => 2
        );
        echo json_encode($result);
        wp_die();
    }

    public function importer_ajax_logs()
    {
        $counter = $_REQUEST['counter'];
        $log = new LogImporter();
        $log->write('Произведен ручной импорт. Обновлено и добавлено ' . $counter .' товаров');

        $result = array(
            'status' => 2
        );
        echo json_encode($result);
        wp_die();
    }

    // ajax import categories
    public function importer_ajax_categories()
    {
        $data = $_POST['data'];

        foreach ($data as $item) {
            $category = new IM_Category();
            $category->setId($item['id']);
            $category->setName($item['name']);
            $category->setParent($item['parent']);
            $category->save();
        }

        echo json_encode($data);
        wp_die();
    }

    public function importer_ajax_products_data()
    {
        $cleaner = new IM_Clean();

        $result = array(
            'status' => 2,
            'data' => $cleaner->getSiteProductsData()
        );

        echo json_encode($result);
        wp_die();
    }

    public function importer_ajax_import_data()
    {
        $cleaner = new IM_Clean();

        $result = array(
            'status' => 2,
            'data' => $cleaner->getImportProductsData()
        );

        echo json_encode($result);
        wp_die();
    }

    public function importer_ajax_cleaner()
    {
        $products = $_POST['products'];
        $cleaner = new IM_Clean();

        foreach ($products as $product) {
            $cleaner->removeProduct($product);
        }

        $result = array(
            'status' => 2,
            'data' => count($products)
        );

        echo json_encode($result);
        wp_die();
    }

}
