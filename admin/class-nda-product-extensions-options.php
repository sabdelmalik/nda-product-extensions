<?php
namespace NDA_PRODUCT_EXTENSIONS;

use Error;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       nda.ca
 * @since      1.0.0
 *
 * @package    Nda_Product_Extensions
 * @subpackage Nda_Product_Extensions/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Nda_Product_Extensions
 * @subpackage Nda_Product_Extensions/admin
 * @author     Sami Abdel Malik <sami.malik@sympatico.ca>
 */
class Nda_Product_Extensions_Options{
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $loader ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
    $this->loader = $loader;

    $this->load_dependencies();
    $this->define_hooks();

    $this->instantiate_classes();
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
    $this->loader->add_action( 'woocommerce_product_data_tabs', $this,'add_product_tab');
    $this->loader->add_action( 'woocommerce_product_data_panels', $this,'add_product_tab_content');
    $this->loader->add_action( 'woocommerce_process_product_meta', $this,'save_product_data',11,2);
  }

  /**
	 * Instantiate admin classes
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function instantiate_classes() {
  }

  function add_product_tab($tabs){
    $tabs['nda_product_options'] = array(
        'label'    => 'NDA Product Options',
        'target'   => 'nda_product_options_data',
        'priority' => 21,
    );
    return $tabs;
  }

  function add_product_tab_content(){
    ?>    
    <div id="nda_product_options_data" class="panel woocommerce_options_panel hidden">
    <h2><b>Control Price Display</b></h2>
    <?php
    woocommerce_wp_select(
      array(
        'id' => '_nda_product_price_display_restriction',
        'label' => __('Restrict price display', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
        'desc_tip' => true,
        'description' => __('Restrict price display for this product.', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
        'options' => array(
          'no_restrictions' => __('No restrictions', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
          'logged_in_users' => __('Show to logged in users only', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
          'no_display' => __('No price display', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN))
        ));
    ?>
    <hr style="display: margin-left: auto;margin-right: auto;border-style: inset;color: black; border-width: 2px;">
    <h2><b>Control Quotation Request</b></h2>
    <?php    
    woocommerce_wp_select(
      array(
        'id' => '_nda_product_request_a_quote_options',
        'label' => __('Request a Quote', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
        'desc_tip' => true,
        'description' => __('Allow customer to request a quote using a specific form.', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
        'options' => array(
          'not_allowed' => __('Not allowed', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
          'wedding' => __('Wedding cake quotation form', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN))
        ));
    ?>
    <hr style="display: block;margin-top: 1em;margin-bottom: 1em;margin-left: auto;margin-right: auto;border-style: inset;color: black; border-width: 2px;">
    <h2><b>Control Minimum and Maximum Order Quantity</b></h2>
    <?php
    woocommerce_wp_checkbox( array(
      'id' => '_nda_enable_product_minimum', 
      'label' => __("Enable Minimum Quantity", NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN), 
      'desc_tip' => true,
      'description' => __("Enable minimum quantity for this product", NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN)
    ) );

    woocommerce_wp_text_input( array(
      'id' => '_nda_product_minimum_qty', 
      'label' => __("Minimum Quantity", NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN), 
      'desc_tip' => true, 
      'description' => __("Set minimum quantity for this product", NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
      'type' => 'number',
      'custom_attributes' => array('min' => '0',)
     ) );

    woocommerce_wp_checkbox( array(
      'id' => '_nda_enable_product_maximum', 
      'label' => __("Enable Maximum Quantity", NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN), 
      'desc_tip' => true,
      'description' => __("Enable Maximum quantity for this product", NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN)
    ) );

    woocommerce_wp_text_input( array(
      'id' => '_nda_product_maximum_qty', 
      'label' => __("Maximum Quantity", NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN), 
      'desc_tip' => true, 
      'description' => __("Set Maximum quantity for this product", NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
      'type' => 'number',
      'custom_attributes' => array('min' => '0',)
      ) );
    echo '</div>';

  }


  function nda_product_options_pricing(  ) { 
    return;
    global $woocommerce, $post;
?>
    <h2><b>NDA Product Extensions</b></h2>
    <hr style="display: block;margin-top: 1em;margin-bottom: 1em;margin-left: auto;margin-right: auto;border-style: inset;color: black; border-width: 2px;">
<?php
    
/*  woocommerce_wp_checkbox(
    array(
        'id' => '_nda_product_price_for_loggedin_only',
        'label' => __( 'Restrict price display', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN ),
        'placeholder' => 'Restrict price display for this product',
        'desc_tip' => 'true',
        'description' => __( "Restrict price display for this product.", NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN )

    ));*/

    woocommerce_wp_select(
      array(
        'id' => '_nda_product_price_display_restriction',
        'label' => __('Restrict price display', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
        'desc_tip' => true,
        'description' => __('Restrict price display for this product.', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
        'options' => array(
          'no_restrictions' => __('No restrictions', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
          'logged_in_users' => __('Show to logged in users only', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
          'no_display' => __('No price display', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN))
        ));

    woocommerce_wp_select(
      array(
        'id' => '_nda_product_request_a_quote_options',
        'label' => __('Request a Quote', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
        'desc_tip' => true,
        'description' => __('Allow customer to request a quote using a specific form.', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
        'options' => array(
          'not_allowed' => __('Not allowed', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN),
          'wedding' => __('Wedding cake quotation form', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN))
        ));

  } 

  function save_product_data( $post_id, $post ) { 
   // error_log("----- save_product_data - \$post_id = " . var_export($post_id, 1));
 //   error_log("----- nda_custom_general_fields_save - \$post = " . var_export($post, 1));
    //error_log("----- save_product_data - _nda_product_price_display_restriction = " . var_export($_POST['_nda_product_price_display_restriction'], 1));
   // error_log("----- save_product_data - \$_POST = " . var_export($_POST, 1));
    update_post_meta($post_id, '_nda_product_price_display_restriction', $_POST['_nda_product_price_display_restriction']);
    update_post_meta($post_id, '_nda_product_request_a_quote_options', $_POST['_nda_product_request_a_quote_options']);

    $enable_min = $_POST['_nda_enable_product_minimum'];
    $min_qty = $_POST['_nda_product_minimum_qty'];
    if ($min_qty < 1) $min_qty = 1;
    $enable_max = $_POST['_nda_enable_product_maximum'];
    $max_qty = $_POST['_nda_product_maximum_qty'];
    if ($max_qty <= $min_qty) $max_qty =  $min_qty + 1;
    update_post_meta($post_id, '_nda_enable_product_minimum', $enable_min);
    update_post_meta($post_id, '_nda_product_minimum_qty', $min_qty);
    update_post_meta($post_id, '_nda_enable_product_maximum', $enable_max);
    update_post_meta($post_id, '_nda_product_maximum_qty', $max_qty);
  } 



}
