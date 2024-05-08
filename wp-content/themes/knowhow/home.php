<?php

function check_if_category_has_child() {
  $term = get_queried_object();
  $children = get_terms($term->taxonomy, array(
    'parent'    => $term->term_id,
    'hide_empty' => false
  ));
  return $children;
}
//
//

function getLevelSubCat($category) {
  $parent_id = $category->parent;
  $level = 0;
  while ($parent_id != 0) {
    $level++;
    $category = get_category($parent_id);
    $parent_id = $category->parent;
  }
  return $level;
}
//
//
// Только для категорий и только тех где есть дочерние рубрики
if (is_category() and check_if_category_has_child()) {
} else {
  // Иначе ничего не выводим или выводим что-то здесь.
}
?>

<?php get_header(); ?>

<?php
// Get HP sidebar position
$st_hp_sidebar = apply_filters('knowhow_get_theme_option', 'st_hp_sidebar', null);
if ($st_hp_sidebar == 'fullwidth') {
  $st_hp_sidebar = 'sidebar-off';
} elseif ($st_hp_sidebar == 'sidebar-l') {
  $st_hp_sidebar = 'sidebar-left';
} elseif ($st_hp_sidebar == 'sidebar-r') {
  $st_hp_sidebar = 'sidebar-right';
} else {
  $st_hp_sidebar = 'sidebar-right';
}
?>


