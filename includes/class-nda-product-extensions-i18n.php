<?php
namespace NDA_PRODUCT_EXTENSIONS;
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       nda.ca
 * @since      1.0.0
 *
 * @package    Nda_Product_Extensions
 * @subpackage Nda_Product_Extensions/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Nda_Product_Extensions
 * @subpackage Nda_Product_Extensions/includes
 * @author     Sami Abdel Malik <sami.malik@sympatico.ca>
 */
class Nda_Product_Extensions_i18n {
  /**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Nda_Woo_Customiser_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

  /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct(  $loader ) {

    $this->loader = $loader;
    
    $this->load_dependencies();
    $this->define_hooks();
	}

    /**
	 * Load the required dependencies for this class.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {
  }


  /**
	 * Register all of the hooks related to this class' functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
  private function define_hooks() {
		$this->loader->add_action( 'plugins_loaded', $this, 'load_plugin_textdomain' );
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN,
			false,
			NDA_PRODUCT_EXTENSIONS_DIR . '/languages/'
		);

	}



}
