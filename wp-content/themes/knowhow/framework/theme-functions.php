<?php

/* Functions specific to the included option settings */

/*-----------------------------------------------------------------------------------*/
/* Add Favicon
/*-----------------------------------------------------------------------------------*/

function st_favicon() {
	if (apply_filters( 'knowhow_get_theme_option', 'st_custom_favicon', null )) {
	echo '<link rel="shortcut icon" href="'. apply_filters( 'knowhow_get_theme_option', 'st_custom_favicon', null ) .'"/>'."\n";
	}
}

add_action('wp_head', 'st_favicon');
