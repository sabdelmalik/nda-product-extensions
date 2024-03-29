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
class Nda_Product_Extensions_Public {
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
    require_once NDA_PRODUCT_EXTENSIONS_PUBLIC_DIR.'front_end/class-nda-product-extensions-hide-price.php';
    require_once NDA_PRODUCT_EXTENSIONS_PUBLIC_DIR.'front_end/class-nda-product-extensions-request-quote.php';
    require_once NDA_PRODUCT_EXTENSIONS_PUBLIC_DIR.'front_end/class-nda-product-extensions-min-max-qty.php';
  }

  /**
	 * Register all of the hooks related to this class' functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
  private function define_hooks() {
		$this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_scripts' );
	
    $this->loader->add_action( 'template_redirect', $this, 'nda_template_redirect_for_single_product' );
  }

  /**
	 * Instantiate admin classes
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function instantiate_public_classes() {
    new Nda_Product_Extensions_Hide_Price($this->plugin_name, $this->version, $this->loader);
    new Nda_Product_Extensions_Request_Quote($this->plugin_name, $this->version, $this->loader);
    new Nda_Product_Extensions_MIN_MAX_QTY($this->plugin_name, $this->version, $this->loader);
  }

  function nda_template_redirect_for_single_product() {
    global $wp_query;

    // Redirect to the product page if we have a single product
    if ( is_product_category() && 1 === $wp_query->found_posts ) {
        $product = wc_get_product( $wp_query->post );
        if ( $product && $product->is_visible() ) {
            wp_safe_redirect( get_permalink( $product->id ), 302 );
            exit;
        }
    }

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
		 * defined in Nda_Product_Extensions_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nda_Product_Extensions_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/nda-product-extensions-public.css', array(), $this->version, 'all' );

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
		 * defined in Nda_Product_Extensions_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Nda_Product_Extensions_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/nda-product-extensions-public.js', array( 'jquery' ), $this->version, false );

	}

}
