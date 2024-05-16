<?php

/**
 * KnowHow functions and definitions
 * by HeroThemes (https://herothemes.com)
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if (!isset($content_width)) $content_width = 980;


/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
if (!function_exists('st_theme_setup')) :
    function st_theme_setup() {

        /**
         * Make theme available for translation
         * Translations can be filed in the /languages/ directory
         */
        load_theme_textdomain('knowhow', get_template_directory() . '/languages');


        /**
         * Add default posts and comments RSS feed links to head
         */
        add_theme_support('automatic-feed-links');

        /**
         * Enable support for Post Thumbnails
         */
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(60, 60);
        add_image_size('post', 150, 150, false); // Post thumbnail	

        /**
         * Register menu locations
         */
        register_nav_menus(array(
            'primary-nav' => __('Primary Menu', 'knowhow'),
            'footer-nav' => __('Footer Menu', 'knowhow')
        ));

        /**
         * Add Support for post formarts
         */
        add_theme_support('post-formats', array('video'));

        // This theme uses its own gallery styles.
        add_filter('use_default_gallery_style', '__return_false');

        // Add support for responsive embeds.
        add_theme_support('responsive-embeds');

        /*
   * Let WordPress manage the document title.
   * By adding theme support, we declare that this theme does not use a
   * hard-coded <title> tag in the document head, and expect WordPress to
   * provide it for us.
   */
        add_theme_support('title-tag');

        /*
   * Switch default core markup for search form, comment form, and comments
   * to output valid HTML5.
   */
        add_theme_support('html5', array(
            'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
        ));

        // This is a hero theme
        add_theme_support('ht-hero-theme');
    }
endif; // st_theme_setup
add_action('after_setup_theme', 'st_theme_setup');


// Inlcude TGM Plugins
require("framework/tgm-config.php");

/**
 * Enqueues scripts and styles for front-end.
 */
require("framework/scripts.php");
require("framework/styles.php");

/**
 * Theme Functions
 */
require("framework/theme-functions.php");


/**
 * Comment Functions
 */
require("framework/comment-functions.php");

/**
 * Post Meta Boxes
 */
//require_once ("framework/meta-box-library/meta-box.php");
// Include the meta box definition
include 'framework/post-meta.php';

/**
 * Post Format Functions
 */
require("framework/post-formats.php");

/**
 * Comment Functions
 */
require("framework/template-navigation.php");

/**
 * Register widgetized area and update sidebar with default widgets
 */
require("framework/register-sidebars.php");

/**
 * Add Widget Functions
 */
require("framework/widgets/widget-functions.php");

/**
 * Add post views
 */
function st_set_post_views($postID) {
    $count_key = '_st_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 1;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
//To keep the count accurate, lets get rid of prefetching
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function st_get_post_views($postID) {
    $count_key = '_st_post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '1');
        return "1 View";
    }
    return $count . ' Views';
}


// KnowHow Theme options call filter
function knowhow_get_theme_option($option_name, $default = null) {
    if (function_exists('of_get_option')) {
        return of_get_option($option_name, $default);
    } else {
        return $default;
    }
}
add_filter('knowhow_get_theme_option', 'knowhow_get_theme_option',  10, 2);



/*=============================================
                BREADCRUMBS
=============================================*/
//  to include in functions.php
function the_breadcrumb() {
    $showOnHome = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
    $delimiter = '&raquo;'; // delimiter between crumbs
    $home = '<icon class="fa fa-home"></i>'; // text for the 'Home' link
    $showCurrent = 0; // 1 - show current post/page title in breadcrumbs, 0 - don't show
    $before = '<span class="current">'; // tag before the current crumb
    $after = '</span>'; // tag after the current crumb

    global $post;
    $homeLink = get_bloginfo('url');
    if (is_home() || is_front_page()) {
        if ($showOnHome == 1) {
            echo '<span id="crumbs"><a href="' . $homeLink . '">' . $home . '</a></span>';
        }
    } else {
        echo '<span id="crumbs"><a href="' . $homeLink . '">' . $home . '</a> ' . $delimiter . ' ';
        if (is_category()) {
            $thisCat = get_category(get_query_var('cat'), false);
            if ($thisCat->parent != 0) {
                echo get_category_parents($thisCat->parent, true, ' ' . $delimiter . ' ');
            }
            echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
        } elseif (is_search()) {
            echo $before . 'Search results for "' . get_search_query() . '"' . $after;
        } elseif (is_day()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('d') . $after;
        } elseif (is_month()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
            echo $before . get_the_time('F') . $after;
        } elseif (is_year()) {
            echo $before . get_the_time('Y') . $after;
        } elseif (is_single() && !is_attachment()) {
            if (get_post_type() != 'post') {
                $post_type = get_post_type_object(get_post_type());
                $slug = $post_type->rewrite;
                echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a>';
                if ($showCurrent == 1) {
                    echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
                }
            } else {
                $cat = get_the_category();
                $cat = $cat[0];
                $cats = get_category_parents($cat, true, ' ' . $delimiter . ' ');
                if ($showCurrent == 0) {
                    $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
                }
                echo $cats;
                if ($showCurrent == 1) {
                    echo $before . get_the_title() . $after;
                }
            }
        } elseif (!is_single() && !is_page() && get_post_type() != 'post' && !is_404()) {
            $post_type = get_post_type_object(get_post_type());
            echo $before . $post_type->labels->singular_name . $after;
        } elseif (is_attachment()) {
            $parent = get_post($post->post_parent);
            $cat = get_the_category($parent->ID);
            $cat = $cat[0];
            echo get_category_parents($cat, true, ' ' . $delimiter . ' ');
            echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
            if ($showCurrent == 1) {
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            }
        } elseif (is_page() && !$post->post_parent) {
            if ($showCurrent == 1) {
                echo $before . get_the_title() . $after;
            }
        } elseif (is_page() && $post->post_parent) {
            $parent_id  = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_post($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id  = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            for ($i = 0; $i < count($breadcrumbs); $i++) {
                echo $breadcrumbs[$i];
                if ($i != count($breadcrumbs) - 1) {
                    echo ' ' . $delimiter . ' ';
                }
            }
            if ($showCurrent == 1) {
                echo ' ' . $delimiter . ' ' . $before . get_the_title() . $after;
            }
        } elseif (is_tag()) {
            echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $before . 'Articles posted by ' . $userdata->display_name . $after;
        } elseif (is_404()) {
            echo $before . 'Error 404' . $after;
        }
        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                echo ' (';
            }
            echo __('Page') . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) {
                echo ')';
            }
        }
        echo '</span>';
    }
} // end the_breadcrumb()


