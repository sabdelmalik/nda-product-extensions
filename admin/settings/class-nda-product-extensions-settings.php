<?php
namespace NDA_PRODUCT_EXTENSIONS;

/**
 * Adds Sttings to word press.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    NDA_Woo_Customiser
 * @subpackage NDA_Woo_Customiser/admin
 * @author     Your Name <email@example.com>
 */
class Nda_Product_Extensions_Settings {
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
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Nda_Product_Extensions_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
  private $loader;

  public function __construct( $plugin_name, $version, $loader) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
    $this->loader = $loader;
		$this->load_dependencies();
		$this->define_hooks();

    $this->instantiate_settings_classes();
  }

  private function load_dependencies(){
    //require_once NDA_PRODUCT_EXTENSIONS_ADMIN_DIR .'settings/class-nda-woo-customiser-email-settings.php';
  }

  private function define_hooks(){
    /**
     * Register our nda_product_extensions_options_page with the admin_menu action hook.
     */
    $this->loader->add_action( 'admin_menu'   , $this, 'nda_product_extensions_add_menu' );
    /**
     * Register our nda_product_extensions_settings_init with the admin_init action hook.
     */
    $this->loader->add_action( 'admin_init'   , $this, 'nda_product_extensions_settings_init' );
  
    $this->loader->add_action( 'wp_ajax_my_action', $this, 'my_action' );
  
  }

  private function instantiate_settings_classes(){
    //new NDA_Woo_Customiser_Email_Settings($this->plugin_name, $this->version, $this->loader);
  }
  /**
   * custom option and settings
   */
  function nda_product_extensions_settings_init() {
    // error_log("action:'admin_init', function:'nda_product_extensions_settings_init'" );
    // Register a new setting for "nda_product_extensions" page.
    register_setting( 'nda_product_extensions', 'nda_product_extensions_options' );

    // Register a new section in the "nda_product_extensions" page.
    $id       = 'nda_product_extensions_section';
    $title    = __( 'Noble Title.', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN );
    $callback = array( $this,'nda_product_extensions_section_developers_callback' );
    $page     = 'nda_product_extensions';
    
    add_settings_section(
      $id,
      $title,
      $callback,
      $page
    );

    // Register a new field in the "nda_product_extensions_section" section, inside the "nda_product_extensions" page.
     $id       = 'nda_product_extensions_forms';
     $title    = __( 'Debug Level', NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN );
     $callback = array( $this,'nda_product_extensions_debug_level_cb' );
     $page     = 'nda_product_extensions';
     $section  = 'nda_product_extensions_section';
     $args     = array(
                'label_for'         => 'nda_product_extensions_forms',
                'class'             => 'nda_product_extensions_row',
                'nda_product_extensions_custom_data' => 'custom',
            );

    add_settings_field(
      $id,
      $title,
      $callback,
      $page,
      $section,
      $args
    );
  }

  public function nda_product_extensions_add_menu(){
    $args = array(
      'page_title' => 'NDA Extensions',
      'menu_title' => 'NDA Extensions',
      'capability' => 'manage_options',
      'menu_slug'  => NDA_EXTENSIONS_ADMIN_MENU_SLUG,
      'function'   => array( $this,'nda_product_extensions_options_page_html' ),
      'icon_url'	 => 'dashicons-admin-generic',
      'position'   => null,
      );
    $menu_added = nda_add_menu_page($args);

    $args = array(
      'parent_slug' => NDA_EXTENSIONS_ADMIN_MENU_SLUG,
      'page_title' => 'Products',
      'menu_title' => 'Products',
      'capability' => 'manage_options',
      'menu_slug'  => ($menu_added? NDA_EXTENSIONS_ADMIN_MENU_SLUG : 'nda-product-extensions-settings'),
      'function'  => array( $this,'nda_product_extensions_settings_page_html' ),
      'position'  => null,
    );
    nda_add_submenu_page($args);

  }
  



  /**
   * Top level menu callback function
   */
  public function nda_product_extensions_options_page_html(){
    if ( ! current_user_can( 'manage_options' ) ) {
      return;
    }
?>
    <div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    </div>
<?php
  }

  public function nda_product_extensions_settings_page_html(){
    error_log("menu callback, function:'nda_product_extensions_options_page_html'" );
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }


    // check if the user have submitted the settings
    // WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
        // add settings saved message with the class of "updated"
        add_settings_error( 'nda_product_extensions_messages', 'nda_product_extensions_message', __( 'Settings Saved', NDA_WOO_TEXT_DOMAIN ), 'updated' );
    }

    // show error/update messages
    settings_errors( 'nda_product_extensions_messages' );
    ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <ul class="xoo-sc-tabs" style="margin:0;list-style:none;padding:0;">
		<?php foreach( $tabs as $tab_id => $tab_data ): ?>
			<li data-tab="<?php echo $tab_id; ?>" <?php if( $tab_data['pro'] === 'yes' ) echo 'class="xoo-as-is-pro"'; ?>><?php echo $tab_data['title']; ?></li>
		<?php endforeach; ?>
	  </ul>
    

         <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "nda_product_extensions"
        settings_fields( 'nda_product_extensions' );
        // output setting sections and their fields
        // (sections are registered for "nda_product_extensions", each field is registered to a specific section)
        do_settings_sections( 'nda_product_extensions' );
        // output save settings button
        submit_button( 'Save Settings' );
        ?>
      </form>
    </div>
    <?php
  }

  public function my_action() {
	  global $wpdb;
	  $whatever = intval( $_POST['whatever'] );
	  wp_send_json( $whatever); 
  }



  /**
   * Custom option and settings:
   *  - callback functions
   */


  /**
   * Developers section callback function.
   *
   * @param array $args  The settings array, defining title, id, callback.
   */
  function nda_product_extensions_section_developers_callback( $args ) {
  ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Follow the white rabbit.', 'nda_product_extensions' ); ?></p>
  <?php
  }

  /**
   * Pill field callbakc function.
   *
   * WordPress has magic interaction with the following keys: label_for, class.
   * - the "label_for" key value is used for the "for" attribute of the <label>.
   * - the "class" key value is used for the "class" attribute of the <tr> containing the field.
   * Note: you can add custom key value pairs to be used inside your callbacks.
   *
   * @param array $args
   */
  function nda_product_extensions_debug_level_cb( $args ) {
    // Get the value of the setting we've registered with register_setting()
    $options = get_option( 'nda_product_extensions_options' );

    //error_log(">> nda_product_extensions_debug_level_cb - args: " . var_export( $args, 1 ));
    //error_log(">> nda_product_extensions_debug_level_cb - options: " . var_export( $options, 1 ));

    $debug_options = array(
                  'none' => array(
                        'value' => 'none',
                        'name' => 'None'
                        ),
                  'info' => array(
                        'value' => 'info',
                        'name' => 'Info'
                        ),
                  'exceptions' => array(
                        'value' => 'exceptions',
                        'name' => 'Exceptions'
                        ),
                  'debug1' => array(
                          'value' => 'debug',
                          'name' => 'Debug'
                          ),
                  );
    ?>

    <select id="<?php echo esc_attr( $args['label_for'] ); ?>"
           data-custom="<?php echo esc_attr( $args['nda_product_extensions_custom_data'] ); ?>"
           name="nda_product_extensions_options[<?php echo esc_attr( $args['label_for'] ); ?>]">
           <!--onchange='document.location.href=this.options[this.selectedIndex].value;'--> 
    <option value="">
    <?php 
      $pages = get_pages();
      foreach($pages as $page) {
        $post = get_post($page->ID, ARRAY_A);
        if(strpos($post['post_content'], '[Form id="') !== false){
        error_log("---------- PAGES = " . var_export($post['post_content'], 1));
        //$option = '<option value="' . get_page_link( $page->ID ) . '" id="' . $page->ID . '" ';
        $option = '<option value="' . $page->ID . '" ';
        $option .= isset( $options[ $args['label_for'] ] ) ? ( selected( $options[ $args['label_for'] ], $page->ID, false ) ) : ( '' );
        $option .= '>';
        $option .= $page->post_title;
        $option .= '</option>';
        echo $option;
        }
      }
    ?>
    </select>
  <?php
  }
}