<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
get_header();
?>
<div class="container">
    <div class="container">
        <div class="margin-bottom-20 margin-top-20">
            FILTER BY: 	<button class="btn default"><i class="fa fa-angle-left"></i>ABC</button>
            <button class="btn default">ABC</button>
            <button class="btn default">ABC</button>
            <button class="btn default">ABC</button>
        </div>
    </div>
    <!-- BEGIN BLOG -->
    <div class="row">
        <!-- BEGIN LEFT SIDEBAR -->            
        <div class="col-md-9 col-sm-9 blog-posts margin-bottom-40">

            <?php while (have_posts()) : the_post(); ?>
                <div class="row">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="col-md-4 col-sm-4">                                                
                            <?php $large_image_url = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large'); ?>                        
                            <img src="<?php echo $large_image_url[0]; ?>" alt="" class="img-responsive">
                        </div>
                    <?php endif; ?>
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="col-md-8 col-sm-8">
                        <?php else : ?>
                            <div class="col-md-12 col-sm-12">
                            <?php endif; ?>
                            <h2><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h2>
                            <ul class="blog-info">
                                <li><i class="fa fa-calendar"></i> <?php echo get_the_date() ?></li>
                                <li><i class="fa fa-tags"></i> <?php the_author() ?></li>
                            </ul>
                            <p><?php the_excerpt() ?></p>
                            <a class="more" href="<?php the_permalink() ?>">Read more <i class="icon-angle-right"></i></a>
                        </div>
                    </div>

                    <hr class="blog-post-sep">
                <?php endwhile; // end of the loop. ?>

                <!-- Add the pagination functions here. -->

                <?php wp_pagenavi(); ?>              
            </div>
            <!-- END LEFT SIDEBAR -->

            <!-- BEGIN RIGHT SIDEBAR -->            
            <div class="col-md-3 col-sm-3 blog-sidebar">
                <!-- CATEGORIES START -->
                <h3>Sponsored Content</h3>
                <div class="margin-bottom-40">
                    <img src="images/service_p1.jpg" alt="" class="img-responsive"> 
                </div>
                <!-- CATEGORIES END -->

                <!-- BEGIN RECENT NEWS -->                            

                <div class="margin-bottom-40">
                    <img src="images/service_p2.jpg" alt="" class="img-responsive"> 
                </div>
                <!-- END RECENT NEWS -->                            

                <!-- BEGIN BLOG TALKS -->
                <div class="margin-bottom-40">
                    <img src="images/service_p3.jpg" alt="" class="img-responsive"> 
                </div>                            
                <!-- END BLOG TALKS -->



            </div>
            <!-- END RIGHT SIDEBAR -->            
        </div>
        <!-- END BEGIN BLOG -->

        <div class="clearfix"></div>

        <!-- BEGIN SERVICE BOX -->  
        <div class="col-md-12 col-sm-12">
            <span style="text-align:center"><h2>RESOURCES</h2></span>
        </div> 

        <div class="row service-box">
            <div class="col-md-3 col-sm-3">
                <div class="service-box-heading">

                    <span>Myanman Uses Technology To Leapfrog Its SME Sector</span>
                </div>
                <p>Lorem ipsum dolor sit amet, dolore eiusmod quis tempor incididunt ut et dolore Ut veniam unde nostrudlaboris. Sed unde omnis iste natus error sit voluptatem.</p>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="service-box-heading">

                    <span>Linking Myanmar To The Global Village</span>
                </div>
                <p>Lorem ipsum dolor sit amet, dolore eiusmod quis tempor incididunt ut et dolore Ut veniam unde nostrudlaboris. Sed unde omnis iste natus error sit voluptatem.</p>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="service-box-heading">

                    <span>UNESCAP &amp; UMFCCI Supporting SME Initiative</span>
                </div>
                <p>Lorem ipsum dolor sit amet, dolore eiusmod quis tempor incididunt ut et dolore Ut veniam unde nostrudlaboris. Sed unde omnis iste natus error sit voluptatem.</p>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="service-box-heading">

                    <span>ASEAN 2015 And Future Of The GM</span>
                </div>
                <p>Lorem ipsum dolor sit amet, dolore eiusmod quis tempor incididunt ut et dolore Ut veniam unde nostrudlaboris. Sed unde omnis iste natus error sit voluptatem.</p>
            </div>
        </div>
        <!-- END SERVICE BOX -->  
    </div>   

    <?php get_footer(); ?>