/** 
 * Snippet Name: List your authors 
 * Snippet URL: https://wpcustoms.net/snippets/list-authors/ 
 */
// usage: echo wpc_list_authors();  

add_filter('rcl_content_user', 'get_role_user', 1, 2);
function get_role_user($content_lk, $user_id) {
    $rolesEn = array('administrator', 'editor', 'author', 'contributor', 'subscriber');
    $rolesRu = array('Администратор', 'Редактор', 'Автор', 'Участник', 'Подписчик');

    $user_data = get_userdata($user_id);
    $roles = $user_data->roles;
    $role = array_shift($roles);
    $content_lk .= $rolesRu[array_search($role, $rolesEn)];
    return $content_lk;
}

function wpc_list_authors() {
    $authors = get_users(
        array(
            'orderby'       => 'display_name',
            'count_totals'  => false,
            // 'who'           => 'authors',  // change to different user role if required 
            'exclude'       => array(11),
            'role__in'      => array('author', 'editor'),
            'role__not_in'  => array('administrator'),

        )
    );

    $list = '';
    if ($authors) :
        $list .= '<ul class="wpc-list-authors">';
        foreach ($authors as $author) :
            $list .= '<li class="item">';
            $archive_url = get_author_posts_url($author->ID);
            $list .= get_avatar($author->user_email, 120);
            $list .= '<div class="count" title="Количество записей автора">' . count_user_posts($author->ID, "post", true) . '</div>';
            $list .= '<div class="info"><div class="name"><a href="' . $archive_url . '" title="' . __('View all posts by ', 'knowhow') . $author->display_name . '">' . $author->display_name . '</a></div></div>';
            $list .= '<div class="role">' . get_role_user('', $author->ID) . '</div>';
            $list .= '<div class="desc">' . get_user_meta($author->ID, 'description', true) . '</div>';
            // $list .= '<div class="link-to-posts"><a href="' . $archive_url . '" title="' . __('View all posts by ', 'knowhow') . $author->display_name . '">' . __('View author\'s posts', 'knowhow') . '</a></div>';

            $list .= '</li>';
        endforeach;
        $list .= '</ul>';
    endif;
    return $list;
}

/** 
 * 
 * 
 */

if (current_user_can('subscriber')) {
    add_filter('show_password_fields', '__return_false');
}

// add_action('admin_init', 'disable_dashboard');
// function disable_dashboard() {
//     if (current_user_can('subscriber') && is_admin()) {
//         wp_redirect(home_url()));
//         exit;
//     }
// }


// add_action('admin_init', 'disable_admin_bar');
// function disable_admin_bar() {
//     if (current_user_can('subscriber')) {
//         show_admin_bar(false);
//     }
// }


function disable_user_profile() {
    if (is_admin()) {
        $user = wp_get_current_user();
        if (12 == $user->ID) {
            // wp_die('Администратор заблокировал вам доступ к этому разделу. Просто наслаждайтесь контентом... На главную :)');
            if (current_user_can('subscriber') && is_admin()) {
                wp_redirect(home_url());
                exit;
            }
        }
    }
}
add_action('load-profile.php', 'disable_user_profile');
add_action('load-user-edit.php', 'disable_user_profile');
