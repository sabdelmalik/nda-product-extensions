<?php
namespace NDA_PRODUCT_EXTENSIONS;
/**
 * The public-facing functionality of the plugin.
 *
 * @link       nda.ca
 * @since      1.0.0
 *
 * @package    Nda_Product_Extensions
 * @subpackage Nda_Product_Extensions/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Nda_Product_Extensions
 * @subpackage Nda_Product_Extensions/public
 * @author     Sami Abdel Malik <sami.malik@sympatico.ca>
 */
class Nda_Product_Extensions_Hide_Price {
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
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $loader ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
    $this->loader = $loader;

    $this->load_dependencies();
    $this->define_hooks();

    $this->instantiate_public_classes();
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
    $this->loader->add_filter( 'woocommerce_get_price_html', $this, 'nda_process_price_restrictions', 10, 2 ); 
  }

  /**
	 * Instantiate public classes
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function instantiate_public_classes() {
    
  }


  function nda_process_price_restrictions( $price, $product ) {
    $price_restriction = get_post_meta($product->get_id(), '_nda_product_price_display_restriction');
    if(is_array($price_restriction))
    {
      $price_restriction = $price_restriction[0];
    }
    if($price_restriction == 'no_display'){
      return;
    }
    else if(($price_restriction == 'logged_in_users') && !is_user_logged_in()){
      $result = '<span> Please login to see the price.</span>';
      return $result;
    }
    return $price; // Return price for the all the other products
  }


}