<!-- #primary -->
<div id="primary" class="<?php echo esc_attr($st_hp_sidebar); ?> clearfix">
    <!-- .ht-container -->
    <div class="ht-container">

        <!-- #content -->
        <section id="content" role="main">

            <!-- <header id="page-header">
        <h2 class="page-title">
          <?php _e('Article Categories', 'knowhow') ?>*
        </h2>
      </header> -->

            <?php
      // Массив категорий первого уровня, которые мы выводим
      $parentCatsArr = array(168, 25, 171, 172, 21);
      foreach ($parentCatsArr as $parentCat) {

        // Get homepage options
        $st_hp_category_exclude = 0;
        $st_hp_category_exclude = apply_filters('knowhow_get_theme_option', 'st_hp_cat_exclude', null);

        $st_hp_subcategory_exclude = 0;
        $st_hp_subcategory_exclude = apply_filters('knowhow_get_theme_option', 'st_hp_subcat_exclude', null);
      ?>
            <div id="homepage-categories" class="clearfix">
                <h3 class="parentCat-title"><?php echo get_cat_name($parentCat) ?>.</h3>

                <?php
          // Set category counter
          $st_cat_counter = 0;
          // Base Category Query
          $st_hp_cat_args = array(
            'orderby'       => 'name',
            'order'         => 'asc',
            'hierarchical'  => true,
            'hide_empty'    => 0,
            'exclude'       => $st_hp_category_exclude,
            'pad_counts'    => 1
          );
          $st_categories = get_categories($st_hp_cat_args);
          $st_categories = wp_list_filter($st_categories, array('parent' => $parentCat));
          // If there are catgegories
          if ($st_categories) {
            foreach ($st_categories as $st_category) {
              $st_cat_counter++;

              if ((!is_int($st_cat_counter / 2)) && $st_cat_counter != 1) {
                echo '</div><div class="row">';
              } elseif ($st_cat_counter == 1) {
                echo '<div class="row">';
              }

              echo '<div class="column col-half ' . $st_cat_counter . '">';
              echo '<h3> <a href="' . get_category_link($st_category->term_id) . '" title="' . sprintf(__('View all posts in %s', 'knowhow'), $st_category->name) . '" ' . '>' . $st_category->name . '</a>';
              if (apply_filters('knowhow_get_theme_option', 'st_hp_cat_counts', null) == '1') {
                echo '<span class="cat-count">(' . $st_category->count . ')</span>';
              }
              echo '</h3>';

              // Sub category
              $st_sub_category = get_category($st_category);
              $st_subcat_args = array(
                'orderby'     => 'name',
                'order'       => 'ASC',
                'exclude'     => $st_hp_subcategory_exclude,
                'child_of'    => $st_sub_category->cat_ID,
                'pad_counts'  => 1
              );
              $st_sub_categories = get_categories($st_subcat_args);
              $st_sub_categories = wp_list_filter($st_sub_categories, array('parent' => $st_sub_category->cat_ID));

              // If there are sub categories show them
              if ($st_sub_categories && (apply_filters('knowhow_get_theme_option', 'st_hp_subcat', null) == 1)) {
                echo '<ul class="sub-categories">';
                foreach ($st_sub_categories as $st_sub_category) {
          ?>
                <li>
                    <h4><?php echo '<a href="' . get_category_link($st_sub_category->term_id) . '" title="' . sprintf(__('View all posts in %s', 'knowhow'), $st_sub_category->name) . '" ' . '>' . $st_sub_category->name . '</a>';
                        if (apply_filters('knowhow_get_theme_option', 'st_hp_subcat_counts', null) == '1') {
                          echo '<span class="cat-count">(' . $st_sub_category->count . ')</span>';
                        } ?></h4>
                </li>
                <?php
                  // --- -- --- -- --- -- ---
                  //List Posts
                  $st_cat_post_num = apply_filters('knowhow_get_theme_option', 'st_hp_cat_postnum2', '999999');
                  $st_posts_order = apply_filters('knowhow_get_theme_option', 'st_hp_cat_posts_order', 'name');
                  global $post;
                  // If show posts is 0 do nothing
                  if ($st_cat_post_num != 0) {
                    // Listed by popular?
                    if ($st_posts_order == 'meta_value_num') {
                      $st_cat_post_args = array(
                        'numberposts'   => $st_cat_post_num,
                        'orderby'       => 'name',
                        'order'         => 'asc',
                        'meta_key'      => '_st_post_views_count',
                        'category__in'  => $st_sub_category->term_id
                      );
                    } else {
                      $st_cat_post_args = array(
                        'numberposts'   => $st_cat_post_num,
                        'orderby'       => 'name',
                        'order'         => 'asc',
                        'category__in'  => $st_sub_category->term_id
                      );
                    }
                    $st_cat_posts = get_posts($st_cat_post_args);
                    echo '<ul class="category-posts">';
                    foreach ($st_cat_posts as $post) : setup_postdata($post);
                      // Set post format class
                      if (has_post_format('video')) {
                        $st_postformat_class = 'video';
                      } else {
                        $st_postformat_class = 'standard';
                      }
                  ?>
                <li class="format-<?php echo esc_attr($st_postformat_class); ?>"><a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a></li>
                <?php endforeach;
                    echo '</ul>';
                  }
                  // --- -- --- -- --- -- ---

                  // Sub category
                  $st_subsub_category = get_category($st_sub_category);
                  $st_subsubcat_args = array(
                    'orderby' => 'name',
                    'order' => 'asc',
                    'exclude' => $st_hp_subcategory_exclude,
                    'child_of' => $st_subsub_category->cat_ID,
                    'pad_counts'  => 1
                  );
                  $st_subsub_categories = get_categories($st_subsubcat_args);
                  $st_subsub_categories = wp_list_filter($st_subsub_categories, array('parent' => $st_subsub_category->cat_ID));
                  if ($st_subsub_categories && (apply_filters('knowhow_get_theme_option', 'st_hp_subcat', null) == 1)) {
                    echo '<ul class="subsub-categories">';
                    foreach ($st_subsub_categories as $st_subsub_category) {
                    ?>
                <li>
                    <h4><?php echo '<a href="' . get_category_link($st_subsub_category->term_id) . '" title="' . sprintf(__('View all posts in %s', 'knowhow'), $st_subsub_category->name) . '" ' . '>' . $st_subsub_category->name . '</a>';
                            if (apply_filters('knowhow_get_theme_option', 'st_hp_subcat_counts', null) == '1') {
                              echo '<span class="cat-count">(' . $st_subsub_category->count . ')</span>';
                            } ?></h4>
                </li>



                <?php
                      // --- -- --- -- --- -- ---
                      //List Posts
                      $st_cat_post_num = apply_filters('knowhow_get_theme_option', 'st_hp_cat_postnum2', '999999');
                      $st_posts_order = apply_filters('knowhow_get_theme_option', 'st_hp_cat_posts_order', 'name');
                      global $post;
                      // If show posts is 0 do nothing
                      if ($st_cat_post_num != 0) {
                        // Listed by popular?
                        if ($st_posts_order == 'meta_value_num') {
                          $st_cat_post_args = array(
                            'numberposts'   => $st_cat_post_num,
                            'orderby'       => 'name',
                            'order'         => 'asc',
                            'meta_key'      => '_st_post_views_count',
                            'category__in'  => $st_subsub_category->term_id
                          );
                        } else {
                          $st_cat_post_args = array(
                            'numberposts'   => $st_cat_post_num,
                            'orderby'       => 'name',
                            'order'         => 'asc',
                            'category__in'  => $st_subsub_category->term_id
                          );
                        }
                        $st_cat_posts = get_posts($st_cat_post_args);
                        echo '<ul class="category-posts">';
                        foreach ($st_cat_posts as $post) : setup_postdata($post);
                          // Set post format class
                          if (has_post_format('video')) {
                            $st_postformat_class = 'video';
                          } else {
                            $st_postformat_class = 'standard';
                          }
                      ?>
                <li class="format-<?php echo esc_attr($st_postformat_class); ?>"><a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a></li>
                <?php endforeach;
                        echo '</ul>';
                      }
                      // --- -- --- -- --- -- ---



                    }
                    echo '</ul>';
                  }


                  // --- -- --- -- --- -- ---
                }
                echo '</ul>';
              }
              echo '</div>';
            }
          }
          ?>
            </div>
            <?php } ?>
    </div>

    </section>
    <!-- #content -->

    <?php if (apply_filters('knowhow_get_theme_option', 'st_hp_sidebar', null) != 'fullwidth') {   ?>
    <?php get_sidebar(); ?>
    <?php } ?>

</div>
<!-- /.ht-container -->
</div>
<!-- #primary -->

<?php get_footer(); ?>