<?php get_header(); ?>

<!-- #primary-->
<div id="primary" class="<?php if (apply_filters('knowhow_get_theme_option', 'st_hp_sidebar', null) == 'fullwidth') {
                            echo 'sidebar-off';
                          } elseif (apply_filters('knowhow_get_theme_option', 'st_hp_sidebar', null) == 'sidebar-l') {
                            echo 'sidebar-left';
                          } else {
                            echo 'sidebar-right';
                          } ?> clearfix">
  <!-- .ht-container -->
  <div class="ht-container">

    <!-- #content-->
    <section id="content" role="main">

      <!-- #page-header -->
      <header id="page-header" class="clearfix">
        <h1 class="page-title"><?php _e('Articles Tagged: ', 'knowhow'); ?><?php single_tag_title(); ?></h1>
        <?php if (tag_description()) : // Show an optional tag description 
        ?>
          <div class="archive-meta"><?php echo tag_description(); ?></div>
        <?php endif; ?>
      </header>
      <!-- /#page-header -->

      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

          <?php get_template_part('content', get_post_format()); ?>

        <?php endwhile;  ?>

        <?php get_template_part('page', 'navigation'); ?>

      <?php else : ?>

        <?php get_template_part('no-results', 'index'); ?>

      <?php endif; ?>



    </section>
    <!-- /#content-->

    <?php if (apply_filters('knowhow_get_theme_option', 'st_hp_sidebar', null) != 'fullwidth') {   ?>
      <?php get_sidebar(); ?>
    <?php } ?>

  </div>
  <!-- .ht-container -->
</div>
<!-- /#primary -->

<?php get_footer(); ?>