<?php
$st_post_meta = (array)  apply_filters('knowhow_get_theme_option', 'st_article_meta', array('date' => 1, 'author' => 1, 'category' => 1, 'comments' => 1));
$number = get_comments_number(get_the_ID()); ?>
<div style="border-bottom: 1px solid #1D2327; margin-bottom: 30px">
  <?php if (($st_post_meta['date'] == 1) || ($st_post_meta['author'] == 1) || ($st_post_meta['category'] == 1) || ($st_post_meta['comments'] == 1)) { ?>
    <ul class="entry-meta clearfix">
      <li class="meta-title">Мета данные:</li>
      <?php if ($st_post_meta['date'] == 1) { ?>
        <li class="date">
          <i class="fa fa-calendar" aria-hidden="true"></i>
          <time datetime="<?php the_time('Y-m-d') ?>" itemprop="datePublished"><?php the_time(get_option('date_format')); ?></time>
        </li>
      <?php } ?>

      <?php if ($st_post_meta['author'] == 1) { ?>
        <li class="author">
          <i class="fa fa-user"></i>
          <?php
          // the_author(); 
          echo do_shortcode('[publishpress_authors_data]');
          ?>
        </li>
      <?php } ?>

      <?php if (($st_post_meta['category'] == 1) && (!in_category('1'))) { ?>
        <!-- <li class="category">
        <i class="fa fa-folder-close"></i>
        <?php // the_category(' / '); 
        ?>
    </li> -->
      <?php } ?>

      <?php if (($st_post_meta['comments'] == 1) && ($number != 0)) { ?>
        <?php if (comments_open()) { ?>
          <li class="comments">
            <i class="fa fa-comment"></i>
            <?php comments_popup_link(__('0 Comments', 'knowhow'), __('1 Comment', 'knowhow'), __('% Comments', 'knowhow')); ?>
          </li>
        <?php } ?>
      <?php } ?>
    </ul>
    <ul class="entry-meta meta2 clearfix">
      <li class="meta-title">Иерархия:</li>
      <li class="new-crumbs"><?php if (function_exists('the_breadcrumb')) the_breadcrumb(); ?></li>
    </ul>
    <ul class="entry-meta meta2 clearfix">
      <li class="meta-title">Теги:</li>
      <li class="new-tags"><?php the_tags('', '<span class="tags-separator">&bull;</span>', ''); ?>
      </li>
    </ul>
</div>
<?php } ?>