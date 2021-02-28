<?php
/*
  Template Name: Thank You Page
 */
 
define('SUBMENU_ITEM','');
get_header();
?>

    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body">
      
    	
        <!-- BEGIN CONTAINER --> 
        <div class="row margin-bottom-40 ">  
        <div class="container" >
            <!-- BEGIN SERVICE BOX --> 
            <div class="header_title">
            	<h1 >Thank You!</h1>
            </div>  
            <div class="row service-box">
                <div class="col-md-8 col-md-offset-2 ">
                   <div class=" align-justify well well-sm">
                     <?php if ( is_user_logged_in() ) { ?> 
                                         
                    <p>Thank you for updating your profile. Your details have been changed. Please <a href="/dashboard/profile">click here</a> to see the changes. </p>
                   
                   	<?php } else {  ?>
                    
                    <p>Thank you for your interest in Myanmar SME Link. Your details have been submitted and you will be contacted by our staff for further details of your registration. Have a nice day. </p>
                    
                    <?php } ?>
                   
                    </div>
                </div>
                              
            </div>
            <!-- END SERVICE BOX -->  
        </div> 
        </div>
        <!-- END CONTAINER -->
        <div class="clearfix"></div>
        
    
        
    </div>
    <!-- END PAGE CONTAINER -->
	
    <?php get_footer(); ?>