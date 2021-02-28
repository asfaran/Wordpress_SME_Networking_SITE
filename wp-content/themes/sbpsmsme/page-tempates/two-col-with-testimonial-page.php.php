<?php
/*
  Template Name: Two Column with Testimonial
 */

get_header();

$side_bar_array = array();
query_posts('category_name=2-col-with-testimonial&order=asc');
$i = 0;
if (have_posts())
{
    while (have_posts())
    {
        the_post();
        $side_bar_array[$i]['title'] = get_the_title();
        $side_bar_array[$i]['summary'] = get_the_excerpt();
        $side_bar_array[$i]['link'] = get_the_permalink();
        $i++;
    }
}
wp_reset_query();
?>

<!-- BEGIN CONTAINER -->   
<div class="container min-hight">
    <?php while (have_posts()) : the_post(); ?>
        <div class="col-md-12 margin-bottom-40 col-sm-12">
            <span style="text-align:center"><h2 class="post-page-title"><?php the_title(); ?></h2></span>
        </div>    
        <!-- BEGIN ABOUT INFO -->   
        <div class="row margin-bottom-40">
            <!-- BEGIN INFO BLOCK -->               
            <div class="col-md-8 space-mobile">
                <?php the_content(); ?>
            </div>
            <!-- END INFO BLOCK -->   

            <!-- BEGIN CAROUSEL -->   
            <div class="col-md-4">
                <?php foreach ($side_bar_array as $side_bar_content) : ?>
                    <div class="well">
                        <!-- Carousel items -->
                        <h4><?php echo $side_bar_content['title'] ?></h4>
                        <p><?php echo $side_bar_content['summary'] ?></p>
                        <a href="<?php echo $side_bar_content['link'] ?>" title="<?php echo $side_bar_content['title'] ?>" class="more">More</a>
                    </div>    
                <?php endforeach; ?>

            </div>
            <!-- END CAROUSEL -->             
        </div>
    <?php endwhile; ?>
    <!-- END ABOUT INFO -->   

    <?php sbpsmsme_get_content_testimonial() ?>
    <!-- END OUR TEAM -->		</div>
<!-- END CONTAINER -->

<?php get_footer(); ?>