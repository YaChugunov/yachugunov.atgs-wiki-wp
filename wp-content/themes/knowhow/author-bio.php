<?php
if (get_the_author_meta('description') != '') { ?>
  <section id="entry-author" class="clearfix">
    <?php if (!is_author()) { ?><h3 id="entry-author-title"><?php _e('About The Author', 'knowhow') ?></h3><?php } ?>
    <div class="gravatar">
      <?php if (function_exists('get_avatar')) {
        echo get_avatar(get_the_author_meta('email'), '70');
      } ?>
    </div>
    <h4><a class="author-link" href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>" rel="author">
        <?php echo get_the_author_meta('display_name') ?>
      </a></h4>
    <div class="entry-author-email">
      <a href="mailto:<?php the_author_meta('email') ?>" title="Написать автору"><?php the_author_meta('email') ?></a>
    </div>
    <div class="entry-author-desc">
      <?php the_author_meta('description') ?>
    </div>
  </section>
<?php } ?>