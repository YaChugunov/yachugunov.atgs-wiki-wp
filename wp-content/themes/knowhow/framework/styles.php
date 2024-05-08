<?php
/**
 * Enqueues styles for front-end.
 */
function st_theme_styles() {
	global $wp_styles;

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'theme-style', get_stylesheet_uri() );
		
	/*
	 * Loads our Google Font.
	 */
	 
	$subsets = 'latin,latin-ext';

		/* translators: To add an additional Open Sans character subset specific to your language, translate
		   this to 'greek', 'cyrillic' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Open Sans font: add new subset (greek, cyrillic, vietnamese)', 'knowhow' );

		if ( 'cyrillic' == $subset )
			$subsets .= ',cyrillic,cyrillic-ext';
		elseif ( 'greek' == $subset )
			$subsets .= ',greek,greek-ext';
		elseif ( 'vietnamese' == $subset )
			$subsets .= ',vietnamese';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => 'Open+Sans:400,400italic,600,700',
			'subset' => $subsets,
		);
	wp_enqueue_style( 'theme-font', esc_url ( add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" )), array(), null );

	
	/*
	* Add font awesome CSS
	*/
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array('theme-style') );
	
	
	/*
	* Adds stylesheet for shortcodes
	* (will be moved to plugin soon)
	*/
	//wp_enqueue_style( 'shortcodes', get_template_directory_uri() . '/framework/shortcodes/shortcodes.css' );
	
	
	/*
	* Load theme custom colors
	*/
	
	$theme_custom_css = ' 
				/* Links */
				a, 
				a:visited { color:'. apply_filters( 'knowhow_get_theme_option', 'st_link_color', '#a03717' ) .'; }
				a:hover, 
				.widget a:hover,
				#primary-nav ul a:hover,
				#footer-nav a:hover,
				#breadcrumbs a:hover { color:'. apply_filters( 'knowhow_get_theme_option', 'st_link_color_hover', '#a03717' ) .'; }
				
				/* Theme Color */
				#commentform #submit, 
				.st_faq h2.active .action, 
				.widget_categories ul span, 
				.pagination .current, 
				.tags a, 
				.page-links span,
				#comments .comment-meta .author-badge,
				input[type="reset"],
				input[type="submit"],
				input[type="button"] { background: '. apply_filters( 'knowhow_get_theme_option', 'st_theme_color', '#a03717' ) .'; }
				#live-search #searchsubmit, input[type="submit"] { background-color: '. apply_filters( 'knowhow_get_theme_option', 'st_theme_color', '#a03717' ) .'; }
				.tags a:before { border-color: transparent '. apply_filters( 'knowhow_get_theme_option', 'st_theme_color', '#a03717' ) .' transparent transparent; }

				'. apply_filters( 'knowhow_get_theme_option', 'st_custom_css', null ) .'
				
				';
				

	wp_add_inline_style('theme-style',$theme_custom_css);
	
	
}

add_action( 'wp_enqueue_scripts', 'st_theme_styles' );

