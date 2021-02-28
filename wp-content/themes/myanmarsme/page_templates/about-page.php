<?php
/*
  Template Name: About Page
 */

define('SUBMENU_ITEM','');
get_header();
?>

<style>
	.top_banner_header{
		background-image:  url('<?php echo get_template_directory_uri(); ?>/images/about.jpg');
	}
	
	@media (min-width: 1800px) {
		.top_banner_header{
			background-image:  url('<?php echo get_template_directory_uri(); ?>/images/about-hd.jpg');
		}
	}
	
	@media (min-width: 992px) and (max-width: 1800px) {
		.top_banner_header{
			background-image:  url('<?php echo get_template_directory_uri(); ?>/images/about.jpg');
		}
	}
	
	
	@media (max-width: 992px) {
		.top_banner_header{
			background-image:  url('<?php echo get_template_directory_uri(); ?>/images/about.jpg');
		}
	}
	
	@media(max-width:767px){
		.top_banner_header{
			background-image:  url('<?php echo get_template_directory_uri(); ?>/images/about.jpg');
		}
	}
</style>

    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body">
        <!-- BEGIN REVOLUTION SLIDER -->    
        <div class="top_banner_header img-responsive" >
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
           
            <div class="row ">
                <div >
                	<?php $content = getPageContent(get_option( 'about_page_row_one' ));  ?>
                   
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
        
                <div class="container margin-bottom-40">
                    <div >
                        
                             <?php $content = getPageContent(get_option( 'about_page_row_two' ));  ?>
                          
                            <div class=" about_parag_left">
                               <?php echo $content['content'];	   ?>
                            </div>    
                    </div> <!-- col-md-7 col-sm-7  -->  
		</div>
                 
                             
        </div>
        <!-- end Every Company --> 
        
         <div class="clearfix"></div>
         
          <div class="row  ">
        	<!-- BEGIN CONTAINER -->   
        	<div class="container">
            <!-- BEGIN SERVICE BOX --> 
                <div >
                	<?php $content = getPageContent(get_option( 'about_page_row_three' ));  ?>
                      
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
        <?php include __DIR__ . "/include_pages/success_story_module.php";  ?>
        <!-- end Success Stories SLIDER --> 
         
         
         <div class="clearfix"></div>

	<span style="display:block; margin-top:-115px; width:0; height:115px; position:relative; visibility:inherit " id="join_this_community"></span>
        
       <!-- BEGIN JOIN COMMUNITIES -->  
       <?php include __DIR__ . "/include_pages/join_communities_advertising.php";  ?>   
       <!-- END JOIN COMMUNITIES --> 
       
         <div class="clearfix"></div>
         
         
        <?php include __DIR__ . "/myanmar_business.php";  ?>      
        
        
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