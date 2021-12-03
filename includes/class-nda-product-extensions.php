<?php
namespace NDA_PRODUCT_EXTENSIONS;
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       nda.ca
 * @since      1.0.0
 *
 * @package    Nda_Product_Extensions
 * @subpackage Nda_Product_Extensions/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Nda_Product_Extensions
 * @subpackage Nda_Product_Extensions/includes
 * @author     Sami Abdel Malik <sami.malik@sympatico.ca>
 */
class Nda_Product_Extensions {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Nda_Product_Extensions_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'NDA_PRODUCT_EXTENSIONS_VERSION' ) ) {
			$this->version = NDA_PRODUCT_EXTENSIONS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = NDA_PRODUCT_EXTENSIONS_SLUG;

		$this->load_dependencies();
		$this->instantiate_classes();
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Nda_Product_Extensions_Loader. Orchestrates the hooks of the plugin.
	 * - Nda_Product_Extensions_i18n. Defines internationalization functionality.
	 * - Nda_Product_Extensions_Admin. Defines all hooks for the admin area.
	 * - Nda_Product_Extensions_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

    require_once NDA_PRODUCT_EXTENSIONS_INC_DIR . 'functions.php';
		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once NDA_PRODUCT_EXTENSIONS_INC_DIR . 'class-nda-product-extensions-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once NDA_PRODUCT_EXTENSIONS_INC_DIR . 'class-nda-product-extensions-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once NDA_PRODUCT_EXTENSIONS_ADMIN_DIR . 'class-nda-product-extensions-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once NDA_PRODUCT_EXTENSIONS_PUBLIC_DIR . 'class-nda-product-extensions-public.php';

		$this->loader = new Nda_Product_Extensions_Loader();

	}

    /**
	 * Instantiate the main classes for this plugin
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function instantiate_classes() {
    
    // Locale for this plugin internationalization
    new Nda_Product_Extensions_i18n($this->loader);

    // Main admin class
		new Nda_Product_Extensions_Admin( $this->get_plugin_name(), $this->get_version(), $this->loader);
    
    // Main public class
    new Nda_Product_Extensions_Public( $this->get_plugin_name(), $this->get_version(), $this->loader );
  }

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Nda_Product_Extensions_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
