<?php 
$abt_result=get_option('about_module_content');

?> 

<!-- BEGIN CONTAINER About The Platform-->   
        <div class="row margin-bottom-40">
            <div class="container" id="container-row">
                <!-- BEGIN SERVICE BOX --> 
                 
                <div class="row">
                    <div class="col-md-7 col-sm-7">
			<div class="header_title pull-left" style="text-align:left">
                    		<h3><?php echo $abt_result['title']; ?></h3>
                	</div> 
                       <div class="home_about_platform_content">
                            <?php 
                                $content = getPageContent($abt_result['about_data']);  
                                echo $content['content'];	
                            ?>
                        	<p class="home_about_link" >
                                    <a class="front-sub-text" href="<?php echo $abt_result['link']; ?>">
                                        <?php echo $abt_result['footer']; ?>
                                    </a>
                                </p>
                        </div>
                    </div>
                    <div class="col-md-5 col-sm-5">
                        <!-- BEGIN CAROUSEL -->            
                            <?php myanmarsme_get_about_slider(); ?>
						<!-- END CAROUSEL --> 
                    </div>
                   
                </div>
                <!-- END SERVICE BOX -->  
            </div>   
        </div>
        <!-- END CONTAINER About The Platform -->  