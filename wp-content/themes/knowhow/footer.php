<!-- #footer-widgets -->
<?php if ( is_active_sidebar( 'st_footer_widgets' )) { ?>
  <div id="footer-widgets" class="clearfix">
    <!-- .ht-container -->
    <div class="ht-container">

      <div class="row stacked"><?php dynamic_sidebar( 'st_footer_widgets' ); ?></div>

    </div>
  </div>
<?php } ?>
<!-- /#footer-widgets -->

<!-- #site-footer -->
<footer id="site-footer" class="clearfix" role="contentinfo">
  <div class="ht-container">

    <?php if ( has_nav_menu( 'footer-nav' ) ) { /* if menu location 'footer-nav' exists then use custom menu */ ?>
    <nav id="footer-nav" role="navigation">
      <?php wp_nav_menu( array('theme_location' => 'footer-nav', 'depth' => 1, 'container' => false, 'menu_class' => 'nav-footer clearfix' )); ?>
    </nav>
  <?php } ?>

  <small id="copyright">
      <?php echo apply_filters( 'knowhow_get_theme_option', 'st_footer_copyright', '&#169; ' . get_bloginfo('name') ); ?>
  </small>
  
</div>
<!-- /.ht-container -->
</footer> 
<!-- /#site-footer -->

<!-- /#site-container -->
</div>

<?php wp_footer(); ?>
</body>
</html>