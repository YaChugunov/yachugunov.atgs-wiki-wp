<?php

/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = get_option('stylesheet');
	$themename = preg_replace("/\W/", "_", strtolower($themename));

	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'options_framework_theme'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'one' => __('One', 'knowhow'),
		'two' => __('Two', 'knowhow'),
		'three' => __('Three', 'knowhow'),
		'four' => __('Four', 'knowhow'),
		'five' => __('Five', 'knowhow')
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __('French Toast', 'knowhow'),
		'two' => __('Pancake', 'knowhow'),
		'three' => __('Omelette', 'knowhow'),
		'four' => __('Crepe', 'knowhow'),
		'five' => __('Waffle', 'knowhow')
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment' => 'scroll'
	);

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55'
	);

	// Typography Options
	$typography_options = array(
		'sizes' => array('6', '12', '14', '16', '20'),
		'faces' => array('Helvetica Neue' => 'Helvetica Neue', 'Arial' => 'Arial'),
		'styles' => array('normal' => 'Normal', 'bold' => 'Bold'),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ($options_tags_obj as $tag) {
		$options_tags[$tag->term_id] = $tag->name;
	}

	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages('sort_column=post_parent,menu_order');
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	$wp_editor_settings = array(
		'wpautop' => true, // Default
		'textarea_rows' => 5,
		'tinymce' => array('plugins' => 'wordpress')
	);

	$wp_editor_small = array(
		'wpautop' => true, // Default
		'textarea_rows' => 2,
		'tinymce' => array('plugins' => 'wordpress')
	);

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/framework/admin/images/';

	$options = array();

	$options[] = array(
		"name" => __("General Options", "knowhow"),
		'id' => 'st_general',
		"type" => "heading"
	);

	$options[] = array(
		'name' => __('Enable Live Search?', 'knowhow'),
		'desc' => __('Check to enable live search.', 'knowhow'),
		'id' => 'st_live_search',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => __('Search Text', 'knowhow'),
		'desc' => '',
		'id' => 'st_search_text',
		'std' => 'Есть вопрос? Введите здесь то, что ищете.',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Article Meta', 'knowhow'),
		'desc' => __('Select which meta information to show with article posts.', 'knowhow'),
		'id' => 'st_article_meta',
		'std' => array(
			'date' => '1',
			'author' => '1',
			'category' => '1',
			'comments' => '1'
		), // On my default
		'type' => 'multicheck',
		'options' => array(
			'date' => __('Date', 'knowhow'),
			'author' => __('Author', 'knowhow'),
			'category' => __('Category', 'knowhow'),
			'comments' => __('Comments', 'knowhow')
		),
	);

	$options[] = array(
		'name' => __('Show Article Author Box?', 'knowhow'),
		'desc' => __('Check to show an author box at the end of an article. (The author must have their bio filled out for this to show)', 'knowhow'),
		'id' => 'st_single_authorbox',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => __('Show Related Articles?', 'knowhow'),
		'desc' => __('Check to show a related articles box at the end of an article.', 'knowhow'),
		'id' => 'st_single_related',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options[] = array(
		"name" => __("Footer Copyright Text", "knowhow"),
		"desc" => __("Custom copyright text that will appear in the footer of your theme.", "knowhow"),
		"id" => "st_footer_copyright",
		"std" => "&copy; Copyright, A <a href='https://herothemes.com'>HeroTheme</a>",
		"type" => "editor",
		"settings" => array('wpautop' => true, 'textarea_rows' => 3, 'tinymce' => array('plugins' => 'wordpress'))
	);


	// Homepage Options

	$options[] = array(
		"name" => __("Homepage Options", "knowhow"),
		"type" => "heading"
	);

	$options[] = array(
		"name" => __("Sidebar Layout", "knowhow"),
		"desc" => __("Select or disable the position of the sidebar.", "knowhow"),
		"id" => "st_hp_sidebar",
		"std" => "sidebar-r",
		"type" => "images",
		"options" => array(
			"fullwidth" => $imagepath . "1col.png",
			"sidebar-l" => $imagepath . "2cl.png",
			"sidebar-r" => $imagepath . "2cr.png"
		)
	);

	$options[] = array(
		'name' => __('Top Level Category Options', 'knowhow'),
		'desc' => __('The below options apply to top level categories.', 'knowhow'),
		'type' => 'info'
	);

	$options[] = array(
		'name' => __('Exclude Categories', 'knowhow'),
		'desc' => __('Enter a list of category IDs to exclude from displaying on the homepage. Seperate with a comma like this: 3,6,4', 'knowhow'),
		'id' => 'st_hp_cat_exclude',
		'std' => '',
		'class' => 'mini',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Number Of Category Posts', 'knowhow'),
		'desc' => __('Enter the number of posts to show under each category. Default is 5', 'knowhow'),
		'id' => 'st_hp_cat_postnum',
		'std' => '5',
		'class' => 'mini',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Number Of Category Posts', 'knowhow'),
		'desc' => __('Enter the number of posts to show under each category. Default is 999999', 'knowhow'),
		'id' => 'st_hp_cat_postnum2',
		'std' => '999999',
		'class' => 'mini',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Category Post Ordering', 'knowhow'),
		'desc' => __('Change which article are shown below each category.', 'knowhow'),
		'id' => 'st_hp_cat_posts_order',
		'std' => 'date',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => array(
			'date' => __('Post Date', 'knowhow'),
			'rand' => __('Random', 'knowhow'),
			'meta_value_num' => __('Popular', 'knowhow')
		)
	);

	$options[] = array(
		'name' => __('Show Category Counts?', 'knowhow'),
		'desc' => __('Display the number of articles each category contains next to the category title?', 'knowhow'),
		'id' => 'st_hp_cat_counts',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => __('Sub Categories', 'knowhow'),
		'desc' => __('The below options apply to sub (2nd level) categories.', 'knowhow'),
		'type' => 'info'
	);

	$options[] = array(
		'name' => __('Show Sub Categories?', 'knowhow'),
		'desc' => __('Check to show sub categories on the homepage.', 'knowhow'),
		'id' => 'st_hp_subcat',
		'std' => '1',
		'type' => 'checkbox'
	);

	$options[] = array(
		'name' => __('Exclude Sub Categories', 'knowhow'),
		'desc' => __('Enter a list of category IDs to exclude from displaying on the homepage. Seperate with a comma like this: 3,6,4', 'knowhow'),
		'id' => 'st_hp_subcat_exclude',
		'std' => '',
		'class' => 'mini',
		'type' => 'text'
	);

	$options[] = array(
		'name' => __('Show Sub Category Counts?', 'knowhow'),
		'desc' => __('Display the number of articles each category contains next to the category title?', 'knowhow'),
		'id' => 'st_hp_subcat_counts',
		'std' => '0',
		'type' => 'checkbox'
	);

	// FAQ Options

	$options[] = array(
		"name" => __("FAQ Options", "knowhow"),
		'id' => 'st_faq',
		"type" => "heading"
	);

	$options[] = array(
		'name' => __('FAQ Permalink Slug', 'knowhow'),
		'desc' => __('Enter the slug for your FAQ page. (Important: Set and resave your permalinks when you change this option).', 'knowhow'),
		'id' => 'st_faq_slug',
		'std' => 'faq',
		'class' => 'mini',
		'type' => 'text'
	);

	$options[] = array(
		"name" => __("FAQ Sidebar", "knowhow"),
		"desc" => __("Select or disable the position of the FAQ page sidebar.", "knowhow"),
		"id" => "st_faq_sidebar",
		"std" => "sidebar-r",
		"type" => "images",
		"options" => array(
			"fullwidth" => $imagepath . "1col.png",
			"sidebar-l" => $imagepath . "2cl.png",
			"sidebar-r" => $imagepath . "2cr.png"
		)
	);

	// Styling Opyions		

	$options[] = array(
		"name" => __("Styling Options", "knowhow"),
		"type" => "heading"
	);

	$options[] = array(
		"name" => __("Custom Logo", "knowhow"),
		"desc" => __("Upload a custom logo for your Website.", "knowhow"),
		"id" => "st_logo",
		"type" => "upload"
	);

	$options[] = array(
		"name" => __("Custom Favicon", "knowhow"),
		"desc" => __("Upload a 16px x 16px png/ico image that will represent your website's favicon.", "knowhow"),
		"id" => "st_custom_favicon",
		"type" => "upload"
	);

	$options[] = array(
		"name" => __("Footer Widget Columns", "knowhow"),
		"desc" => __("Select the number of column the footer widget should be displayed in.", "knowhow"),
		"id" => "st_footer_widgets_layout",
		"std" => "3col",
		"type" => "images",
		"options" => array(
			"2col" => $imagepath . "2col.png",
			"3col" => $imagepath . "3col.png",
			"4col" => $imagepath . "4col.png"
		)
	);

	$options[] = array(
		"name" => __("Theme Color", "knowhow"),
		"desc" => __("Select the theme color. (Works best when this and the link color match).", "knowhow"),
		"id" => "st_theme_color",
		"std" => "#a03717",
		"type" => "color"
	);

	$options[] = array(
		"name" => __("Link Color", "knowhow"),
		"desc" => __("Select a custom link color.", "knowhow"),
		"id" => "st_link_color",
		"std" => "#a03717",
		"type" => "color"
	);

	$options[] = array(
		"name" => __("Link Color Hover", "knowhow"),
		"desc" => __("Select a custom link hover color", "knowhow"),
		"id" => "st_link_color_hover",
		"std" => "#a03717",
		"type" => "color"
	);

	$options[] = array(
		"name" => __("Custom CSS", "knowhow"),
		"desc" => __("Add some CSS to your theme by adding it to this block.", "knowhow"),
		"id" => "st_custom_css",
		"std" => "",
		"type" => "textarea"
	);

	return $options;
}



/*
 * This is an example of how to add custom scripts to the options panel.
 * This example shows/hides an option when a checkbox is clicked.
 */

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

	<script type="text/javascript">
		jQuery(document).ready(function() {

			jQuery('#st_live_search').click(function() {
				jQuery('#section-st_search_text').fadeToggle(400);
			});
			if (jQuery('#st_live_search:checked').val() !== undefined) {
				jQuery('#section-st_search_text').show();
			}
		});
	</script>
<?php
}
