<?php
if (!is_user_logged_in()) {
  auth_redirect();
}
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width">
  <meta name="format-detection" content="telephone=no">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <!-- #site-container -->
  <div id="site-container" class="clearfix">

    <?php if (has_nav_menu('primary-nav')) : ?>
      <!-- #primary-nav-mobile -->
      <nav id="primary-nav-mobile">
        <a class="menu-toggle clearfix" href="#"><i class="fa fa-reorder"></i></a>
        <?php wp_nav_menu(array('theme_location' => 'primary-nav', 'container' => false, 'menu_class' => 'clearfix', 'menu_id' => 'mobile-menu',)); ?>
      </nav>
      <!-- /#primary-nav-mobile -->
    <?php endif; ?>

    <!-- #header -->
    <header id="site-header" class="clearfix" role="banner">
      <div class="ht-container" style="display:flex; flex-direction:column">

        <?php if (has_nav_menu('primary-nav')) : ?>
          <!-- #primary-nav -->
          <nav id="primary-nav" role="navigation" class="clearfix" style="">
            <?php wp_nav_menu(array('theme_location' => 'primary-nav', 'container' => false, 'menu_class' => 'nav sf-menu clearfix')); ?>
          </nav>
          <!-- #primary-nav -->
        <?php endif; ?>
        <div class="header-title" style="">
          <div class="ht-name"><?php bloginfo('name'); ?></div>
          <div class="ht-desc"><span><?php bloginfo('description'); ?></span></div>
        </div>
      </div>
    </header>
    <!-- /#header -->

    <!-- #live-search -->
    <div id="live-search">
      <div class="ht-container">
        <div id="search-wrap">
          <form role="search" method="get" id="searchform" class="clearfix" action="<?php echo home_url('/'); ?>">
            <input type="text" onfocus="if (this.value == '<?php echo apply_filters('knowhow_get_theme_option', 'st_search_text', null); ?>') {this.value = '';}" onblur="if (this.value == '')  {this.value = '<?php echo apply_filters('knowhow_get_theme_option', 'st_search_text', null); ?>';}" value="<?php echo apply_filters('knowhow_get_theme_option', 'st_search_text', null); ?>" name="s" id="s" autocapitalize="off" autocorrect="off" autocomplete="off" />
            <i class="live-search-loading fa fa-spinner fa-spin"></i>
            <button type="submit" id="searchsubmit">
              <i class='fa fa-search'></i><span><?php _e("Search", "knowhow") ?></span>
            </button>
          </form>
        </div>
      </div>
    </div>
    <!-- /#live-search -->