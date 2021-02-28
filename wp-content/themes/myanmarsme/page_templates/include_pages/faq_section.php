<!--  FAQ   -->
         
         <div id="myCarousel" class="faq_height" >

			<div class="header_title"><h3>FAQ</h3></div>
         	
            		<!-- BEGIN CAROUSEL -->
                        <div class="front-carousel">
                            <div class="carousel slide">
                                <!-- Carousel items -->
                                    <div class="container">
                                        <div class="carousel-inner">
                                        
                                         <?php
									
                                            $the_query = new WP_Query( 'category_name=faq&posts_per_page=-1&order=asc' );
                                            $c = 1;
                                            $set = 3;
                                            $total = $the_query->found_posts;
                                            $balance = $total % 3;
                                            $count= (int)$total - (int)$balance;

                                            if( $the_query->have_posts() ):

                                                    while( $the_query->have_posts() ):
                                                            $the_query->the_post();
                                                            $active = ($c <= $set) ? "active":"";


										?>
                                        <?php if(($c == 1) || (($c % $set) == 1)):   ?>
                                            <div class="item <?php echo $active;  ?> " >
                                        <?php endif; ?>
                                            
                                                <div class="col-md-4 col-sm-4 home_faq">
                                                    <a href="/faq/#<?php the_ID(); ?>" class="box shadow-radial"><?php the_title();  ?></a>
                                                </div>
                                                
                                         <?php if((($c % $set) == 0) || ($c == $total) || ($c == $count)):   ?>    
                                            </div>
                                         <?php endif; ?>
                                            
                                       <?php
					if($c == $count):
                                            break;
                                        endif;			   
                                        $c++;
                                        
                                        endwhile;	
                                        endif;	
										   
                                        ?> 
                                         
                                        </div> <!-- carousel-inner  -->
                                    </div>
                                    
                                    
                                    
									<?php wp_reset_query();  ?>                                   
                                    
								</div>
                                        <div class="text_down"><a class="front-sub-text" href="/faq">Faq</a></div>         
							</div>
							<!-- END CAROUSEL -->
           
         </div>
        
        <!--  FAQ   --> 