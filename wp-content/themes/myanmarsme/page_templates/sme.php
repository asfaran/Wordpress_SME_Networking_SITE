<?php
/*
  Template Name: Private SME Page
 */
define('PRIVATE_SUBMENU', true, true);
get_header();
?>
	

    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body" style="margin-top:100px;">
    
    	 <div class="fullwidthbanner-container">
				<img src="<?php echo get_template_directory_uri(); ?>/images/private_images/sme_header.jpg" class="img-responsive max_width" >                
        </div>

        <div class="row"  style="background-color:#f8f7fc">
          <div class="col-md-12">
            <!-- BEGIN CONTAINER -->
    		    <div class="container">
    			 	 <!-- BEGIN SERVICE BOX --> 
           
            <div class="row service-box">
                <div class="col-md-6 col-sm-6" style="text-align:justify">
                	
                   <h4>SMEs DASHBOARD</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus nec augue lectus. Cras pellentesque bibendum velit, in fringilla ligula pulvinar convallis. Proin a lectus dictum, tincidunt elit a, euismod velit. Etiam in hendrerit enim, lacinia sagittis tellus. In eu sem cursus, consequat mauris quis, imperdiet eros. Mauris condimentum odio non ligula porta, sit amet porttitor urna ultrices.</p>
                    <p> <img src="<?php echo get_template_directory_uri(); ?>/images/private_images/sme_img2.jpg" class="img-responsive"></p>
                   
                    
                    
                </div>
                <div class="col-md-6 col-sm-6">
                    
                    <img src="<?php echo get_template_directory_uri(); ?>/images/private_images/sme_img1.jpg" class="img-responsive">
                </div>
               
            </div>
            <!-- END SERVICE BOX -->  
			
				 
				</div>
		 					
				
			   
        		</div>
        		<!-- END CONTAINER -->
          </div>
        </div> <!-- row  -->
        
        <div class="row" style="background-color:#b6b5a0">
        	<div class="container line_break">
            	
                	To view all Category Dashboards, go to <strong>"My Account > Dashboard"</strong> or <a href="#" style="color:#fff">click here &raquo; </a>
                
              
            </div> <!-- container  -->
        </div> <!-- row  -->
        
        <div class="row" style="background-color:#fff">
        	<div class="container margin-bottom-30">
            	<div>
                
                	<h3>COMPANY LISTING</h3>
                    <div class="margin-bottom-20 margin-top-20" style="border-top:#dedede 1px solid;display:block">
                        
                        <div>
                       		<div class="small_menu" >
                                    <ul>
                                        <li><a href="#">All</a></li>
                                        <li class="dropdown list_sub_menu" id="industry_form">
                                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Industry</a>
                        					<div class="dropdown-menu extended notification" style="padding:0 0 10px 10px;">
                                            	<h4>Industry</h4>
                                               <div >
                                                    <form action="" method="post">
                                                    	<div class="form-group">
                                                         
                                                          <div class="checkbox-list">
                                                             <label>
                                                             	<input type="checkbox" name="filter_industry[]" value="1"> Industrial
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox" name="filter_industry[]" value="2"> Consumer Goods
                                                             </label>
                                                              <label>
                                                             	<input type="checkbox" name="filter_industry[]" value="3" > Consumer Services
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox" name="filter_industry[]" value="4" > Business and Professional Services
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox" name="filter_industry[]" value="5" > Hotel and Tourism
                                                             </label>
                                                          </div>
                                                       </div>
                                                       <div class="form-actions">
                                                           <button type="submit" class="btn yellow">Apply Filters <i class="fa fa-angle-double-down"></i></button>
                                                                                   
                                                        </div>   
                                                    </form>
                                               	</div>
                                            </div>
                        				</li>
                                        <li class="dropdown" id="business_type_form">
                                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Type of Business</a>
                                           <div class="dropdown-menu extended notification" style="padding:0 0 10px 10px;">
                                            	<h4>Type of Business</h4>
                                               <div >
                                                    <form action="" method="post">
                                                    	<div class="form-group">
                                                         
                                                          <div class="checkbox-list">
                                                             <label>
                                                             	<input type="checkbox" name="filter_type_business[]" value="1"> Trading
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox" name="filter_type_business[]" value="2"> Distribution
                                                             </label>
                                                              <label>
                                                             	<input type="checkbox" name="filter_type_business[]" value="3" > Services
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox" name="filter_type_business[]" value="4" > Manufacturing
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox" name="filter_type_business[]" value="5" > Engineering and Construction
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox" name="filter_type_business[]" value="6" > Other
                                                             </label>
                                                          </div>
                                                       </div>
                                                       <div class="form-actions">
                                                           <button type="submit" class="btn yellow">Apply Filters <i class="fa fa-angle-double-down"></i></button>
                                                                                   
                                                        </div>   
                                                    </form>
                                               	</div>
                                            </div>
                                        </li>
                                        <li class="dropdown" id="turnover_form">
                                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Turnover</a>
                                            <div class="dropdown-menu extended notification" style="padding:0 0 10px 10px;">
                                            	<h4>Turnover</h4>
                                               <div >
                                                    <form action="" method="post">
                                                    	<div class="form-group">
                                                         
                                                          <div class="checkbox-list">
                                                             <label>
                                                             	<input type="checkbox" name="filter_turnover[]" value="1"> Under US$500,000
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox" name="filter_turnover[]" value="2"> US$500,001 - 1,000,000
                                                             </label>
                                                              <label>
                                                             	<input type="checkbox" name="filter_turnover[]" value="3" > US$1,000,001 - 2,000,000
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox" name="filter_turnover[]" value="4" > Over US$2,000,000
                                                             </label>
                                                            
                                                          </div>
                                                       </div>
                                                       <div class="form-actions">
                                                           <button type="submit" class="btn yellow">Apply Filters <i class="fa fa-angle-double-down"></i></button>
                                                                                   
                                                        </div>   
                                                    </form>
                                               	</div>
                                            </div>
                                        </li>
                                        <li class="dropdown" id="num_employees_form">
                                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">Number of Employees</a>
                                            <div class="dropdown-menu extended notification" style="padding:0 0 10px 10px;">
                                            	<h4>Number of Employees</h4>
                                               <div >
                                                    <form action="" method="post">
                                                    	<div class="form-group">
                                                         
                                                          <div class="checkbox-list">
                                                             <label>
                                                             	<input type="checkbox" name="filter_number_employees[]" value="1"> 1 - 50
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox" name="filter_number_employees[]" value="2"> 51 - 100
                                                             </label>
                                                              <label>
                                                             	<input type="checkbox" name="filter_number_employees[]" value="3" > 101 - 200
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox" name="filter_number_employees[]" value="4" > Over 200
                                                             </label>
                                                           
                                                          </div>
                                                       </div>
                                                       <div class="form-actions">
                                                           <button type="submit" class="btn yellow">Apply Filters <i class="fa fa-angle-double-down"></i></button>
                                                                                   
                                                        </div>   
                                                    </form>
                                               	</div>
                                            </div>
                                        </li>
                                    </ul>
                            </div>
                        </div> <!--  col-md-12 -->
                       
                    </div>  <!--  margin-bottom-20 -->
                     <div style="border-bottom:#dedede 1px solid;">&nbsp;</div>
                    
                    <div class="clearfix"></div>
                	
                    <div class="col-md-8">
                    
                    	<div class="private_item margin-top-20">
                        
                            <h4 class="bold"><a href="#">SWISS &amp; CO</a> <span style="margin-left:20px;"><img src="<?php echo get_template_directory_uri(); ?>/images/private_images/sme_icon1.png" style="width:30px; height:auto" ></span></h4>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui sint blanditiis prae sentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing condimentum eleifend enim a feugiat.</p>
                            <a class="more" href="#">go to Swiss &amp; CO &raquo;</a>
                        </div> <!-- private_item  -->
                        
                        <div class="private_item margin-top-20">
                        
                            <h4 class="bold"><a href="#">WILLBURN LTD</a> <span style="margin-left:20px;"><img src="<?php echo get_template_directory_uri(); ?>/images/private_images/sme_icon2.png" style="width:30px; height:auto" ></span></h4>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui sint blanditiis prae sentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing condimentum eleifend enim a feugiat.</p>
                            <a class="more" href="#">go to Willburn LTD &raquo;</a>
                        </div> <!-- private_item  -->
                        
                        <div class="private_item margin-top-20">
                        
                            <h4 class="bold"><a href="#">CAVANDISH PTY</a> <span style="margin-left:20px;"><img src="<?php echo get_template_directory_uri(); ?>/images/private_images/sme_icon3.png" style="width:30px; height:auto" ></span></h4>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui sint blanditiis prae sentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing condimentum eleifend enim a feugiat.</p>
                            <a class="more" href="#">go to Cavandish PTY &raquo;</a>
                        </div> <!-- private_item  -->
                        
                        <div class="private_item margin-top-20">
                        
                            <h4 class="bold"><a href="#">SWISS &amp; CO</a> <span style="margin-left:20px;"><img src="<?php echo get_template_directory_uri(); ?>/images/private_images/sme_icon1.png" style="width:30px; height:auto" ></span></h4>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui sint blanditiis prae sentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing condimentum eleifend enim a feugiat.</p>
                            <a class="more" href="#">go to Swiss &amp; CO &raquo;</a>
                        </div> <!-- private_item  -->
                        
                        <div class="private_item margin-top-20">
                        
                            <h4 class="bold"><a href="#">WILLBURN LTD</a> <span style="margin-left:20px;"><img src="<?php echo get_template_directory_uri(); ?>/images/private_images/sme_icon2.png" style="width:30px; height:auto" ></span></h4>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui sint blanditiis prae sentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing condimentum eleifend enim a feugiat.</p>
                            <a class="more" href="#">go to Willburn LTD &raquo;</a>
                        </div> <!-- private_item  -->
                        
                        <div class="private_item margin-top-20">
                        
                            <h4 class="bold"><a href="#">CAVANDISH PTY</a> <span style="margin-left:20px;"><img src="<?php echo get_template_directory_uri(); ?>/images/private_images/sme_icon3.png" style="width:30px; height:auto" ></span></h4>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui sint blanditiis prae sentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing condimentum eleifend enim a feugiat.</p>
                            <a class="more" href="#">go to Cavandish PTY &raquo;</a>
                        </div> <!-- private_item  -->
                        
                        <div class="private_item margin-top-20">
                        
                            <h4 class="bold"><a href="#">SWISS &amp; CO</a> <span style="margin-left:20px;"><img src="<?php echo get_template_directory_uri(); ?>/images/private_images/sme_icon1.png" style="width:30px; height:auto" ></span></h4>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui sint blanditiis prae sentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non eleifend enim a feugiat. Pellentesque viverra vehicula sem ut volutpat. Lorem ipsum dolor sit amet, consectetur adipiscing condimentum eleifend enim a feugiat.</p>
                            <a class="more" href="#">go to Swiss &amp; CO &raquo;</a>
                        </div> <!-- private_item  -->
                        
                        <div class="pull-right">
                            <ul class="pagination pagination-centered">
                                <li><a href="#">Prev</a></li>
                                <li><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li class="active"><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">Next</a></li>
                            </ul>
                        </div>   
                        
                    </div>
                    
                    <div class="col-md-4" style="font-size:13px; text-align:justify">
                    
                    
                    	<h2 style="text-align:center">SUCCESS STORIES</h2>
						<div style="padding:5px 20px;">
                    
                        <div class="testimonials-v1">
                              <!-- Carousel nav -->
                            <div style="margin:0 auto; text-align:center ">
                            	<a class="left-btn" href="#success_stories" data-slide="prev"></a>
                            	<a class="right-btn" href="#success_stories" data-slide="next"></a>
                            </div>
                            
                            <div id="success_stories" class="carousel slide">
                                <!-- Carousel items -->
                                <div class="carousel-inner">
                                    
                                    <div class="active item">
                                        <h5 class="success_item"><a href="#" class="success_title">Denim you probably haven't heard denim you Mustache</a></h5>
                                        <h5 class="success_item"><a href="#" class="success_title">Lorem ipsum dolor met consectetur denim you Mustache</a></h5>
                                    </div>

                                    <div class="item">
                                        <h5 class="success_item"><a href="#" class="success_title">Raw denim you Mustache cliche denim you Mustache</a></h5>
                                        <h5 class="success_item"><a href="#" class="success_title">Consectetur adipisicing elit denim you Mustache</a></h5>
                                    </div>

                                    <div class="item">
                                        <h5 class="success_item"><a href="#" class="success_title">Reprehenderit butcher stache cliche tempor denim you Mustache</a></h5>
                                        <h5 class="success_item"><a href="#" class="success_title">Denim you probably haven't heard of denim you Mustache</a></h5>
                                    </div>

                                </div>
                                <!-- Carousel items -->
                          
                            </div> <!-- success_stories / carousel slide -->
                        
                        </div>  <!-- testimonials-v1 -->
                    	<p>&nbsp;</p>
                    	<div class="pull-left"><a href="success_stories_new.php">Success Stories</a></div>
                	</div>
                    	 <!-- Success Stories -->
                    
                    <div class="clearfix margin-bottom-30" style="text-align:center;padding-left:20px;"><div style="border-bottom:1px solid #ccc; width:92%; ">&nbsp;</div></div>
                    
                    
                    
                    <h2 style="text-align:center">RESOURCES</h2>
                        <div style="padding:5px 20px;" class="margin-bottom-40">
                        
                            <div class="testimonials-v1">
                                  <!-- Carousel nav -->
                                <div style="margin:0 auto; text-align:center " class="margin-bottom-10">
                                	<a class="left-btn" href="#resources_stories" data-slide="prev"></a>
                                	<a class="right-btn" href="#resources_stories" data-slide="next"></a>
                                </div>
                                
                                <div id="resources_stories" class="carousel slide margin-bottom-20">
                                    <!-- Carousel items -->
                                    <div class="carousel-inner" >
                                        
                                        <div class="active item">
                                            <h5 class="success_item">
                                            	<a href="#" class="success_title">Denim you probably haven't heard denim you Mustache</a>
                                                <div class="success_provided">Provided by <span class="text_orange">XYZ Co</span></div>
                                            </h5>
                                        	<h5 class="success_item">
                                            	<a href="#" class="success_title">Lorem ipsum dolor met consectetur denim you Mustache</a>
                                                <div class="success_provided">Provided by <span class="text_orange">XYZ Co</span></div>
                                            </h5>
                                            <h5 class="success_item">
                                            	<a href="#" class="success_title">Lorem ipsum dolor met consectetur denim you Mustache</a>
                                                <div class="success_provided">Provided by <span class="text_orange">XYZ Co</span></div>
                                            </h5>
                                        </div>

                                        <div class="item">
                                            <h5 class="success_item">
                                            	<a href="#" class="success_title">Denim you probably haven't heard denim you Mustache</a>
                                                <div class="success_provided">Provided by <span class="text_orange">XYZ Co</span></div>
                                            </h5>
                                        	<h5 class="success_item">
                                            	<a href="#" class="success_title">Lorem ipsum dolor met consectetur denim you Mustache</a>
                                                <div class="success_provided">Provided by <span class="text_orange">XYZ Co</span></div>
                                            </h5>
                                            <h5 class="success_item">
                                            	<a href="#" class="success_title">Lorem ipsum dolor met consectetur denim you Mustache</a>
                                                <div class="success_provided">Provided by <span class="text_orange">XYZ Co</span></div>
                                            </h5>
                                        </div>

                                        <div class="item">
                                            <h5 class="success_item">
                                            	<a href="#" class="success_title">Denim you probably haven't heard denim you Mustache</a>
                                                <div class="success_provided">Provided by <span class="text_orange">XYZ Co</span></div>
                                            </h5>
                                        	<h5 class="success_item">
                                            	<a href="#" class="success_title">Lorem ipsum dolor met consectetur denim you Mustache</a>
                                                <div class="success_provided">Provided by <span class="text_orange">XYZ Co</span></div>
                                            </h5>
                                            <h5 class="success_item">
                                            	<a href="#" class="success_title">Lorem ipsum dolor met consectetur denim you Mustache</a>
                                                <div class="success_provided">Provided by <span class="text_orange">XYZ Co</span></div>
                                            </h5>
                                        </div>
                                        
                                    </div>
                                    <!-- Carousel items -->
                                </div> <!-- resources_stories / carousel slide -->
                            </div>  <!-- testimonials-v1 -->
                            
                            <div class="pull-left"><a href="success_stories.php">Resources <i class="fa fa-angle-double-right"></i></a></div>
                        </div>
                    	 <!-- Resources -->
                         
                          <div class="clearfix margin-bottom-30" style="text-align:center;padding-left:20px;"><div style="border-bottom:1px solid #ccc; width:92%; ">&nbsp;</div></div>
                   
                   
                    <div style="padding:5px 20px;" class="margin-bottom-40">
                    	<img src="<?php echo get_template_directory_uri(); ?>/images/private_images/sme_ads1.jpg" class="img-responsive" >
                    </div>
                    
                    <div style="padding:5px 20px;" class="margin-bottom-40">
                    	<img src="<?php echo get_template_directory_uri(); ?>/images/private_images/sme_ads2.jpg" class="img-responsive" >	
                    </div>
                    
                    
                    </div> <!-- col-md-4 -->
                    
                    
                </div>
            </div> <!-- container  -->
        </div> <!-- row  -->

	</div>
    <!-- END PAGE CONTAINER -->  
	
   

   <?php get_footer(); ?>