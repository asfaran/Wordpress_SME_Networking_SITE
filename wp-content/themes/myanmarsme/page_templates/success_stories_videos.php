<?php

/*

  Template Name: Success Stories Video

 */

define('SUBMENU_ITEM','');

get_header();

?>
<style>

.brightness{
    height:418px;
}

	.top_banner_header{
		background-image:  url('<?php echo get_template_directory_uri(); ?>/images/success_stories_small.jpg');
	}
        
        @media (min-width: 1800px) {
		.top_banner_header{
			background-image:  url('<?php echo get_template_directory_uri(); ?>/images/success-hd.jpg');
		}
	}
	
	@media (min-width: 992px) {
		.top_banner_header{
			background-image:  url('<?php echo get_template_directory_uri(); ?>/images/success_stories_small.jpg');
		}
	}
	
	
	@media (max-width: 992px) {
		.top_banner_header{
			background-image:  url('<?php echo get_template_directory_uri(); ?>/images/success_stories_small.jpg');
		}
	}
	
	@media(max-width:767px){
		.top_banner_header{
			background-image:  url('<?php echo get_template_directory_uri(); ?>/images/success_stories_small.jpg');
		}
	}
</style>


    <!-- BEGIN PAGE CONTAINER -->  

    <div class="page-container page-body">

	

        <!-- BEGIN REVOLUTION SLIDER -->
        <div class="top_banner_header img-responsive" >
            
	</div>
        <!-- END REVOLUTION SLIDER --> 

        

        

        <div class="clearfix"></div>

        

        <div class="row margin-bottom-40">

            <!-- BEGIN CONTAINER -->

    		    <div class="container margin-bottom-40">

                	<div class="col-md-12 text-center padding-top-40">

                	<?php 

                    $edit_class = ''; $edit_location='';

                    if (current_user_can('manage_options')) {

                        $edit_class = 'admin_udpate_spot';

                        $edit_location = 'options';

                    }

                    ?>

                    	<h3><span data-location="<?php echo $edit_location; ?>" data-id="content_page_success_stories_header_1" 

                        class="<?php echo $edit_class; ?>"><?php echo get_option('content_page_success_stories_header_1', 'content_page_success_stories_header_1')?></span></h3>

                        

                        <?php 

                        $edit_class = ''; $edit_location='';

                        if (current_user_can('manage_options')) {

                            $edit_class = 'admin_udpate_spot';

                            $edit_location = 'options';

                        }

                        ?>

                        <p id="page_intro"><span data-location="<?php echo $edit_location; ?>" data-id="content_page_success_stories_row_1" 

                        class="<?php echo $edit_class; ?>"><?php echo stripslashes(get_option('content_page_success_stories_row_1', 'content_page_success_stories_row_1'))?></span></p>

                    </div>

                </div>

        	<!-- END CONTAINER -->

        </div> <!-- END ROW -->

        

        

		<div class="clearfix"></div>

        
		
        <!-- BEGIN CONTAINER -->   

		<div class="container">
					
                    <span style="display:block; margin-top:-155px; width:0; height:115px; position:relative; visibility:inherit " id="success_stories_videos"></span>
				
                    <!-- FONT AWESOME -->

					<div class="row">

							
		                     <ul class="nav nav-tabs">

		                        <li ><a href="/success-stories#success_stories_text" id="success_stories_text">TEXT</a></li>

		                        <li class="active"><a href="/success-stories-videos#success_stories_videos" id="success_stories_videos" >VIDEOS</a></li>

		                     </ul>

                             

                    </div>

       </div>                      

		                      <!-- BEGIN TESTIMONIALS -->  

       	<div class="row  "  style="background-color:#16171b" id="success_video_module">		

                <div class="container margin-bottom-40">

                     <div class="header_title" >

                        <h3 style="color:#fff">Myanmar To your Business</h3>

                    </div>  

     	

			<div class="front-team " style="padding-bottom:20px;">

            	<p style="color:#fff;">
                <?php 
					$content = getPageContent(742);  
                    echo $content['content'];	

				?>
                
                </p>

				<!--

                <ul class="list-unstyled">

                	<?php

						$args = array(

							'post_status' 	=> 'publish',

							'post_type' 	=> 'success_story',

						);

						

						$success_videos = new WP_Query( $args );

						

						if( $success_videos->have_posts() ):

												

							while($success_videos->have_posts()):

								$success_videos->the_post();

								$id = get_the_ID();   

                                $youtube = get_post_meta(intval($id), 'sbpsmesme_field_url_youtube', true);

								$video_duration = get_post_meta(intval($id), 'sbpsmesme_duration_youtube', true);

								//print_r($youtube);

					?>

					

							<?php  if( (has_post_thumbnail()) && (!empty($youtube)) ):  ?>

                            <li class="col-md-3">

                                <div class="thumbnail">

                                    <?php 

                                        $suffix = "?controls=0&showinfo=0";

                                        $url = str_replace("watch?v=", "embed/", $youtube);

                                        

                                        ?>

                                    <a data-rel="fancybox-button"  data-fancybox-type="iframe" title="<?php  the_title(); ?> [<?php echo $video_duration; ?>]" href="<?php  echo $url.$suffix; ?>" class="fancybox-button">

                                    

                                        <?php the_post_thumbnail('video-thumbnail', array('class' => 'img-responsive')); ?>

                                        

                                     </a>

                                   

                                    

                                    <div class="youtube_title">

                                        <?php  the_title(); ?> [<?php echo $video_duration; ?>]

                                    </div>

                                    

                                </div>

                            </li>

                            <?php  endif; ?>

                    

                    	<?php  endwhile; ?>

                    

                    <?php  endif; ?>

					

				</ul>  

                -->          

			</div>

          

			<!-- END OUR TEAM -->

            

           </div> 

            

             </div>

       <!-- END TESTIMONIALS -->  

		                 

		               

					

	</div>

    <!-- END PAGE CONTAINER -->  

	

    <?php get_footer(); ?>