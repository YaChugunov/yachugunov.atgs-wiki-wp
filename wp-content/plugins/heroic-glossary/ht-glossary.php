<?php
/*
*	Plugin Name: Heroic Glossary
*	Plugin URI:  https://herothemes.com/heroic-glossary
*	Description: Glossary plugin for WordPress - add a Glossary block to the WordPress editor
*	Author: HeroThemes
*	Version: 1.2.5
*	Build: 350
*   Build Date: 2024-04-29 11:57:22AM
*	Author URI: https://www.herothemes.com/
*	Text Domain: ht-glossary
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ht glossary plugin version number.
if ( ! defined( 'HT_GLOSSARY_VERSION_NUMBER' ) ) {
	define( 'HT_GLOSSARY_VERSION_NUMBER', '1.2.5' );
}

// ht glossary build number.
if ( ! defined( 'HT_GLOSSARY_BUILD_NUMBER' ) ) {
	define( 'HT_GLOSSARY_BUILD_NUMBER', 350 );
}

/**
 * Block Initializer.
 */
require_once plugin_dir_path( __FILE__ ) . 'dist/ht-glossary-init.php';

//nb: load_plugin_textdomain not required for Gutenberg only text calls
