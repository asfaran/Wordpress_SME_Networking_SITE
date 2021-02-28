<?php
/*
  Template Name: News Room Page
 */

define('SHOW_NEWS_TOPICS', true, true);
define('SUBMENU_ITEM','newsroom');
define('PRIVATE_SUBMENU', true, true);

$category = filter_input(INPUT_GET,'c',FILTER_VALIDATE_INT);


$node_categories = scoop_it_get_topics();
$categories =array();
foreach ($node_categories as $cat) :
    $categories[$cat->id]=$cat->cat_name;
endforeach;

if((!($category)) || $category ===null){ $category=$categories[0]->id ; }
get_header();


?>
		
<style>
/*.page-body {
    margin-top: 100px;
}*/
.brightness{
    height:418px;
}

@media(max-width:767px){
    .header ul.nav {
        float: none;
    }
}
    
 </style>

    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body" style="">
        <!-- BEGIN SCOOP SLIDER -->    
        <div class="banner_header" >
        <div>
            <div>
                <div id="carousel-directory" class="carousel slide" data-ride="carousel">
                    <?php $slider_news = scoop_it_get_nodes(0,4); ?>  
                      <!-- Wrapper for slides -->
                      <div class="carousel-inner">
                    <?php  
                    $k = 0;

                    foreach($slider_news as $news):
                        $image = ''; 
                        if (!empty($news->node_largeImageUrl)) $image = $news->node_largeImageUrl;
                        else if (!empty($news->node_imageUrl)) $image = $news->node_imageUrl;
                        else if (!empty($news->node_mediumImageUrl)) $image = $news->node_mediumImageUrl;
                        else $image = get_template_directory_uri() . "/images/sky.jpg";
                     ?>
                             
                            <div class="item <?php echo ($k == 0) ? "active":""; ?>">
                                <div class="directory-carousel-caption">
                                            <h3>
						<a href="<?php echo $news->node_scoopUrl;  ?>" target="_blank" style="text-decoration:none; color:#fff">
							<?php echo $news->node_title;  ?>						</a>
					    </h3>
                                            <p class="front-sub-text text-center" id="scoop_home_content"><?php echo scoop_it_get_summary($news->node_content);  ?></p>
                                 </div>
                                
                                <div class="brightness" style="background-image:  url('<?php echo $image; ?>');" ><div class="overlay"></div></div>
                            </div>
                            <?php $k++;
                            endforeach;  ?>
                              
                  </div>
                  
                  <!-- Controls -->
		    
                  <a class="left carousel-control banner-fixed-height" href="#carousel-directory" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                  </a>
                  <a class="right carousel-control banner-fixed-height" href="#carousel-directory" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                  </a>
               </div>    
               </div>                 
        </div>
        </div>
        <!-- END SCOOP SLIDER -->
        
        <!-- BEGIN BREADCRUMBS -->
        <div class="row  " >
                    	<div class="breadcrumbs breadcrumbs_dark">
                            <div class="col-md-12 col-sm-12 ">
                           
                                <div class="submenu ">
                                   <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                                   <!-- 
					<button class="navbar-toggle btn navbar-btn" data-toggle="collapse" data-target="#submenu" onClick="$('#submenu').toggle();">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                   -->
                                       <?php 
                                        $category = filter_input(INPUT_GET,'c',FILTER_VALIDATE_INT);
                             
                                        ?>
					 <ul class="submenu_list" id="submenu" >
                                             <li><a class="submenu_title_i">Newsroom</a></li>                                   
                                    	
                                    	<?php 
                                        $x = 1;
                                                        foreach ($node_categories as $cat) :
                                                            if((isset($category)) && ($category == $cat->id)):
                                                                $active =  "class='active'";
                                                            elseif((!isset($category)) && $x == 1):
                                                                $active =  "class='active'";
                                                            else:
                                                               $active = "";
                                                            endif;
                                                            
                                                        if(strlen($cat->cat_name)>10){
                                                        $truncated = substr($cat->cat_name, 0, 10);
                                                        $last_space = strrpos($truncated, ' ');
                                                        $truncated = substr($truncated, 0, $last_space);
                                                        }else{
                                                            $truncated=$cat->cat_name;
                                                        }
                                            ?>
                                        	<li <?php echo $active; ?>>
                                                    <a href="/<?php echo SUBMENU_ITEM; ?>/?c=<?php echo $cat->id; ?>">
                                                    <?php echo $truncated ;?>
                                                    </a>
                                                </li>
                                        <?php $x++; endforeach; ?>
                                    </ul>
                                </div>  
                            </div>
                        </div>
                    </div>
        <!-- END BREADCRUMBS -->

        <div class="row">
          <div class="col-md-12">
            <!-- BEGIN CONTAINER -->
    		    <div class="container min-hight portfolio-page ">
    			  <!-- BEGIN ABOUT INFO -->   
				<?php
					  	$scoop_news = scoop_it_get_nodes((int)$category,50);
						//print_r($scoop_news);
				?>  
				 <ul style="position: relative; height: auto;" class="grid effect-2" id="grid">
                                     <?php  
                                     $c = 1;
                                     $img_arr=array();
                                     
							
						foreach($scoop_news as $news):
                                                    $image = ''; 
                                                    $img_author = '';
                                                    
                                                    if(($c%10)===0){
                                                        if(count($img_arr)>0 && $img_arr !=null){
                                                            if(is_array(implode(",", $img_arr))){
                                                            $result_array = array_map('trim',implode(",", $img_arr));
                                                            $image_res=biz_portal_get_advertisement('ADS_TYPE_NEWSROOM',$result_array);
                                                            $url_target="_self";
                                                        }else{
                                                            $image_res=biz_portal_get_advertisement('ADS_TYPE_NEWSROOM');
                                                            $url_target="_self";
                                                        }
                                                        }else{
                                                            $image_res=biz_portal_get_advertisement('ADS_TYPE_NEWSROOM');
                                                            $url_target="_self";
                                                        }
                                                        $img_id=$image_res->image_id;
                                                        $img_arr[$img_id]=$img_id;
                                                        $image=biz_portal_get_file_url($img_id);
                                                        $news_url=$image_res->link_url;
                                                        $news_title="";
                                                        $url_target="_self";
                                                    }else{
                                                        $news_url=$news->node_scoopUrl;
                                                        $news_title=$news->node_title;
                                                        $url_target="_blank";
                                                        
                                                        if (!empty($news->node_largeImageUrl)) $image = $news->node_largeImageUrl;
							else if (!empty($news->node_imageUrl)) $image = $news->node_imageUrl;
							else if (!empty($news->node_mediumImageUrl)) $image = $news->node_mediumImageUrl;
							else $image = get_template_directory_uri() . "/images/sky.jpg";
							
							if(!empty($news->author_avatarUrl)) $img_author = $news->author_avatarUrl;
							else if(!empty($news->author_smallAvatarUrl))  $img_author = $news->author_smallAvatarUrl;
							else if(!empty($news->author_mediumAvatarUrl))  $img_author = $news->author_mediumAvatarUrl;
							else if(!empty($news->author_largeAvatarUrl))  $img_author = $news->author_largeAvatarUrl;
							else $img_author = get_template_directory_uri() . "/images/author.gif";
                                                        
                                                     }
                                                    
							
							 ?>
                         
                            
                            <li class="" >
                                <a href="<?php echo $news_url;  ?>" target="<?php echo $url_target; ?>" style="text-decoration:none">
                                <div class="scoop_box">
                                    
                                    <div class="scoop_content">
                                        <div class="media_holder">
                                            <img src="<?php echo $image;  ?>"  alt="<?php echo $news_title;  ?>" class="scoop_img">
                                        </div>
                                        <p style="text-align:left; font-size:13px; line-height:130%;"><?php echo $news_title;  ?></p>
                                    </div>
                                    
                                    
                                </div> 
                                </a>   
                            </li>
                
						<?php 
                                                $c++;
                                                endforeach;  ?>
				
			</ul>
                   
		</div>
		<script src="<?php echo get_template_directory_uri(); ?>/includes/masonry.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/includes/imagesloaded.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/includes/classie.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/includes/AnimOnScroll.js"></script>
		<script>
			new AnimOnScroll( document.getElementById( 'grid' ), {
				minDuration : 0.4,
				maxDuration : 0.7,
				viewportFactor : 0.2
			} );
		</script>
                    					
				
			<!-- END ABOUT INFO -->       
        		</div>
        		<!-- END CONTAINER -->
          </div>
        </div>

	</div>
    <!-- END PAGE CONTAINER -->  
	
   

   <?php get_footer(); ?>