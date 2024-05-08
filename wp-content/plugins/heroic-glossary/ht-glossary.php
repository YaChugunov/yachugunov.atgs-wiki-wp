<?php
/*
*	Plugin Name: Heroic Glossary
*	Plugin URI:  https://herothemes.com/heroic-glossary
*	Description: Glossary plugin for WordPress
*	Author: HeroThemes
*	Version: 1.2.4
*	Build: 347
*   Build Date: 2024-01-03 1:04:48PM
*	Author URI: https://www.herothemes.com/
*	Text Domain: ht-glossary
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ht glossary plugin version number.
if ( ! defined( 'HT_GLOSSARY_VERSION_NUMBER' ) ) {
	define( 'HT_GLOSSARY_VERSION_NUMBER', '1.2.4' );
}

// ht glossary build number.
if ( ! defined( 'HT_GLOSSARY_BUILD_NUMBER' ) ) {
	define( 'HT_GLOSSARY_BUILD_NUMBER', 347 );
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'dist/ht-glossary-init.php';

//nb: load_plugin_textdomain not required for Gutenberg only text calls
