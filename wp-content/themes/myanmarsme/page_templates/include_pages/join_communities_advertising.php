<!-- BEGIN JOIN COMMUNITIES -->  
       <div class="row  margin-bottom-40">
       	<div class="container margin-bottom-40">
        
           		<div class="col-md-6 col-sm-6  " >
                		<?php $content = getPageContent(452);  ?>
                       <div class="header_title text-center">
                            <h3 ><?php  echo $content['title']; ?></h3>
                        </div>
                	
                    	<div class="border_right_block join_community">
                        
                            <?php  echo $content['content']; ?>
                            
                        </div>    
                       
                   		
                        <div class="box_join margin-top-20">
                            
                            <div class="orange_holder">
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
                        
                            <div class="orange_holder">
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
                        
                            <div class="orange_holder">
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
                
                               
                <div class="col-md-6 col-sm-6  ">
                    <div  style="padding: 0 20px;" >
                    	
                        	<?php $advertise = getPageContent(810);  ?>
							<?php echo $advertise['content'];	   ?>
                        
                        <div class="text-center" style="padding:20px 0;"><a class='front-sub-text' href="/advertise">Advertising Information</a></div>
                    
                    </div>
                </div>
                
           </div>
       </div>
       <!-- END JOIN COMMUNITIES --> 