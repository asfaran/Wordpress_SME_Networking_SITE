<?php
/**
 * @package adamos
 * @since adamos 1.0
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if (is_search()) : ?> 
        <div class="margin-bottom-10 margin-top-20">
            <span style="text-align:left"><h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4></span>
        </div>
    <?php else : ?>            
        <div class="col-md-12 margin-bottom-40 col-sm-12">
            <span style="text-align:center"><h2 class="post-page-title"><?php the_title(); ?></h2></span>
        </div>
    <?php endif; ?>

    <?php $img_featured = wp_get_attachment_image(get_post_thumbnail_id($post->ID), 'full'); ?>
    
    <?php if (is_search()) : // Only display Excerpts for Search ?>
        <div class="entry-summary">
            <?php the_excerpt(); ?>
        </div><!-- .entry-summary -->
    <?php else : ?>
        <div class="entry-content">
            <div><?php echo $img_featured; ?></div>
            <?php the_content(__('Read More <span class="meta-nav">&rarr;</span>', 'adamos')); ?>
            <?php wp_link_pages(array('before' => '<div class="page-links">' . __('Pages:', 'adamos'), 'after' => '</div>')); ?>
        </div><!-- .entry-content -->
    <?php endif; ?>

    <footer class="entry-meta">
        <?php if ('post' == get_post_type()) : // Hide category and tag text for pages on Search ?>
            <?php
            /* translators: used between list items, there is a space after the comma */
            $categories_list = get_the_category_list(__(', ', 'adamos'));
            if ($categories_list && sbpsmsme_categorized_blog()) :
                ?>
                <span class="cat-links">
                    <?php printf(__('Posted in %1$s', 'adamos'), $categories_list); ?>
                </span>
            <?php endif; // End if categories ?>

            <?php
            /* translators: used between list items, there is a space after the comma */
            $tags_list = get_the_tag_list('', __(', ', 'adamos'));
            if ($tags_list) :
                ?>
                <span class="sep"> | </span>
                <span class="tag-links">
                    <?php printf(__('Tagged %1$s', 'adamos'), $tags_list); ?>
                </span>
            <?php endif; // End if $tags_list ?>
        <?php endif; // End if 'post' == get_post_type() ?>

        <?php if (!post_password_required() && ( comments_open() || '0' != get_comments_number() )) : ?>
            <span class="sep"> | </span>
            <span class="comments-link"><?php comments_popup_link(__('Leave a comment', 'adamos'), __('1 Comment', 'adamos'), __('% Comments', 'adamos')); ?></span>
        <?php endif; ?>

        <?php edit_post_link(__('Edit', 'adamos'), '<span class="sep"> | </span><span class="edit-link">', '</span>'); ?>
    </footer><!-- .entry-meta -->
</article><!-- #post-<?php the_ID(); ?> -->
<p>&nbsp;</p>
