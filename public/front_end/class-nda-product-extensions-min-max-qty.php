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
class Nda_Product_Extensions_MIN_MAX_QTY {
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
    $this->loader->add_filter('woocommerce_product_get_name', $this,'get_product_name');
    $this->loader->add_filter('the_title', $this, 'get_prodct_title', 10, 2);

    $this->loader->add_action( 'woocommerce_quantity_input_args', $this, 'product_quantity_input_args', 10, 2 );
		$this->loader->add_action( 'woocommerce_loop_add_to_cart_args', $this, 'product_quantity_input_args', 10, 2 );
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

  function get_product_name($name){
    global $product;
    if (!isset($product) || !is_object($product)) {
        return;
    }
    if($name == $product->name){
      $post_id = $product->get_id();
      $enable_min = get_post_meta($post_id, '_nda_enable_product_minimum', false);
      if(is_array($enable_min))
      {
        $enable_min = $enable_min[0];
      }

      $min_qty = get_post_meta($post_id, '_nda_product_minimum_qty', false);
      if(is_array($min_qty))
      {
        $min_qty = $min_qty[0];
      }
  //    $enable_max = get_post_meta($post_id, '_nda_enable_product_maximum');
  //    $max_qty = get_post_meta($post_id, '_nda_product_maximum_qty');

      if(($enable_min == 'yes') && ($min_qty > 1)){
        $name = $name . '<br>(minimum order ' . $min_qty . ')';
      }
    }
    return $name;
  }

  function get_prodct_title($title, $id){
    //error_log("---------get_prodct_title - \$title: " . var_export($title,1));
    //error_log("---------get_prodct_title - \$id: " . var_export($id,1));
    global $product;
    if (!isset($product) || !is_object($product)) {
        return $title;
    }
    $post_id = $product->get_id();
    if($id == $post_id){
      $enable_min = get_post_meta($post_id, '_nda_enable_product_minimum', false);
      if(is_array($enable_min))
      {
        $enable_min = $enable_min[0];
      }

      $min_qty = get_post_meta($post_id, '_nda_product_minimum_qty', false);
      if(is_array($min_qty))
      {
        $min_qty = $min_qty[0];
      }

      //$enable_max = get_post_meta($post_id, '_nda_enable_product_maximum', false);
      //$max_qty = get_post_meta($post_id, '_nda_product_maximum_qty', false);
      if(($enable_min == 'yes') && ($min_qty > 1)){
          $title = $title . '<br>(minimum order ' . $min_qty . ')';
      }

    
    }
    //error_log("---------my_get_prodct_title - \$returned title: " . var_export($title,1));
    return $title;
  }


  public function product_quantity_input_args( $args, $product ) {
    // error_log("product_quantity_input_args");
    error_log("product_quantity_input_args - \$args = " . var_export($args, 1));
    //error_log("product_quantity_input_args - \$product = " . var_export($product, 1));
   
    $post_id = $product->get_id();
    $enable_min = get_post_meta($post_id, '_nda_enable_product_minimum');
    if(is_array($enable_min))
    {
      $enable_min = $enable_min[0];
    }

    $min_qty = get_post_meta($post_id, '_nda_product_minimum_qty');
    if(is_array($min_qty))
    {
      $min_qty = $min_qty[0];
    }

    $enable_max = get_post_meta($post_id, '_nda_enable_product_maximum');
    if(is_array($enable_max))
    {
      $enable_max = $enable_max[0];
    }

    $max_qty = get_post_meta($post_id, '_nda_product_maximum_qty');
    if(is_array($max_qty))
    {
      $max_qty = $max_qty[0];
    }

    if(($enable_min == 'yes') && ($min_qty > 1)){
      $args['min_value'] = intval($min_qty);
      $args['quantity']  = intval($min_qty);
    }
    if(($enable_max == 'yes') && ($max_qty > 0)){
      $args['max_value'] = intval($max_qty);
    }
  
     /** Return the updated argument to the product page */
     error_log("product_quantity_input_args - \$returned args = " . var_export($args, 1));
     return $args;
   }
 
}
