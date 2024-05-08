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
	$st_hp_sidebar = 'sidebar-off';
}
?>

<!-- #primary -->
<div id="primary" class="<?php echo esc_attr($st_hp_sidebar); ?> clearfix">
    <!-- .ht-container -->
    <div class="ht-container">

        <!-- #content -->
        <section id="content" role="main">

            <?php if (have_posts()) : ?>

            <?php
				/* Queue the first post, that way we know
				 * what author we're dealing with (if that is the case).
				 *
				 * We reset this later so we can run the loop
				 * properly with a call to rewind_posts().
				 */
				the_post();
				?>

            <!-- #page-header -->
            <header id="page-header">
                <h1 class="page-title">
                    <?php printf(__('All posts by %s', 'knowhow'), '<span class="vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(get_the_author_meta('display_name')) . '" rel="me">' . get_the_author_meta('display_name') . '</a></span>'); ?>
                </h1>
            </header>
            <!-- /#page-header -->


            <?php
				/* Since we called the_post() above, we need to
				 * rewind the loop back to the beginning that way
				 * we can run the loop properly, in full.
				 */
				rewind_posts();
				?>

            <?php if (get_the_author_meta('description')) : ?>
            <?php get_template_part('author-bio'); ?>
            <?php endif; ?>

            <?php /* The loop */ ?>
            <?php while (have_posts()) : the_post(); ?>

            <?php get_template_part('content', get_post_format()); ?>

            <?php endwhile; ?>

            <?php get_template_part('page', 'navigation'); ?>

            <?php else : ?>
            <?php get_template_part('no-results', 'index'); ?>
            <?php endif; ?>

        </section>

        <!-- /#content -->
        <?php // get_sidebar(); 
		?>

    </div>
    <!-- .ht-container -->
</div>
<!-- /#primary -->

<?php get_footer(); ?>