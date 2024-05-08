<?php
/**
*	Plugin Name:  KnowHow Tools
*	Plugin URI:   https://herothemes.com
*	Description:  Functions to enhance the KnowHow theme
*	Author:       HeroThemes
*	Version:      1.0.1
*	Author URI:   https://herothemes.com/
*	Text Domain:  knowhow
*	Domain Path:  /languages
*/


//exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Custom Theme Options
*/
if ( !function_exists( 'optionsframework_init' ) ) {
  define( 'OPTIONS_FRAMEWORK_DIRECTORY', plugin_dir_url( __FILE__ ) . '/admin/' );
  require_once plugin_dir_path( __FILE__ ) . '/admin/options-framework.php';
}

// Add shortcode manager
require_once plugin_dir_path( __FILE__ ) . 'post-types.php';

// Add Widgets
require_once plugin_dir_path( __FILE__ ) . 'widgets/widget-articles.php';
require_once plugin_dir_path( __FILE__ ) . 'widgets/widget-popular-articles.php';

/**
 * Adds theme shortcodes
 */
require_once plugin_dir_path( __FILE__ ) . 'shortcodes/shortcodes.php';

/**
 * Add shortcode manager
  */
require_once plugin_dir_path( __FILE__ ) . 'wysiwyg/wysiwyg.php';

/**
 * Post Meta Boxes
 */
require_once plugin_dir_path( __FILE__ ) . 'meta-box-library/meta-box.php';