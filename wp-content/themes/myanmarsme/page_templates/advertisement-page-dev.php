<?php
/*
  Template Name: Advertisement Page
 */
get_header();
?>


    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body">
        <?php
                $banner_name = "";
                $image = "";

                $image_res= biz_portal_get_advertisement('ADS_TYPE_ABOUT');

                if (!empty($image_res->image_id)):
                        $img_id=$image_res->image_id;
                        $image=biz_portal_get_file_url($img_id);
                else: 
                        $image =  get_template_directory_uri() . "/images/about_img.jpg";
                endif;
				?>    
        <div class="top_banner_header img-responsive" alt="About MyanmarSMELink" style="background-image:  url('<?php echo $image; ?>')">
	</div>
        
    	
        <!-- BEGIN CONTAINER -->   
<!--        <div class="container">-->
           
            <div class="row ">
                <div class="col-md-10 col-sm-10 col-md-offset-1">
                	<?php $content = getPageContent(get_option( 'ads_page_row_one' ));  ?>
                   
                    <div class="about_parag_left">
                    	<?php echo $content['content'];	   ?>
                    </div>
                 
                </div>
            </div>  
<!--        </div>-->
        <div class="clearfix"></div>
        
        <div class="row " style="background-color:#f8f9fe">
                <div class="col-md-10 col-sm-10 col-md-offset-1" >
                        
                             <?php $content = getPageContent(get_option( 'ads_page_row_two' ));  ?>
                          
                            <div class=" about_parag_left">
                               <?php echo $content['content'];	   ?>
                            </div>    
                </div>
        </div>
        <div class="clearfix"></div>
        
<!--        <div class="container">-->
            <div class="row ">
                <div class="col-md-10 col-sm-10 col-md-offset-1">
                	<?php $content = getPageContent(get_option( 'ads_page_row_three' ));  ?>
                      
                         <div class=" about_parag_left">
                            <?php echo $content['content'];	   ?>
                                                      
                        </div>
                </div>
            </div>
<!--            </div> -->
        <!-- END CONTAINER -->

        <div class="clearfix"></div>
        
         <!-- BEGIN Success Stories SLIDER --> 
        <div class="row " >
        
        	<div>
        
				<div id="carousel-success-stories" class="carousel slide" data-ride="carousel">
                        
                         <div class="header_title" style="position:absolute"><h3 style="color:#fff;text-shadow:0 1px 2px rgba(0,0,0,0.6);"><strong>SUCCESS STORIES</strong></h3></div> 
                         
                         
                      <a href="/success-stories">
					  	<img src="<?php echo get_template_directory_uri(); ?>/images/home_success.jpg" class="max_width" />
                      </a>
					  
					  <?php /*
					  $c = 1;
                       $args = array(
                              'post_status' => 'publish',
                              'post_type' => 'success_story',
							  'posts_per_page'  => 5,
							  'orderby' => 'rand',
						);
                       
					   $the_query = new WP_Query( $args);
					   
					   if( $the_query->have_posts()):
					  ?>
                      
                      <!-- Wrapper for slides -->
                      <div class="carousel-inner">
                      
                      		<?php
								while( $the_query->have_posts() ):
									$the_query->the_post();
							?>
                  	
                            <div class="item <?php echo ($c == 1) ? "active":""; ?>">
                                     <div class="carousel-caption">
                                            <h3 class="bold"><?php the_title(); ?></h3>
                                            <p><a href="/success-stories/" >View Success Story</a></p>
                                      </div>
                                
                                    <div class="brightness">
                                            <?php the_post_thumbnail(); ?>
                                    </div>
                            </div>
                             <?php $c++; endwhile; ?>     
                            
                  	</div> <!--  carousel-inner   -->
                  
                  <!-- Controls -->
                  <a class="left carousel-control" href="#carousel-success-stories" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                  </a>
                  <a class="right carousel-control" href="#carousel-success-stories" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                  </a>
                  
                   	<?php endif; ?>     
                       
                 <?php wp_reset_query(); */ ?>

		<div style="bottom:15px;	margin:0 auto;	z-index:100;	position:absolute;	width:100%;	text-align:center;">
                    <span style="color:#fff;text-shadow:0 1px 2px rgba(0,0,0,0.6);"><a class="front-sub-text" href="/success-stories" style="font-size:17px;color:#fff">View Success Stories</a>
                </div>

                  
                </div>    
                
        	</div> <!-- news_background  -->                  
        </div>
        <!-- end Success Stories SLIDER --> 
         
         
         <div class="clearfix"></div>
        
       <!-- BEGIN JOIN COMMUNITIES -->  
       <?php include __DIR__ . "/include_pages/join_communities_resources.php";  ?>
       <!-- END JOIN COMMUNITIES --> 
       
         <div class="clearfix"></div>
         
         
       <?php include __DIR__ . "/include_pages/myanmar_business.php";  ?>
       
        
        
    </div>
    <!-- END PAGE CONTAINER -->

   
    
    
