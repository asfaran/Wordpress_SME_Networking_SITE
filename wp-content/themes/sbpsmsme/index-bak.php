<?php
/**
 * The Template for displaying all single posts.
 *
 * @package adamos
 * @since adamos 1.0
 */
get_header();
?>
<div class="container min-hight">
    <div class="col-md-12 margin-bottom-20 col-sm-12">
        <span style="text-align:center"><h2><?php bloginfo('name') ?></h2></span>
    </div>
    <div class="row">
        <div class="col-md-9">
            <div id="content" class="site-content margin-bottom-40" role="main">
                <?php $print_hr = FALSE; ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php if ($print_hr) echo '<hr class="blog-post-sep">'; ?>
                    <div>
                        <h4><a href="<?php echo get_the_permalink() ?>"><?php the_title(); ?></a></h4>
                        <ul class="blog-info">
                            <li><i class="fa fa-calendar"></i> <?php the_date() ?></li>
                        </ul>
                        <?php the_excerpt(); ?>
                        <?php if (is_search()) : ?>
                        <div class="link-text-in-url">
                            <a href="<?php echo get_the_permalink() ?>" title="<?php the_title(); ?>">
                                <i class="fa  fa-chain"></i> <?php echo get_the_permalink() ?></a></div>
                        <?php endif; ?>
                    </div>                    

                    <?php $print_hr = TRUE; ?>
                <?php endwhile; // end of the loop. ?>
                <?php if (!is_single()) : ?>
                    <div class="text-center" style="margin-top:20px;">
                        <div><?php wp_pagenavi(); ?>  </div>
                    </div>                
                <?php endif; ?>
            </div><!-- #content .site-content -->
        </div><!-- #content .site-content -->
        <div class="col-md-3">
            <?php get_sidebar(); ?>
        </div>
    </div><!-- #primary .content-area -->    
</div>
<?php get_footer(); ?>
