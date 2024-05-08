<?php
/*
*	Plugin Name: Heroic Table of Contents
*	Plugin URI:  https://herothemes.com/plugins/heroic-table-of-contents/?utm_source=wprepo&utm_medium=link&utm_campaign=heroic-toc
*	Description: Heroic Table of Contents is the easiest way to add a Table of Contents to your site.
*	Author: HeroThemes
*	Version: 1.2.1
*	Build: 135
*   Build Date: 2022-05-19 2:48:56PM
*	Author URI: https://herothemes.com/?utm_source=wprepo&utm_medium=link&utm_campaign=heroic-toc
*	Text Domain: ht-toc
*/


// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'dist/ht-toc-init.php';


/**
 * Rank Math Support
 */
add_filter( 'rank_math/researches/toc_plugins', function( $toc_plugins ) {
    $toc_plugins[ plugin_basename( __FILE__ ) ] = __( 'Heroic Table of Contents' );
    return $toc_plugins;
});
