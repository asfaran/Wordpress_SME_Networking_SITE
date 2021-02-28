<?php
/*
  Template Name: Member Welcome Page
 */
get_header();
?>
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <div id="content" class="site-content" role="main">

                <h1 class="page-title"><?php _e('Member Dashboard', 'sbpsmsme'); ?></h1>
                <hr />
                <div><p></p></div>

            </div><!-- #content .site-content -->
        </div><!-- #primary .content-area -->
        <div class="col-md-3">
            <?php get_sidebar(); ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>