<?php
if (get_the_author_meta('description') != '') { ?>
<section id="entry-coauthors" class="clearfix">
    <?php if (!is_author()) { ?><h3 id="entry-author-title">Все авторы публикации</h3><?php } ?>

    <div class="co-names">
        <?php echo do_shortcode('[publishpress_authors_data]'); ?>
    </div>
</section>
<?php } ?>