<?php
namespace NDA_PRODUCT_EXTENSIONS;

/**
 * Do not proceed unless Woocommerce plugin is running.
 */
if (!function_exists('nda_check_prerequisites')){
	function nda_check_prerequisites(){
      $result = false;
	    $active_plugins = (array) get_option('active_plugins', array());
	    if(is_multisite()){
		   $active_plugins = array_merge($active_plugins, get_site_option('active_sitewide_plugins', array()));
	    }
      $result = in_array('woocommerce/woocommerce.php', $active_plugins);
      if(!$result){
        $result =  array_key_exists('woocommerce/woocommerce.php', $active_plugins);
      }
      if(!$result){ 
        $result = class_exists('WooCommerce'); 
      }                  
      if(!$result){
        die;
      }
    }
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NDA_PRODUCT_EXTENSIONS_VERSION', '1.0.0' );

if ( ! defined( 'NDA_DEBUG' ) ) {
	define( 'NDA_DEBUG', false );
}

if ( ! defined( 'NDA_PRODUCT_EXTENSIONS_URL' ) ) {
	define( 'NDA_PRODUCT_EXTENSIONS_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'NDA_PRODUCT_EXTENSIONS_DIR' ) ) {
	define( 'NDA_PRODUCT_EXTENSIONS_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'NDA_PRODUCT_EXTENSIONS_ADMIN_DIR' ) ) {
	define( 'NDA_PRODUCT_EXTENSIONS_ADMIN_DIR', NDA_PRODUCT_EXTENSIONS_DIR . 'admin' . DIRECTORY_SEPARATOR  );
}

if ( ! defined( 'NDA_PRODUCT_EXTENSIONS_PUBLIC_DIR' ) ) {
	define( 'NDA_PRODUCT_EXTENSIONS_PUBLIC_DIR', NDA_PRODUCT_EXTENSIONS_DIR . 'public' . DIRECTORY_SEPARATOR  );
}

if ( ! defined( 'NDA_PRODUCT_EXTENSIONS_INC_DIR' ) ) {
	define( 'NDA_PRODUCT_EXTENSIONS_INC_DIR', NDA_PRODUCT_EXTENSIONS_DIR . 'includes' . DIRECTORY_SEPARATOR  );
}

if ( ! defined( 'NDA_PRODUCT_EXTENSIONS_BASENAME' ) ) {
	define( 'NDA_PRODUCT_EXTENSIONS_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'NDA_PRODUCT_EXTENSIONS_SLUG' ) ) {
	define( 'NDA_PRODUCT_EXTENSIONS_SLUG', 'nda-product-extensions' );
}

if ( ! defined( 'NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN' ) ) {
	define( 'NDA_PRODUCT_EXTENSIONS_TEXT_DOMAIN', 'nda-product-extensions' );
}

if ( ! defined( 'NDA_PRODUCT_EXTENSIONS_ADMIN_MENU_SLUG' ) ) {
	define( 'NDA_PRODUCT_EXTENSIONS_ADMIN_MENU_SLUG', 'nda-product-extensions-settings' );
}
