<?php
get_header();
?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div id="content" class="site-content" role="main">

                <h1 class="page-title"><?php _e('404 Not Found', 'twentyfourteen'); ?></h1>
                <div>
                    <p><?php _e('It looks like nothing was found at this location. Maybe try a search?', 'twentyfourteen'); ?></p>

                    <?php get_search_form(); ?></div>

            </div><!-- #content .site-content -->
        </div><!-- #primary .content-area -->
        <div class="col-md-3">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>