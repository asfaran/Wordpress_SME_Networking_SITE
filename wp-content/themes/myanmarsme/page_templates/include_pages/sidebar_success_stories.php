
<div><h3 class="header_title_1">SUCCESS STORIES</h3></div>
<div style="padding: 5px 0px;">

	<div class="testimonials-v1">
		<!-- Carousel nav -->
		<div style="text-align: center" class="success_nav">
			<a class="left-btn" href="#success_stories" data-slide="prev"></a> <a
				class="right-btn" href="#success_stories" data-slide="next"></a>
		</div>

		<!-- <div id="success_stories" class="carousel slide"> -->
		<div id="success_stories" class="slide">
			<!-- Carousel items -->
			<div class="carousel-inner"  style="height:14em;">
                            <?php 
                            $c = 1;
                            $args = array(
                                'post_status' => 'publish',
                                'post_type' => 'success_story');
                            $the_query = new WP_Query( $args);
                            if( $the_query->have_posts()):
                            ?>
                            <?php
                            while( $the_query->have_posts() ):
                                $the_query->the_post();
                            if($c==1):
                                echo '<div class="active item">';
                            elseif($c!==1 && ($c%2)==1):
                                echo '<div class="item">';
                            endif;
                            ?>
                            <p >
                                <a href="/success-stories/?id=<?php echo the_ID();?>" class="success_title"><?php the_title(); ?></a>
                            </p>
                                <?php 
                            if(($c%2)==0):
                                echo '</div>';
                            endif;
                            $c++;
                            endwhile;
                            endif;
                            
                            ?>
                            
			</div>
			<!-- Carousel items -->

		</div>
		<!-- success_stories / carousel slide -->

	</div>
	<!-- testimonials-v1 -->
	<div class="sidebar_bottom_link">
		<a href="/success-stories/">Success Stories</a>
	</div>
</div>
