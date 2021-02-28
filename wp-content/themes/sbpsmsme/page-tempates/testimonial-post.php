<?php
/*
  Template Name Posts: Testimonial
 */

get_header();
?>
<div class="container">
    <div id="primary" class="content-area">
        <div id="content" class="site-content" role="main">            
            <?php while (have_posts()) : the_post(); ?>

                <div class="row"><div class="col-md-3">
                        <?php //get_template_part('content', 'single'); ?>
                        <div class="col-md-12 col-sm-12">
                            <span style="text-align:left"><h2 class="post-page-title"><?php the_title(); ?></h2></span>
                        </div>

                        <div class="pic" style="text-align: left">
                            <?php
                            if (( function_exists('has_post_thumbnail') ) && ( has_post_thumbnail() ))
                            {
                                the_post_thumbnail('thumbnail');
                            }
                            else
                            {
                                ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/img/no-thumbnail.jpg" width="260" height="260">
                            <?php } ?>
                        </div>

                        <?php $meta = get_post_meta(get_the_ID(), 'job_title', true) ?>            
                        <div style="text-align:left"><h3><small><?php echo $meta; ?></small></h3></div>
                        <p>&nbsp;</p>
                    </div>
                    <div class="col-md-9">
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>
                        <?php the_content(); ?>
                        </p>
                    </div></div>

                <div class="row"><div class="col-md-12">
                        <?php
                        // If comments are open or we have at least one comment, load up the comment template
                        if (comments_open() || '0' != get_comments_number())
                            comments_template('', true);
                        ?>
                        <?php //the_meta();  ?>   
                    </div></div>

            <?php endwhile; // end of the loop.  ?>

        </div><!-- #content .site-content -->
        <div class="row">
            <?php sbpsmsme_get_content_testimonial() ?>
        </div>
    </div><!-- #primary .content-area -->
    <?php //get_sidebar();   ?>    
</div>
<?php get_footer(); ?>