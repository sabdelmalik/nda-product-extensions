<?php
namespace NDA_PRODUCT_EXTENSIONS;
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              nda.ca
 * @since             1.0.0
 * @package           Nda_Product_Extensions
 *
 * @wordpress-plugin
 * Plugin Name:       Nda Product Extensions
 * Plugin URI:        nda.ca
 * Description:       This plugin adds a tab to the product menu where some options are added to an individual product
 * Version:           1.0.0
 * Author:            Sami Abdel Malik
 * Author URI:        nda.ca
 * License:           GNU General Public License v3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain:       nda-product-extensions
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if(!file_exists(plugin_dir_path( __FILE__ ) . 'nda-product-extensions-defines.php')){
  die;
}

spl_autoload_register(
	function ( $class ) {
		$prefix   = __NAMESPACE__;
		$base_dir = __DIR__ . '/includes';

		$len = strlen( $prefix );
		if ( strncmp( $prefix, $class, $len ) !== 0 ) {
			return;
		}

		$relative_class_name = substr( $class, $len );

		$file = $base_dir . str_replace( '\\', '/', $relative_class_name ) . '.php';

		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);

require_once plugin_dir_path( __FILE__ ) . 'nda-product-extensions-defines.php';


//add_action( 'all',  __NAMESPACE__ . '\my_dump', 9999  );
function my_dump()
{
  static $counter = 1;
  static $stop_counting = true;
  static $max_count = 25581;
  static $actions = array();
  $current_filter = current_filter();
  if (strpos($current_filter, 'woocommerce') !== false){
    try{
      $var1 = func_get_args();
      error_log($current_filter);
      error_log($current_filter . " args = " . var_export( func_get_args(), 1));
      error_log("=============================================================");
    }
    catch(Exception $e){
      error_log("#############################################################\ncurrent_filter = " . $current_filter . "\n" . var_export($e, 1));
      error_log("#############################################################");
    }

  }
  if($counter < $max_count && !$stop_counting){
    $current_filter = current_filter();
    //if (((strpos($current_filter, 'woocommerce') !== false) ||
    //     (strpos($current_filter, 'wc_') !== false)) &&
    //     (strpos($current_filter, 'gettext_woocommerce') === false)) {
    //  error_log(sprintf("[%04d]Filter: %s", $counter, var_export( $current_filter, 1 )));
    //if(in_array($current_filter, $actions, true)){
    if (!array_key_exists($current_filter, $actions)){
      //array_push($actions, $current_filter);
      if((strpos($current_filter, 'xoo_') === false) &&
         (strpos($current_filter, 'flatsome') === false)){
        $actions[$current_filter] = 1;
        try{
          $var1 = func_get_args();
          error_log($current_filter);
          error_log($current_filter . " var = " . var_export( $var1, 1));
          error_log("=============================================================");
        }
        catch(Exception $e){
          error_log("#############################################################\ncurrent_filter = " . $current_filter . "\n" . var_export($e, 1));
          error_log("#############################################################");
        }
      }
    }
    $counter++;
  }
  else{
    $stop_counting = true;
  }
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nda-product-extensions-activator.php
 */
function activate_nda_product_extensions() {
	require_once NDA_PRODUCT_EXTENSIONS_INC_DIR . 'class-nda-product-extensions-activator.php';
	Nda_Product_Extensions_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nda-product-extensions-deactivator.php
 */
function deactivate_nda_product_extensions() {
	require_once NDA_PRODUCT_EXTENSIONS_INC_DIR . 'class-nda-product-extensions-deactivator.php';
	Nda_Product_Extensions_Deactivator::deactivate();
}

register_activation_hook( __FILE__, __NAMESPACE__ . '\activate_nda_product_extensions' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\deactivate_nda_product_extensions' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require NDA_PRODUCT_EXTENSIONS_INC_DIR . 'class-nda-product-extensions.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nda_product_extensions() {

	$plugin = new Nda_Product_Extensions();
	$plugin->run();

}
run_nda_product_extensions();
