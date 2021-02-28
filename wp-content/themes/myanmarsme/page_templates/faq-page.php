<?php
/**
 * Template Name:   FAQ page.
 *
 * @package adamos
 * @since adamos 1.0
 */

$awu_post_id = 676;
$awu_queried_post = get_post($awu_post_id);

$joinc_post_id = 452;
$joinc_queried_post = get_post($joinc_post_id);

define('SUBMENU_ITEM','');
get_header();
$result = get_option('dashboard_directory_slider_faq')
?>

<style>
	.top_banner_header{
		background-image:  url('<?php echo $result['img_big']; ?>');
	}
	
	@media (min-width: 992px) {
		.top_banner_header{
			background-image:  url('<?php echo $result['img_big']; ?>');
		}
	}
	
	
	@media (max-width: 992px) {
		.top_banner_header{
			background-image:  url('<?php echo $result['img_medium']; ?>');
		}
	}
	
	@media(max-width:767px){
		.top_banner_header{
			background-image:  url('<?php echo $result['img_small']; ?>');
		}
	}
</style>

    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body">
         <!--  FAQ   -->
         <div class="top_banner_header img-responsive" >
				
<!--		<img src="" class="img-responsive max_width">-->
				
         </div>
        <!--  FAQ   --> 
         
         <div class="clearfix"></div>
         
         <!-- BEGIN CONTAINER -->
         <div style="background-color:#f8f9f3;"> 
            
		<div class="container" >
			<div class="row margin-bottom-40">
				
				
				<div class="col-md-7" >
               		<div class="about_parag_left">
                    	<h3 class="header_title_2">Frequently Asked Questions</h3>
                    </div>                
                	<!--
                    <div style="border-right:#ccc 1px solid;">
                    -->
                    <div style="">
                    <!-- BEGIN TAB CONTENT -->
                    <div class="tab-content about_parag_left">
                    
                      
                      <!-- START TAB 3 -->
                      <div id="tab_3" class="tab-pane active">
                         <div id="accordion3" class="panel-group">
                         	 <?php
									$c = 1;
									$the_query = new WP_Query( 'category_name=faq&posts_per_page=-1&order=asc' );
									
									$total = $the_query->found_posts;
									
									if( $the_query->have_posts() ){
										
										while( $the_query->have_posts() ):
											$the_query->the_post();
								?>
                                            <div class="panel">
                                               <div class="panel-heading">
                                                  <h4 class="panel-title">
                                                     <a  class="accordion-toggle" data-toggle="collapse" id="acc_<?php the_ID(); ?>" data-parent="#accordion3" href="#accordion3_<?php the_ID(); ?>">
                                                     <span class="faq_title"><?php the_title();  ?></span> 
                                                     </a>
                                                  </h4>
                                               </div>
                                               <div id="accordion3_<?php the_ID(); ?>" class="panel-collapse collapse  <?php echo ($c == 1) ? "in":"";  ?>">
                                                  <div class="panel-body content-small">
                                                     
                                                        <?php the_content();  ?>
                                                     
                                                    
                                                  </div>
                                               </div>
                                            </div>
                            
                            <?php
											$c++;
										endwhile;
										
									} else {
										echo "No Post";	
									}
									
							?>
                            <?php wp_reset_postdata();  ?>
                         </div>
                      </div>
                      <!-- END TAB 3 -->
                    </div>
                    <!-- END TAB CONTENT -->
                    </div>
				</div>   
                
                <div class="col-md-5 col-sm-5" style="" >
                
                	
										
                        <div class="" style="padding-left:40px;">
                            <h3 class="header_title_2"><?php echo $joinc_queried_post->post_title;   ?></h3>
                        </div>
                    
                  		<div class="faq_sidebar">
                    
                        <div  >
                            <?php
                            $content = apply_filters('the_content', $joinc_queried_post->post_excerpt);
                            echo $content; ?>
                        </div>
                   
                    	<div class="box_join margin-top-50 margin-bottom-30">
                    	
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
                                        <p class="box_title">Apply as NonProfit Organization</p>
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
                   
                    

					<div class="clearfix devider_style_i"><div>&nbsp;</div></div>

					<div class="">
                    	<h3 class="header_title_2"><?php echo $awu_queried_post->post_title;  ?></h3>
                    </div>
                    
					<div class="margin-bottom-40">                    
                        <?php
                        $content = apply_filters('the_content', $awu_queried_post->post_excerpt);
                        echo $content; ?>
                        <div class="sidebar_bottom_link">
                            <a  href="/advertise">Advertising Information</a>
                            
                        </div>
                    
                    </div>                                
                    
                    
                    <div class="clearfix devider_style_i"><div>&nbsp;</div></div>

		
                        <!-- BEGIN Success Stories SLIDER --> 
                    <?php include __DIR__ . '/include_pages/sidebar_success_stories.php'; ?>
                    <!-- End Success Stories SLIDER -->
                        
                    
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
    
    <script>
function __init_faq_accordian()
{
	//alert('ok');
	/*$('.accordion-toggle').click(function() {
    	var id = $(this).attr('data-id');
    	if (typeof id != 'undefined' && id > 0) {
    		alert(id);
    	}
	});*/

	if ((window.location.hash))
	{
		var url_hash = window.location.hash;
		var id = url_hash.substr(1);
		
		if (!isNaN(id)) {
			if ($("#acc_" + id).length > 0)
			{
				$("#acc_" + id).trigger('click');
				if ($("#acc_" + id).offset().top > 220)
				    $(window).scrollTop($("#acc_" + id).offset().top-220);
				else
					$(window).scrollTop($("#acc_" + id).offset().top);
			}
		}
	}
}
    </script>
    
    <?php Theme_Vars::add_script_ready('__init_faq_accordian()'); ?>
    
   <?php get_footer(); ?>
   
  