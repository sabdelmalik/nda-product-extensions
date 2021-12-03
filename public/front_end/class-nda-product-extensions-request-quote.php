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
class Nda_Product_Extensions_Request_Quote {
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
    $this->loader->add_action('woocommerce_before_add_to_cart_form', $this, 'woocommerce_before_add_to_cart_form');
    $this->loader->add_action('woocommerce_after_add_to_cart_form', $this, 'woocommerce_after_add_to_cart_form');
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

  
  function get_quote_form($form_name, $quotation_button_label)
  {
    //$quote = '<form class="cart" action="http://noble.delicious/wordpress/noble1/request-a-quote/" method="post" enctype="multipart/form-data">
    $quote = '<form class="cart" action="' . get_site_url() . '/' . $form_name . '" method="post" enctype="multipart/form-data">
        <div class="gpls_rfq_set_div" style="clear: both">
                  <!--<button type="submit" name="add-to-quote" onmouseover=";" onmouseout=";" onload=";" class="single_add_to_cart_button button alt  gpls_rfq_set gpls_rfq_css" value="588" style="display: inline-block">Add To Quote</button>-->
                  <button type="submit" name="request a quote" onmouseover=";" onmouseout=";" onload=";" class="single_add_to_cart_button button" style="display: inline-block">' . $quotation_button_label . '</button>
                  <input type="hidden" value="-1" name="rfq_product_id" id="rfq_product_id">
                  <input type="hidden" name="rfq_single_product" id="rfq_product_id">
                </div>
              </form>';
/*                <script>jQuery(document ).ready( function() { 
                            jQuery( '.single_add_to_cart_button' ).show();
                            jQuery( '.single_add_to_cart_button' ).attr('style','display: inline-block !important');
                            jQuery('.single_add_to_cart_button').prop('disabled',false);;
                            jQuery('.gpls_rfq_set').prop('disabled', false);
                          } 
                        ); 
                </script>
              </form>'*/
        return $quote;
  }

  function woocommerce_before_add_to_cart_form(){
    global $product;
//    if (!is_object($product) && !function_exists('wc_get_product')) return;
//    if (!is_object($product)) $product = wc_get_product(get_the_ID());
    if (!isset($product) || !is_object($product)) {
        return;
    }
    $price_restriction = get_post_meta($product->get_id(), '_nda_product_price_display_restriction');
    error_log("woocommerce_before_add_to_cart_form");
    if(is_array($price_restriction))
    {
      $price_restriction = $price_restriction[0];
    }
    if(($price_restriction == 'no_display') || 
    (($price_restriction == 'logged_in_users')&& !is_user_logged_in())){
      echo '<div style="display:none;">';
    }
  }


  function woocommerce_after_add_to_cart_form(){
    global $product;
    if (!isset($product) || !is_object($product)) {
        return;
    }
    $price_restriction = get_post_meta($product->get_id(), '_nda_product_price_display_restriction');
    if(is_array($price_restriction))
    {
      $price_restriction = $price_restriction[0];
    }
    
    $quotation_form = get_post_meta($product->get_id(), '_nda_product_request_a_quote_options');
    if(is_array($quotation_form))
    {
      $quotation_form = $quotation_form[0];
    }
    if (empty($quotation_form)){
      $quotation_form = 'none';
    }
    $quotation_button_label = get_post_meta($product->get_id(), '_nda_request_a_quote_btn_label');
    if(is_array($quotation_button_label))
    {
      $quotation_button_label = $quotation_button_label[0];
    }
    if (empty($quotation_button_label)){
      $quotation_button_label = __("Request a Quote", NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN);
    }

    $quotation_form2 = get_post_meta($product->get_id(), '_nda_product_request_a_quote_options2');
    if(is_array($quotation_form2))
    {
      $quotation_form2 = $quotation_form2[0];
    }
    if (empty($quotation_form2)){
      $quotation_form2 = 'none';
    }

    $quotation_button_label2 = get_post_meta($product->get_id(), '_nda_request_a_quote_btn_label2');
    if(is_array($quotation_button_label2))
    {
      $quotation_button_label2 = $quotation_button_label2[0];
    }
    if (empty($quotation_button_label2)){
      $quotation_button_label2 = __("Request a Quote", NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN);
    }

    if(($price_restriction == 'no_display') || 
    (($price_restriction == 'logged_in_users')&& !is_user_logged_in())){
      echo '</div>';
    }
    if($quotation_form != 'none'){
      echo $this->get_quote_form($quotation_form, $quotation_button_label);
    }
    if($quotation_form2 != 'none'){
      echo $this->get_quote_form($quotation_form2, $quotation_button_label2);
    }
/*    if($quotation_form == 'basic_cake'){
      echo $this->get_quote_form('basic-cake-quote-request');
    }
    if($quotation_form == 'decorated_cake'){
      echo $this->get_quote_form('decorated-cake-quote-request');
    }*/
  }

}
