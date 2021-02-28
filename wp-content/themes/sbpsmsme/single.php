<?php
/**
 * The Template for displaying all single posts.
 *
 * @package adamos
 * @since adamos 1.0
 */
sbps_check_permission("sme-post");
get_header();
?>
<div class="container">
    <div class="row">
        <div class="col-md-9">

            <?php while (have_posts()) : the_post(); ?>

                <?php get_template_part('content', 'single'); ?>

                <?php //sbpsmsme_content_nav('nav-below'); ?>

                <?php
                // If comments are open or we have at least one comment, load up the comment template
                if (comments_open() || '0' != get_comments_number())
                    comments_template('', true);
                ?>

            <?php endwhile; // end of the loop. ?>

        </div><!-- #content .site-content -->
        <div class="col-md-3">
            <?php get_sidebar(); ?>
        </div>
    </div><!-- #primary .content-area -->    
    <?php if (has_category('clients')) : ?>
    <?php sbpsmsme_get_clients_carsoul() ?>
    <?php endif; ?>
</div>
<?php get_footer(); ?>
