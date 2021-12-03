<?php
namespace NDA_PRODUCT_EXTENSIONS;

/**
 * General functions file for the plugin.
 *
 * @package    NDA WOO Customiser
 * @subpackage includes
 * @author     Sami Abdel Malik <sami.abdelmalik@gmail.com>
 * @copyright  Copyright (c) 2021, Sami Abdel Malik
 * @link       
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

function nda_get_admin_url($tab = false, $section = false){
  $url = 'admin.php?page=nda-woo-customiser-settings-email';
  if($tab && !empty($tab)){
    $url .= '&tab='. $tab;
  }
  if($section && !empty($section)){
    $url .= '&section='. $section;
  }
  return admin_url($url);
}


/**
 * Add top level menu page.
 *
 * @since  1.0.0
 * @access public
 * @param  object     $a
 * @return int
 */
function nda_add_menu_page(array $args){
  if ( empty( $GLOBALS['admin_page_hooks'][NDA_EXTENSIONS_ADMIN_MENU_SLUG] ) ) {
    extract( $args );

    \add_menu_page( 
      $page_title, 
      $menu_title, 
      $capability,
      $menu_slug,
      $function, 
      $icon_url,
      $position
    );
    return true;
  }
  return false;
}

/**
 * Add submenu menu page.
 *
 * @since  1.0.0
 * @access public
 * @param  object     $a
 * @return int
 */
function nda_add_submenu_page(array $args){
  extract( $args );
  
  \add_submenu_page( 
    $parent_slug,
    $page_title,
    $menu_title,
    $capability,
    $menu_slug,
    $function,
    $position
  );
}
