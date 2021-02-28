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
        
        
        <!-- BEGIN CONTAINER -->   
<!--        <div class="container">-->
           
            <div class="row ">
                <div class="container" style="padding:0 20px;">
                	<?php $content = getPageContent(get_option( 'ads_page_row_one' ));  ?>
                   
                    <div >
                    	<?php echo $content['content'];	   ?>
                    </div>
                 
                </div>
            </div>  
<!--        </div>-->
        <div class="clearfix"></div>
        
        <div class="row " style="background-color:#f8f9fe">
                <div class="container" style="height:100%" style="padding:0 20px;">
                        
                             <?php $content = getPageContent(get_option( 'ads_page_row_two' ));  ?>
                          
                            <div >
                               <?php echo $content['content'];	   ?>
                            </div>    
                </div>
        </div>
        <div class="clearfix"></div>
        
<!--        <div class="container">-->
            <div class="row ">
                <div class="container"  style="padding:0 20px;">
                	<?php $content = getPageContent(get_option( 'ads_page_row_three' ));  ?>
                      
                         <div>
                            <?php echo $content['content'];	   ?>
                                                      
                        </div>
                </div>
            </div>
<!--            </div> -->
        <!-- END CONTAINER -->

        <div class="clearfix"></div>
        
         <!-- BEGIN Success Stories SLIDER --> 
        <?php include __DIR__ . "/include_pages/success_story_module.php";  ?>
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