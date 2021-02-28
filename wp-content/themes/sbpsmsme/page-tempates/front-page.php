<?php
/*
  Template Name: MyanmarSME Home page
 */

get_header();
?>
<!-- BEGIN REVOLUTION SLIDER -->
<?php putRevSlider("slider1") ?>
<!-- END REVOLUTION SLIDER -->

<!-- BEGIN CONTAINER -->
<div class="container">
    <!-- BEGIN SERVICE BOX -->
    <div class="col-md-12 col-sm-12">
        <span style="text-align:center"><h2>ABOUT THIS PLATFORM</h2></span>
    </div>
    <div class="row service-box">
        <div class="col-md-8 col-sm-8"> 
            <?php while (have_posts()) : the_post(); ?>
            

                <?php the_content() ?>

           
			<?php endwhile; // end of the loop.  ?>
         </div> 
        <div class="col-md-4 col-sm-4">
            <div class="service-box-heading">
                <span>Customer Demographic Data</span>
            </div>
            <?php
            echo do_shortcode("[metaslider id=45]");
            ?>
        </div>
    </div>
    <!-- END SERVICE BOX -->

    <!-- BEGIN BLOCKQUOTE BLOCK -->
    <div class="col-md-12 col-sm-12">
        <span style="text-align:center"><h2>NEWS AND MEDIA PUBLICATIONS</h2></span>
    </div>
    <!-- END BLOCKQUOTE BLOCK -->

    <div class="clearfix"></div>

    <!-- BEGIN RECENT WORKS -->
    <div class="row recent-work margin-bottom-40">
        <div class="col-md-3">
            <h2><a href="portfolio.html">News Room</a></h2>
            <p>Lorem ipsum dolor sit amet, dolore eiusmod quis tempor incididunt ut et dolore Ut veniam unde voluptatem. Sed unde omnis iste natus error sit voluptatem.</p>
            <a class="btn btn-warning" href="#">Go To News Room</a>
        </div>
        <div class="col-md-9">
            <ul class="bxslider">
                <li>
                    <em>
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/news1.jpg" alt="" />
                        </a>

                    </em>
                    <a class="bxslider-block" href="#">
                        <strong>Amazing Project</strong>
                        <b>Agenda corp.</b>
                    </a>
                </li>
                <li>
                    <em>
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/news2.jpg" alt="" />
                        </a>

                    </em>
                    <a class="bxslider-block" href="#">
                        <strong>Amazing Project</strong>
                        <b>Agenda corp.</b>
                    </a>
                </li>
                <li>
                    <em>
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/news3.jpg" alt="" />
                        </a>

                    </em>
                    <a class="bxslider-block" href="#">
                        <strong>Amazing Project</strong>
                        <b>Agenda corp.</b>
                    </a>
                </li>
                <li>
                    <em>
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/news4.jpg" alt="" />
                        </a>

                    </em>
                    <a class="bxslider-block" href="#">
                        <strong>Amazing Project</strong>
                        <b>Agenda corp.</b>
                    </a>
                </li>
                <li>
                    <em>
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/news5.jpg" alt="" />
                        </a>

                    </em>
                    <a class="bxslider-block" href="#">
                        <strong>Amazing Project</strong>
                        <b>Agenda corp.</b>
                    </a>
                </li>
                <li>
                    <em>
                        <a href="#">
                            <img src="<?php echo get_template_directory_uri(); ?>/images/news6.jpg" alt="" />
                        </a>

                    </em>
                    <a class="bxslider-block" href="#">
                        <strong>Amazing Project</strong>
                        <b>Agenda corp.</b>
                    </a>
                </li>


            </ul>
        </div>
    </div>
    <!-- END RECENT WORKS -->

    <div class="clearfix"></div>

    <!-- BEGIN OUR TEAM -->    
    <?php sbpsmsme_get_content_testimonial(); ?>
    <!-- END OUR TEAM -->



    <!-- BEGIN CLIENTS -->
    
        
        
            <?php /*<ul class="bxslider1 clients-list">
                <?php query_posts('category_name=clients&order=asc'); ?>
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : ?>
                        <?php the_post(); ?>
                        <?php $img_1_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                        <?php
                        if (class_exists('kdMultipleFeaturedImages'))
                        {
                            //kd_mfi_the_featured_image('featured-image-2', 'post');
                            $img_2_url = kd_mfi_get_featured_image_url('featured-image-2', 'post', 'full');
                        }
                        ?>                        
                        <?php if (empty($img_2_url)) $img_2_url = $img_1_url; ?>
                        <li>
                            <a href="<?php the_permalink() ?>">
                                <img src="<?php echo $img_2_url; ?>" alt="" />
                                <img src="<?php echo $img_1_url[0]; ?>" class="color-img" alt="" />
                            </a>
                        </li>
                    <?php endwhile; ?>
                <?php endif; ?>                
            </ul>*/ ?>
            <?php sbpsmsme_get_clients_carsoul() ?>
    <!-- END CLIENTS -->    
</div>
<!-- END CONTAINER -->
<?php get_footer() ?>
