<?php get_header(); ?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div id="content" class="site-content" role="main">

                <?php while (have_posts()) : the_post(); ?>

                    <?php get_template_part('content', 'page'); ?>

                    <?php comments_template('', true); ?>

                <?php endwhile; // end of the loop. ?>

            </div><!-- #content .site-content -->
        </div><!-- #primary .content-area -->
        <div class="col-md-3">
        <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>