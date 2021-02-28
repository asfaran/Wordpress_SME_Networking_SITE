<!-- BEGIN FOOTER -->

<?php if(!defined('PRIVATE')) : ?>
<?php 
$footer_result = get_option('web_front_footer_image');

?>
    <div class="footer " >

        <div class="container" style="padding-bottom:40px">

            <div class="row margin-bottom-30 footer_container">

               <div class="col-md-12 com-sm-12">
               
                    <div class="header_title">

                        <h4 style="text-transform:uppercase">With special thanks to the following entities:</h4>

                    </div>

                    <div class="clearfix"></div>

                    <div class="clearfix"></div>

                     <!--  Primary Sponsor -->

                    <div class="margin-bottom-40 text-center margin-top-20" id="footer_desktop">

                    	<div class="row margin-bottom-40">
                        <?php 
                        $footer_result_tab = get_option('web_front_footer_image');
                        
                            echo '<div style="'.$footer_result_tab[1]['style'].'">
                                <a href="'.$footer_result_tab[1]['url'].'" target="_blank">
                                    <img src="'.$footer_result_tab[1]['img_logo'].'" alt="'.$footer_result_tab[1]['title'].'"  >
                                </a>
                            </div>';
                            
                            echo '<div style="'.$footer_result_tab[2]['style'].'">
                                <a href="'.$footer_result_tab[2]['url'].'" target="_blank">
                                    <img src="'.$footer_result_tab[2]['img_logo'].'" alt="'.$footer_result_tab[2]['title'].'"  >
                                </a>
                            </div>';
                            
                            echo '<div style="'.$footer_result_tab[3]['style'].'">
                                <a href="'.$footer_result_tab[3]['url'].'" target="_blank">
                                    <img src="'.$footer_result_tab[3]['img_logo'].'" alt="'.$footer_result_tab[3]['title'].'"  >
                                </a>
                            </div>';
                            
                            echo '<div style="'.$footer_result_tab[4]['style'].'">
                                <a href="'.$footer_result_tab[4]['url'].'" target="_blank">
                                    <img src="'.$footer_result_tab[4]['img_logo'].'" alt="'.$footer_result_tab[4]['title'].'"  >
                                </a>
                            </div>';
                            
                            echo '<div style="'.$footer_result_tab[5]['style'].'">
                                <a href="'.$footer_result_tab[5]['url'].'" target="_blank">
                                    <img src="'.$footer_result_tab[5]['img_logo'].'" alt="'.$footer_result_tab[5]['title'].'"  >
                                </a>
                            </div>';
                         ?>

                        </div> 
                        
                        <div class="row margin-bottom-40 text-center" style="margin-left:200px"> 
                            <?php 
                            
                            echo '<div style="'.$footer_result_tab[6]['style'].'">
                                <a href="'.$footer_result_tab[6]['url'].'" target="_blank">
                                    <img src="'.$footer_result_tab[6]['img_logo'].'" alt="'.$footer_result_tab[6]['title'].'"  >
                                </a>
                            </div>';
                             echo '<div style="'.$footer_result_tab[7]['style'].'">
                                <a href="'.$footer_result_tab[7]['url'].'" target="_blank">
                                    <img src="'.$footer_result_tab[7]['img_logo'].'" alt="'.$footer_result_tab[7]['title'].'"  >
                                </a>
                            </div>';
                         ?>

                            
                        </div>

                    </div>   
                    
                    <!-----------     Tablet version    ------------>
                    
                    <div class="" id="footer_tablet">

                    	<div class="row text-center">
                            <?php 
                            $footer_result = get_option('web_front_footer_image');
                            echo '<div class="footer_mobile_item">
                                <a href="'.$footer_result[1]['url'].'" target="_blank">
                                    <img src="'.$footer_result[1]['img_logo'].'" alt="'.$footer_result[1]['title'].'"  >
                                </a>
                            </div>';
                            
                            echo '<div class="footer_mobile_item">
                                <a href="'.$footer_result[2]['url'].'" target="_blank">
                                    <img src="'.$footer_result[2]['img_logo'].'" alt="'.$footer_result[2]['title'].'"  >
                                </a>
                            </div>';
                            
                            echo '<div class="footer_mobile_item">
                                <a href="'.$footer_result[3]['url'].'" target="_blank">
                                    <img src="'.$footer_result[3]['img_logo'].'" alt="'.$footer_result[3]['title'].'"  >
                                </a>
                            </div>';
                            ?>
                        </div>
                        
                            
			<div class="row text-center">
                            <?php 
                            echo '<div class="footer_mobile_item">
                                <a href="'.$footer_result[4]['url'].'" target="_blank">
                                    <img src="'.$footer_result[4]['img_logo'].'" alt="'.$footer_result[4]['title'].'"  >
                                </a>
                            </div>';
                            echo '<div class="footer_mobile_item">
                                <a href="'.$footer_result[5]['url'].'" target="_blank">
                                    <img src="'.$footer_result[5]['img_logo'].'" alt="'.$footer_result[5]['title'].'"  >
                                </a>
                            </div>';
                            
                            echo '<div class="footer_mobile_item">
                                <a href="'.$footer_result[6]['url'].'" target="_blank">
                                    <img src="'.$footer_result[6]['img_logo'].'" alt="'.$footer_result[6]['title'].'"  >
                                </a>
                            </div>';
                            
                             echo '<div class="footer_mobile_item">
                                <a href="'.$footer_result[7]['url'].'" target="_blank">
                                    <img src="'.$footer_result[7]['img_logo'].'" alt="'.$footer_result[7]['title'].'"  >
                                </a>
                            </div>';
                            
                            
                            ?> 
                        </div>    

                    </div>   
                    
			<!-----------     Mobile version    ------------>

                    
                    <div class="text-center" id="footer_mobile">
                        <?php 
                        $fr_count =count($footer_result);
                        for ($i = 1; $i <= $fr_count; $i++){
                            if($i == 7){ $style = "width:90%; height:auto"; }else{ $style =""; }
                            if($footer_result[$i]['img_logo']){
                            echo '<div class="footer_mobile_item">
                                <a href="'.$footer_result[$i]['url'].'" target="_blank">
                                <img style="'.$style.'" src="'.$footer_result[$i]['img_logo'].'" alt="'.$footer_result[$i]['title'].'"  >
                                </a>
    
                            </div>';
                            }
                        }
                        ?>

                    </div>   
                    
					
                    <!--  Primary Sponsor -->
              </div>
				
				

            </div>

        </div>

    </div>

    <?php endif; ?>

    <!-- END FOOTER --> 

 
	<div class="clearfix"></div>
 

 

 <!-- BEGIN COPYRIGHT -->

    <div class="copyright" >

        <div class="container">

            	<div class="col-md-8" id="footer_menu">

                	  <ul>

                        <li><a href="<?php echo home_url() ?>">HOME</a></li>

                        <li><a href="/about">ABOUT</a></li>

                        <li><a href="/success-stories">SUCCESS STORIES</a></li>

                        <li><a href="/newsroom">NEWS</a></li>
                        
                        <li><a href="/advertisement">ADVERTISE</a></li>

                        <li><a href="/terms-of-use">TERMS OF USE</a></li>

                        <li><a href="/privacy-policy">PRIVACY POLICY</a></li>

                      </ul>

                </div>


                <div class="col-md-4">

                    <ul class="social-icons social-icons-color pull-right">

								<li><a href="<?php echo get_option('social_fb_link'); ?>" data-original-title="Facebook" class="facebook" target="_blank"></a></li>

								<li><a href="<?php echo get_option('social_twitter_link'); ?>" data-original-title="Twitter" class="twitter" target="_blank"></a></li>

								<li><a href="<?php echo get_option('social_google_link'); ?>" rel="publisher" data-original-title="Goole Plus" class="googleplus" target="_blank"></a></li>

								<li><a href="<?php echo get_option('social_linkedin_link'); ?>" data-original-title="Linkedin" class="linkedin" target="_blank"></a></li>

                               <li><a href="<?php echo get_option('social_youtube_link'); ?>" data-original-title="Youtube" class="youtube" target="_blank"></a></li>
							</ul>     

                  

                      <span style="display:inline; color:#555;margin: 0;" class="pull-right" ><?php echo date('Y'); ?> &copy; <?php echo MAIN_COMPANY_NAME; ?>. All Rights Reserved.</span>  

                   

                           

                </div>

                <div class="clearfix"></div>

            

        </div>

    </div>

    <!-- END COPYRIGHT -->