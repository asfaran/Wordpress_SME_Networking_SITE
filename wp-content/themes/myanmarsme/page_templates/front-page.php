<?php
/*
  Template Name: MyanmarSME Home page
 */
biz_portal_add_visit(BP_VisitPageType::FRONT_PAGE);
define('SUBMENU_ITEM','');
get_header();

$img_arr = get_option('dashboard_directory_slider_front');

$img_keys = array_keys($img_arr);
$rand_keys = array_rand($img_keys);

$is_user_logged_in = is_user_logged_in();


?>
    <script type="text/javascript">
     
       var tpj=jQuery;
       tpj.noConflict();
       

//       tpj(document).ready(function() {
//          if (tpj.fn.cssOriginal!=undefined)
//          tpj.fn.css = tpj.fn.cssOriginal;
//          tpj('.fullwidthbanner-container').revolution({
//             
//     
//             fullScreen:"on",
//             fullScreenOffsetContainer:"#fullwidthbanner-container",
//     
//             shadow:0
//     
//          });
//     
//       });
       
tpj(document).ready(function(){
    var divhieght =tpj('.header').height();
    tpj('#fullwidthbanner-container').click(function () {
//        tpj('html,body').animate({scrollTop: tpj('.container').offset().top }, 'slow');
tpj('html,body').animate({scrollTop: tpj('#container-row').offset().top - divhieght}, 'slow');
//alert("sdasdsadaddsds");
    });
        
resizeDiv();
      
});


window.onresize = function(event) {
resizeDiv();
};


        
function resizeDiv() {
vpw = tpj(window).width();
vph = tpj(window).height();
var divhieght =tpj('.header').height();
var lastvph= vph- divhieght;
tpj('#fullwidthbanner-container').css({'height': lastvph + 'px'});
}
 

    </script>
    <style>
        .fullwidthbanner-container{
             background-image:  url('<?php echo $img_arr[$img_keys[$rand_keys]]; ?>') ;
             background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    padding:0;
    top-margin:0;
    margin-top:0;
    margin-bottom:1px;
    
        }
		
		
    </style>
    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container  page-body" style="height: 100%;">
        <!-- BEGIN REVOLUTION SLIDER -->    
        <div class="fullwidthbanner-container" id="fullwidthbanner-container" style="height: 100%;">
        </div>
        <!-- END REVOLUTION SLIDER -->
        
<!--        <div class="row">
            <div class="col-md-12">
                <div class="btn_banner_middle" href="" style="">
                    <a href="" class="button_scroll_top"
                        style=""></a>
                </div>
            </div>
        </div>-->
    	
         <!-- BEGIN About CONTAINER -->   
        <?php include __DIR__ . "/include_pages/about_the_platform.php";  ?>
        <!-- END About CONTAINER -->        
        
       <!-- BEGIN SCOOP SLIDER -->    
        <div class="row fixed-height" style="overflow:hidden">
        <div>
        
        	<div>
			<div class="header_title" style="position:absolute"><h3 style="color:#fff;text-shadow:0 1px 2px rgba(0,0,0,0.6);"><strong>NEWS ROOM</strong></h3></div> 	
        
				<div id="carousel-scoop-it" class="carousel slide" data-ride="carousel">
                         
                         
                      <?php
					  	$scoop_news = scoop_it_get_nodes(0,4);
					  
					  ?>  
                      <!-- Wrapper for slides -->
                      <div class="carousel-inner" style="overflow:hidden">
                  			<?php  
							$c = 0;
							
							foreach($scoop_news as $news):  ?>                            
                            <?php $image = ''; 
							if (!empty($news->node_largeImageUrl)) $image = $news->node_largeImageUrl;
							else if (!empty($news->node_imageUrl)) $image = $news->node_imageUrl;
							else if (!empty($news->node_mediumImageUrl)) $image = $news->node_mediumImageUrl;
							else $image = get_template_directory_uri() . "/images/sky.jpg";
							 ?>
                             
                            <div class="item <?php echo ($c == 0) ? "active":""; ?>">
                                     <div class="carousel-caption" style="left:25%;right:25%;">
                                            <h3>

						<a href="<?php echo $news->node_scoopUrl;  ?>" target="_blank" style="text-decoration:none; color:#fff">
							<?php echo $news->node_title;  ?>
						</a>

					    </h3>
                                            <p class="front-sub-text text-center" id="scoop_home_content"><?php echo scoop_it_get_summary($news->node_content);  ?></p>
                                      </div>
                                
                                    <div class="brightness"  >
                                            <div class="overlay"></div>	
                                            <img src="<?php echo $image; ?>" alt="<?php echo $news->node_title;  ?>" style="bottom:0;	left:0;" >
                                    </div>
                            </div>
                            <?php 
								$c++;
							endforeach;  ?>
                              
                  </div>
                  
                  <div style="bottom:15px;	margin:0 auto;	z-index:100;	position:absolute;	width:100%;	text-align:center;">
			<span style="color:#fff;text-shadow:0 1px 2px rgba(0,0,0,0.6);"><a class="front-sub-text" href="/newsroom" style="font-size:19px;color:#fff">News Room </a><br> </span>
                  <p style="color:#fff; text-align:center" class="news_caption_footer front-sub-text">News presented are hosted on third party website. Please see Terms of Use for third party disclaimer.</p>
                  </div>
                                  
                  <!-- Controls -->
		    
                  <a class="left carousel-control" href="#carousel-scoop-it" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                  </a>
                  <a class="right carousel-control" href="#carousel-scoop-it" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                  </a>
                 
                   
                  
                </div>    
                
        	</div> <!-- news_background  -->                  
        </div>
        </div>
        <!-- BEGIN SCOOP SLIDER --> 
        
         <div class="clearfix"></div>
        
       <!-- BEGIN JOIN COMMUNITIES -->  
       
       <?php include __DIR__ . "/include_pages/join_communities_resources.php";  ?>

       <!-- END JOIN COMMUNITIES -->         
         <div class="clearfix"></div>
         
          <!-- BEGIN Success Stories SLIDER --> 
        <?php include __DIR__ . "/include_pages/success_story_module.php";  ?>
        <!-- end Success Stories SLIDER -->
         
         
         <div class="clearfix"></div>
         
         <!--  FAQ   -->
         <?php include __DIR__ . "/include_pages/faq_section.php";  ?>
        <!--  FAQ   --> 
         
         <div class="clearfix"></div>
         
         
        <?php include __DIR__ . "/myanmar_business.php";  ?>
        
       

    </div>
    <!-- END PAGE CONTAINER -->    
<?php get_footer(); ?>
    