 <!-- BEGIN JOIN COMMUNITIES -->  
       
       <div class="row  margin-bottom-40">
       		<div class="container margin-bottom-40">
           		<div class="col-md-6 col-sm-6  " >
                <?php $content = getPageContent(452);  ?>
                   <div class="header_title text-center">
                        <h3 ><?php  echo $content['title']; ?></h3>
                    </div>
                	
                    <div  class="border_right_block join_community">
                        
                            <?php  echo $content['content']; ?>
                            
                    </div>        
                       
                   		<div class="box_join margin-top-20" >
                            
                            <div style="" class="orange_holder">
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
                        
                            <div  class="orange_holder">
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
                        
                            	<div  class="orange_holder">
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
                        	<div class="clearfix"></div>
                       	</div>	
                        
                        
                       
                        
                    
                </div>
                
                               
                 <div class="col-md-6 col-sm-6 text-center">
                    <div class="text-center">
                         	<div class="header_title">
                        		<h3>RESOURCES</h3>
                        	</div>
                    </div>
                    <p class="text-center" style="width:100%" id="resources_holder">
                    	<img src="<?php echo get_template_directory_uri(); ?>/images/resources.jpg" class="text-center" >
                    </p>
                    <p style="text-align:left; padding:20px;" >
                    <?php 
                    $edit_class = ''; $edit_location='';
                    if (current_user_can('edit_post')) {
                        $edit_class = 'admin_udpate_spot';
                        $edit_location = 'options';
                    }
                    ?>
                    <span data-location="<?php echo $edit_location; ?>" data-id="content_resource_description" class="<?php echo $edit_class; ?>">
                    <?php echo get_option('content_resource_description') ?></span>
                    </p>
                    <div style="text-align:center; "><a class="front-sub-text"  href="<?php echo site_url('resources'); ?>">Resources</a></div> 
                </div>
                
           </div>
       </div>
       <!-- END JOIN COMMUNITIES --> 