<?php get_footer(); ?>

 <!-- Modal (Advertise With Us) -->
    <div class="modal fade" id="advertise_window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" id="logoimg" alt="" class="img-responsive"></h4>
          </div>
          
          <div class="modal-body">
            	<div class="row">
                <div class="col-md-4" style="border-right:#aaa 1px solid;">
                	<p style="text-align:justify" >
                        Etiam in hendrerit enim, lacinia sagittis tellus. In eu sem cursus, consequat mauris quis, imperdiet eros. 
                        </p>
                        <p style="text-align:justify" >
                        Etiam in hendrerit enim, lacinia sagittis tellus. In eu sem cursus, consequat mauris quis, imperdiet eros. 
                        </p>
                </div>
                
                <div class="col-md-8">
                	
                    <h4 class="text-center" id="dialog_header"></h4>
                    <div id="dialog_form"></div>
                    
                </div>
                </div>
          </div>
         
      </div>
    </div>
    
    <!-- Modal (Advertise With Us) -->




<?php
/*
  Template Name: Advertisement Page
 */
get_header();
?>


    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body">
        <!-- BEGIN REVOLUTION SLIDER -->  <?php
					$banner_name = "";
					$image = "";
					
					$image_res= biz_portal_get_advertisement('ADS_TYPE_ABOUT');
					
					if (!empty($image_res->image_id)):
						$img_id=$image_res->image_id;
                        $image=biz_portal_get_file_url($img_id);
					else: 
						$image =  get_template_directory_uri() . "/images/about_img.jpg";
					endif;
				?>    
        <div class="top_banner_header img-responsive" alt="About MyanmarSMELink" style="background-image:  url('<?php echo $image; ?>')">
	</div>
        <!-- END REVOLUTION SLIDER -->
        
        <?php /** === COMENTED OUT THE SCROLL DOWN LINK ==============?>
        <div class="row">
            <div class="col-md-12">
                <div class="btn_banner_middle" href="" style="">
                    <a href="" class="button_scroll_top"
                        style=""></a>
                </div>
            </div>
        </div>
        <?php */ ?>
    	
        <!-- BEGIN CONTAINER -->   
        <div class="container">
            <!-- BEGIN SERVICE BOX --> 
           
            
                <div >
                	<?php $content = getPageContent(get_option( 'ads_page_row_one' ));  ?>
                   
                    <div class="about_parag_left">
                    	<?php echo $content['content'];	   ?>
                    </div>
                 
                </div>
                              
            </div>
            <!-- END SERVICE BOX -->  
        </div>
        <!-- END CONTAINER -->
        <div class="clearfix"></div>
        
       
        
       <!-- BEGIN Every Company -->    
         <div class="row   " style="background-color:#f8f9fe">
        
                
                    <div class="col-md-10 col-sm-10 col-md-offset-1">
                        
                             <?php $content = getPageContent(get_option( 'ads_page_row_two' ));  ?>
                          
                            <div class=" about_parag_left">
                               <?php echo $content['content'];	   ?>
                            </div>    
                    </div> <!-- col-md-7 col-sm-7  -->  
                 
                             
        </div>
        <!-- end Every Company --> 
        
         <div class="clearfix"></div>
         
          <div class="row  ">
        	<!-- BEGIN CONTAINER -->   
        	<div class="container">
            <!-- BEGIN SERVICE BOX --> 
                <div class="col-md-12 col-sm-12">
                	<?php $content = getPageContent(get_option( 'ads_page_row_three' ));  ?>
                      
                         <div class=" about_parag_left">
                            <?php echo $content['content'];	   ?>
                                                      
                        </div>
                </div>

              
                
            <!-- END SERVICE BOX -->  
          </div>
          <!-- END CONTAINER -->
        </div>
        
        <div class="clearfix"></div>
        
         <!-- BEGIN Success Stories SLIDER --> 
        <div class="row " >
        
        	<div>
        
				<div id="carousel-success-stories" class="carousel slide" data-ride="carousel">
                        
                         <div class="header_title" style="position:absolute"><h3 style="color:#fff;text-shadow:0 1px 2px rgba(0,0,0,0.6);"><strong>SUCCESS STORIES</strong></h3></div> 
                         
                         
                      <a href="/success-stories">
					  	<img src="<?php echo get_template_directory_uri(); ?>/images/home_success.jpg" class="max_width" />
                      </a>
					  
					  <?php /*
					  $c = 1;
                       $args = array(
                              'post_status' => 'publish',
                              'post_type' => 'success_story',
							  'posts_per_page'  => 5,
							  'orderby' => 'rand',
						);
                       
					   $the_query = new WP_Query( $args);
					   
					   if( $the_query->have_posts()):
					  ?>
                      
                      <!-- Wrapper for slides -->
                      <div class="carousel-inner">
                      
                      		<?php
								while( $the_query->have_posts() ):
									$the_query->the_post();
							?>
                  	
                            <div class="item <?php echo ($c == 1) ? "active":""; ?>">
                                     <div class="carousel-caption">
                                            <h3 class="bold"><?php the_title(); ?></h3>
                                            <p><a href="/success-stories/" >View Success Story</a></p>
                                      </div>
                                
                                    <div class="brightness">
                                            <?php the_post_thumbnail(); ?>
                                    </div>
                            </div>
                             <?php $c++; endwhile; ?>     
                            
                  	</div> <!--  carousel-inner   -->
                  
                  <!-- Controls -->
                  <a class="left carousel-control" href="#carousel-success-stories" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                  </a>
                  <a class="right carousel-control" href="#carousel-success-stories" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                  </a>
                  
                   	<?php endif; ?>     
                       
                 <?php wp_reset_query(); */ ?>

		<div style="bottom:15px;	margin:0 auto;	z-index:100;	position:absolute;	width:100%;	text-align:center;">
                    <span style="color:#fff;text-shadow:0 1px 2px rgba(0,0,0,0.6);"><a class="front-sub-text" href="/success-stories" style="font-size:17px;color:#fff">View Success Stories</a>
                </div>

                  
                </div>    
                
        	</div> <!-- news_background  -->                  
        </div>
        <!-- end Success Stories SLIDER --> 
         
         
         <div class="clearfix"></div>
        
       <!-- BEGIN JOIN COMMUNITIES -->  
       <?php include __DIR__ . "/include_pages/join_communities_resources.php";  ?>
       <!-- END JOIN COMMUNITIES --> 
       
         <div class="clearfix"></div>
         
         
       <?php include __DIR__ . "/include_pages/myanmar_business.php";  ?>
       
        
        
    </div>
    <!-- END PAGE CONTAINER -->

   
    
    
<?php get_footer(); ?>

 <!-- Modal (Advertise With Us) -->
    <div class="modal fade" id="advertise_window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" id="logoimg" alt="" class="img-responsive"></h4>
          </div>
          
          <div class="modal-body">
            	<div class="row">
                <div class="col-md-4" style="border-right:#aaa 1px solid;">
                	<p style="text-align:justify" >
                        Etiam in hendrerit enim, lacinia sagittis tellus. In eu sem cursus, consequat mauris quis, imperdiet eros. 
                        </p>
                        <p style="text-align:justify" >
                        Etiam in hendrerit enim, lacinia sagittis tellus. In eu sem cursus, consequat mauris quis, imperdiet eros. 
                        </p>
                </div>
                
                <div class="col-md-8">
                	
                    <h4 class="text-center" id="dialog_header"></h4>
                    <div id="dialog_form"></div>
                    
                </div>
                </div>
          </div>
         
      </div>
    </div>
    
    <!-- Modal (Advertise With Us) -->