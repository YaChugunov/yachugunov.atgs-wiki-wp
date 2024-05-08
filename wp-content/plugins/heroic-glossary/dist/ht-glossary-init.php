<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function htgb_block_assets() {
	wp_register_style(
		'htgb-style-css',
		plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
		array( 'wp-editor' ),
		null
	);

	wp_register_script(
		'htgb-custom-js',
		plugins_url( 'dist/ht-glossary-frontend.js', dirname( __FILE__ ) ),
		array( 'jquery' ),
		HT_GLOSSARY_BUILD_NUMBER,
		true
	);

	wp_register_script(
		'htgb-block-js',
		plugins_url( 'dist/blocks.build.js', dirname( __FILE__ ) ),
		array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor', 'lodash' ),
		HT_GLOSSARY_BUILD_NUMBER,
		true
	);

	wp_register_style(
		'htgb-block-editor-css',
		plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
		array( 'wp-edit-blocks' ),
		null
	);

	wp_localize_script(
		'htgb-block-js',
		'htgbGlobal',
		[
			'pluginDirPath' => plugin_dir_path( __DIR__ ),
			'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
		]
	);


	register_block_type(
		'htgb/block-glossary', array(
			'style'         => 'htgb-style-css',
			'editor_script' => 'htgb-block-js',
			'script'        => 'htgb-custom-js',
			'editor_style'  => 'htgb-block-editor-css',
		)
	);

	//translations
	wp_set_script_translations( 'htgb-block-js', 'ht-glossary', plugin_dir_path( __DIR__ ) . 'languages' );
}

add_action( 'init', 'htgb_block_assets' );
