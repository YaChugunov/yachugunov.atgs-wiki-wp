<?php
/**
 * Blocks Initializer
 *
 * Enqueue CSS/JS of all the blocks.
 *
 * @since   1.0.0
 * @package CGB
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Loads Editor assets.
 */
if ( ! function_exists( 'ht_toc_cgb_block_editor_assets' ) ) {
	function ht_toc_cgb_block_editor_assets() {
		// Only load this block in the post editor (should not operate on widgets or FSE).
		$current_screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if( !$current_screen || !is_a($current_screen, 'WP_Screen') || 'post' != $current_screen->base ){
			return;
		}
		
		// Javascript.
		wp_enqueue_script(
			'ht_toc-block-js',
			plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ),
			array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ),
			filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ),
			true // Load in the footer.
		);

		// Styles.
		wp_enqueue_style(
			'ht_toc-block-editor-css',
			plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ),
			array( 'wp-edit-blocks' ),
			filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' )
		);

		// Plugin script localization (passes info from PHP to JS).
		wp_localize_script(
			'ht_toc-block-js',
			'ht_toc_global',
			array(
				'pluginDirPath' => plugin_dir_path( __DIR__ ),
				'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
			)
		);
	}
}
// Hook: Editor assets. (needs frontend and backend)
add_action( 'enqueue_block_editor_assets', 'ht_toc_cgb_block_editor_assets' );
add_action( 'enqueue_block_editor_assets', 'ht_toc_cgb_block_assets' );

/**
 * Loads Frontend assets.
 */
if ( ! function_exists( 'ht_toc_cgb_block_assets' ) ) {
	function ht_toc_cgb_block_assets() {
		// Javascript.
		wp_enqueue_script(
			'ht_toc-script-js',
			plugins_url( '/dist/script.min.js', dirname( __FILE__ ) ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'dist/script.min.js' ),
			true // Load in the footer.
		);

		// Styles.
		wp_enqueue_style(
			'ht_toc-style-css',
			plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ),
			array(),
			filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' )
		);
	}
}
// Hook: Frontend assets.
add_action( 'enqueue_block_assets', 'ht_toc_cgb_block_assets' );