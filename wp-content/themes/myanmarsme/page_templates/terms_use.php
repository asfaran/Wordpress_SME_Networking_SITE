<?php
/*
  Template Name: Terms of Use Page
 */

define('SUBMENU_ITEM','');
get_header();

$tou_post_id = get_option('terms_page_main');
$tou_queried_post = get_post($tou_post_id);

$first_side = get_option('terms_page_side_one');
    if($first_side['post']){
        $first_side_post = get_post($first_side['post']);           
    }

$second_side = get_option('terms_page_side_two');
    if($second_side['post']){
    $second_side_post = get_post($second_side['post']);
    }

$third_side = get_option('terms_page_side_three');
    if($third_side['post']){
    $third_side_post = get_post($third_side['post']);
    }

$joinc_post_id = 452;
$joinc_queried_post = get_post($joinc_post_id);

?>

    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body devider_style_i">
        
         
         <!-- BEGIN CONTAINER -->
         <div style="width:100%; position:relative;background-color:#fefefe;"> 
            
		<div class="container min-hight margin-bottom-40" >
			<div class="row">
                            <div class="col-md-8" style="border-right:#dedede 1px solid; text-align:left">
                                <!-- BEGIN TAB CONTENT -->
                                <h3 class="header_title_2"><?php echo  $tou_queried_post->post_title; ?></h3>
                                <div class="about_parag_left margin-bottom-20">
                                <?php
                                $content = apply_filters('the_content', $tou_queried_post->post_content);
                                echo $content; ?>
                                </div>
                                <!-- END TAB CONTENT -->
                            </div>
                        <div class="col-md-4 col-sm-3" style="padding-left:20px; ">
                    
                    <?php 
                    
                     if($first_side['post']){  ?>
                    
                    <div>
                        <h3 class="header_title_2"><?php echo nl2br($first_side['title']); ?></h3>
                    </div>
                    <div>
                        <?php
                        $content = apply_filters('the_content', $first_side_post->post_excerpt);
                        echo $content; ?>
                       
                        <div class="sidebar_bottom_link">
                        	<a href="<?php echo $first_side['url']; ?>" ><?php echo $first_side['footer'] ; ?></a>
                        </div>
                    
                    </div> 
                    <div class="clearfix devider_style_i"><div>&nbsp;</div></div>
                    <?php } ?>
                    
                    <?php if($second_side['post']){  ?>
                    
                    <div>
                        <h3 class="header_title_2"><?php echo nl2br($second_side['title']); ?></h3>
                    </div>
                    <div>
                        <?php
                        $content = apply_filters('the_content', $second_side_post->post_excerpt);
                        echo $content; ?>
                       
                        <div class="sidebar_bottom_link">
                        	<a href="<?php echo $second_side['url']; ?>" ><?php echo $second_side['footer'] ; ?></a>
                        </div>
                    
                    </div> 
                    <div class="clearfix devider_style_i"><div>&nbsp;</div></div>
                    <?php } ?>
                    
                    <?php if($third_side['post']){  ?>
                    
                    <div>
                        <h3 class="header_title_2"><?php echo $third_side['title']; ?></h3>
                    </div>
                    <div>
                        <?php
                        $content = apply_filters('the_content', $third_side_post->post_excerpt);
                        echo $content; ?>
                       
                        <div class="sidebar_bottom_link">
                        	<a href="<?php echo $third_side['url']; ?>" ><?php echo $third_side['footer'] ; ?></a>
                        </div>
                    
                    </div> 
                    <div class="clearfix devider_style_i">&nbsp;</div>
                    <?php } ?>
                    
                    <h3 class="header_title_2">Join<br>This Community</h3>
<!--                    <h3 class="header_title_2"><?php //echo $joinc_queried_post->post_title; ?></h3>        -->
                           
                    
                    <div >
                    	<?php
                        $content = apply_filters('the_content', $joinc_queried_post->post_excerpt);
                        echo $content; ?>
                    </div>
                    
                    <div style="" class="margin-bottom-20" >
                    	<div style="float:left">
                                
                                <?php if ( !is_user_logged_in() ) { ?> 
                                    <a href="/form-signup/?mt=<?php echo urlencode(base64_encode("TYPE_SME")); ?>">
                                <?php  } ?>
                                    <div class="box_orange">
                                        <p class="box_title">Apply as Myanmar SME/Company</p>
                                        <p class="arrow_down">
                                            <i class="fa fa-chevron-down"></i>
                                        </p>
                                    </div>
                                <?php if ( !is_user_logged_in() ) { ?>
                                    </a>
                                 <?php  } ?>
                            </div>
                        
                            <div style="float:left">
                                <?php if ( !is_user_logged_in() ) { ?> 
                                <a href="/form-signup/?mt=<?php echo urlencode(base64_encode("TYPE_INTL")); ?>">
                                 <?php  } ?>
                                    <div class="box_orange">
                                        <p class="box_title">Apply as International Company</p>
                                        <p class="arrow_down">
                                            <i class="fa fa-chevron-down"></i>
                                        </p>
                                    </div>
                                <?php if ( !is_user_logged_in() ) { ?> 
                                </a>
                                 <?php  } ?>
                            </div>
                        
                            
				<div style="float:left; margin-top:5px;">
                                <?php if ( !is_user_logged_in() ) { ?> 
                                <a href="/form-signup/?mt=<?php echo urlencode(base64_encode("TYPE_NGO")); ?>">
                                 <?php  } ?>
                                    <div class="box_orange">
                                        <p class="box_title">Apply as Non-Profit Organization</p>
                                        <p class="arrow_down">
                                            <i class="fa fa-chevron-down"></i>
                                        </p>
                                    </div>
                                <?php if ( !is_user_logged_in() ) { ?> 
                                </a>
                                 <?php  } ?>
                            </div>
                            <div style="float:left; margin-top:5px;">
                                
                                <a href="/contact/">
                                 
                                    <div class="box_orange" style="background-color:#dedede">
                                        <p class="box_title" style="color:#1b1b1b">Contact Us</p>
                                        <p class="arrow_down" style="color:#1b1b1b">
                                            <i class="fa fa-chevron-down"></i>
                                        </p>
                                    </div>
                                
                                </a>
                                 
                            </div>
                        <div class="clearfix"></div>
                    </div> 
                    
                        
                    
                    </div>  
                    
				</div>
                         
			</div>
		</div>
        </div>
        
		<!-- END CONTAINER -->
        
         <!-- BEGIN CONTAINER --> 
        <?php include __DIR__ . "/include_pages/about_the_platform.php";  ?>
        <!-- END CONTAINER -->
       
        
        
    </div>
    <!-- END PAGE CONTAINER -->

   <?php get_footer(); ?>