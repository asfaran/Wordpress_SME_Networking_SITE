<?php
/*
  Template Name: Success Stories Page
 */
$success_id = filter_input(INPUT_GET,'id',FILTER_VALIDATE_INT); 
$get_header_id = 0;

define('SUBMENU_ITEM','');

get_header();


//echo 'ID: '.$id;

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
        
        <!-- BEGIN Success Stories SLIDER --> 
       <?php /* <div class="banner_header" >
            <div >
                <div id="carousel-directory" class="carousel slide" data-ride="carousel">
                
                	<img src="<?php echo get_template_directory_uri(); ?>/images/success_header.jpg" class="max_width" />
                    
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
                                <?php $img_url=wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' ); ?>
                                <div class="brightness" style="background-image:  url('<?php echo $img_url[0];?>');">
                                    
<!--                                    <img 
                                    src=""  style="top:50%;overflow:hidden" class="max_width">-->
                                </div>
                            </div>
                        <?php $c++; endwhile; ?>
                      </div> <!--  carousel-inner   -->
                  
                  <!-- Controls -->
                  <a class="left carousel-control banner-fixed-height " href="#carousel-directory" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                  </a>
                  <a class="right carousel-control banner-fixed-height" href="#carousel-directory" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                  </a>
              <?php endif; ?>     
                       
                 <?php wp_reset_postdata(); 
                  
                </div>
            </div>                   
        </div>*/ ?>
        <!-- end Success Stories SLIDER --> 
        
        
    	<div class="clearfix"></div>
        <!-- BEGIN CONTAINER -->   
        <div class="container padding-top-20 margin-bottom-40">
            <!-- BEGIN SERVICE BOX --> 
            <div style="text-align:center; width:100%;" class="text-center">
                <?php 
                $edit_class = ''; $edit_location='';
                if (current_user_can('manage_options')) {
                    $edit_class = 'admin_udpate_spot';
                    $edit_location = 'options';
                }
                ?>
            	<h3><span data-location="<?php echo $edit_location; ?>" data-id="content_page_success_stories_header_1" 
                        class="<?php echo $edit_class; ?>"><?php echo get_option('content_page_success_stories_header_1', 'content_page_success_stories_header_1')?></span></h3>
            </div>  
            <div class="row service-box">
                <div class="col-md-12 text-center col-sm-12">
                <?php 
                $edit_class = ''; $edit_location='';
                if (current_user_can('manage_options')) {
                    $edit_class = 'admin_udpate_spot';
                    $edit_location = 'options';
                }
                ?>
                    <p id="page_intro">
                        	<span data-location="<?php echo $edit_location; ?>" data-id="content_page_success_stories_row_1" class="<?php echo $edit_class; ?>">
								<?php echo stripslashes(get_option('content_page_success_stories_row_1', 'content_page_success_stories_row_1'))?>
                            </span>
                        </p>
                   
                                     
                </div>
              
               
            </div>
            <!-- END SERVICE BOX -->  
           
        </div>
        <!-- END CONTAINER -->
        
        
         <!-- BEGIN CONTAINER -->   
		<div class="container">
					
                    <span style="display:block; margin-top:-115px; width:0; height:115px; position:relative; visibility:inherit " id="success_stories_text"></span>
					
                    <!-- FONT AWESOME -->
					<div class="row margin-bottom-40">
                          
                          	
		                     <ul class="nav nav-tabs">
		                        <li class="active"><a href="/success-stories#success_stories_text" >TEXT</a></li>
		                        <li><a href="/success-stories-videos#success_stories_videos" id="success_stories_videos" >VIDEOS</a></li>		                     		</ul>
		                     
                                       <div class="container">
                                       		<div class="col-md-9">
                                            
                                            		<?php
                                                     	$args = array(
                                                        	'post_status' => 'publish',
                                                            'post_type' => 'success_story',
															'orderby' => 'date',
															'order' => 'ASC');
                                                                                                        
                                                     	$the_query = new WP_Query( $args);
														$total = $the_query->found_posts;
													
														if( $the_query->have_posts() ){
														
															while( $the_query->have_posts() ):
																$the_query->the_post();
													
													?>
                                                   
                                                    <div class="resources_item">
                                                        <h2>
                                                        <!--
                                                        <a href="#" data-toggle="modal" data-target="#advertise_window_<?php the_ID();  ?>"  class="success_title" data-id="<?php the_ID(); ?>" style="text-decoration:none">
														-->
														<?php the_title();  ?>
                                                        <!--
                                                        </a>
                                                        -->
                                                        </h2>
                                                        <div><em><?php the_time(get_option('date_format'));  ?></em></div>
                                                        <p>
                                                            <?php the_content();  ?></p>
                                                            
                                                           <!-- 
                                                            <a href="#" data-toggle="modal" data-target="#advertise_window_<?php the_ID();  ?>" data-id="<?php the_ID(); ?>" class='more'>read more</a>
                                                        
                                                        <!--
                                                        <ul class="blog-info">
                                                            <li>Provided by <a href="#">XYZ</a></li>
                                                            <li>| <a href="#" data-toggle="modal" data-target="#advertise_window_<?php the_ID();  ?>"  class="success_title" data-id="<?php the_ID(); ?>">Download / View</a></li>
                                                        </ul>
                                                        -->
                                                        
                                                    </div>
                                                    
                                                    
                                                    
                                                    
                                                    <!-- Modal (Advertise With Us) -->
                                                        <div class="modal fade" id="advertise_window_<?php the_ID();  ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                          <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                      
                                                              <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                        <img src="<?php echo get_template_directory_uri(); ?>/images/success_logo1.png"  alt="" class="img-responsive">
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <img src="<?php echo get_template_directory_uri(); ?>/images/success_logo2.png"  alt="" class="img-responsive">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
																		<?php
                                                                            $id = get_the_ID();   
                                                                            $youtube = get_post_meta(intval($id), 'sbpsmesme_field_url_youtube', true);
                                                                            $suffix = "?controls=0&showinfo=0";
                                                                            $url = str_replace("watch?v=", "embed/", $youtube);
                                                                        ?>	
                                                                     <?php  if( (has_post_thumbnail()) && (!empty($youtube)) ):  ?>
                                                                        <iframe src="<?php  echo $url.$suffix; ?>" style="width:100%; height:300px;" frameborder="0" ></iframe>
                                                                    <?php endif; ?>
                                                                    
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="container margin-top-20">
                                                                            <div><?php the_time(get_option('date_format'));  ?></div>
                                                                            <h4><?php the_title();  ?></h4>
                                                                            <?php the_content();  ?>
                                                                           
                                                                        </div>
                                                                    </div>
                                                              </div>
                                                             
                                                             <div class="modal-footer">
                                                                <div class="col-md-6">
                                                                    <img src="<?php echo get_template_directory_uri(); ?>/images/modal_logo.jpg" alt="" class="img-responsive">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    &copy; <?php echo date('Y'); ?> Globalink. All Rights Reserved
                                                                </div>
                                                             </div>
                                                             
                                                          </div>
                                                        </div>
                                                        </div>
                                                        <!-- Modal (Advertise With Us) -->
                                                                                                        
                                                    
                                                    <?php  
															endwhile;
										
														} else {
															echo "No Post";	
														}
													
													wp_reset_postdata();
													 ?>
                                                    
                                                   
                                                    
                                                    
                                            </div> <!-- col-md-9  -->
                                       </div> <!-- container  -->
		                      </div> 
		               
					</div>
					<!-- END FONT AWESOME -->
			
		</div>
		<!-- END CONTAINER -->  
       
        
         
    </div>
    <!-- END PAGE CONTAINER -->
    
		<script>
			function header_title(num){
				<?php $get_header_id = "<script>document.write(num);</script>"; 
					//echo "Header ID: " . $get_header_id;
				 ?>
				 //alert(num);
			}
			
			function initialize_success_stories(){
				$("#success_header").modal();	
			}
		</script> 
        
        			<!-- Modal (Advertise With Us) --> 
                            <div class="modal fade" id="success_header" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                   <div class="modal-dialog">
                                          <div class="modal-content">
                                                                      
                                          <div class="modal-body">
                                                <div class="row">
                                                     <div class="col-md-6">
                                                          <img src="<?php echo get_template_directory_uri(); ?>/images/success_logo1.png"  alt="" class="img-responsive">
                                                     </div>
                                                     <div class="col-md-6">
                                                           <img src="<?php echo get_template_directory_uri(); ?>/images/success_logo2.png"  alt="" class="img-responsive">
                                                     </div>
                                                </div>
                                                <div class="row">
														<?php
                                                            $id = (isset($success_id)) ? $success_id : $get_header_id;   
                                                            $youtube = get_post_meta(intval($id), 'sbpsmesme_field_url_youtube', true);
                                                            $suffix = "?controls=0&showinfo=0";
                                                            $url = str_replace("watch?v=", "embed/", $youtube);
															
															$post = get_post($id);
															//print_r($post);
                                                        ?>	
                                                        <?php  if((!empty($youtube)) ):  ?>
                                                             <iframe src="<?php  echo $url.$suffix; ?>" style="width:100%; height:300px;" frameborder="0" ></iframe>
                                                        <?php endif; ?>
                                                                    
                                                </div>
                                                <div class="row">
                                                        <div class="container margin-top-20">
                                                              <div><?php echo date('j F Y',strtotime($post->post_date));//(get_option('date_format'));  ?></div>
                                                              <h4><?php echo $post->post_title;  ?></h4>
                                                              <?php echo $post->post_content;  ?>
                                                                           
                                                         </div>
                                                  </div>
                                           </div>
                                                             
                                           <div class="modal-footer">
                                                   <div class="col-md-6">
                                                         <img src="<?php echo get_template_directory_uri(); ?>/images/modal_logo.jpg" alt="" class="img-responsive">
                                                    </div>
                                                    <div class="col-md-6">
                                                         &copy; <?php echo date('Y'); ?> Globalink. All Rights Reserved
                                                    </div>
                                           </div>
                                                             
                                      </div>
                                  </div>
                             </div>
                             <!-- Modal (Advertise With Us) -->
        
        
    <?php 
		
	//if ((!is_null($success_id)) && ($success_id > 0)) : ?>    
    <?php //Theme_Vars::add_script_ready('initialize_success_stories()');  ?>    
    <?php //endif; ?>  
      
   <?php get_footer(); ?>
   
   
 		