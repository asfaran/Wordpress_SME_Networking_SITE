 <!-- BEGIN Myanmar To your Business -->  
  <?php /*    	<div class="row"  style="background-color:#16171b">		
                <div class="container fixed-height">
                    <div class="header_title" >
                        <h3 style="color:#fff">Myanmar To your Business</h3>
                    </div> 
     	
			
            <div class="front-team">
				<ul class="list-unstyled">
            
            		<li class="col-md-3">
						<div class="thumbnail">
							
                            <a data-rel="fancybox-button"  data-fancybox-type="iframe" title="The ASEAN Story  [7:23]" href="//www.youtube.com/embed/zIZPs-eRkVU?controls=0&showinfo=0" class="fancybox-button">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/video_thumbnails/thumb1.jpg" class="img-responsive">
                            </a>
                            
							<div class="youtube_title">
								The ASEAN Story  [7:23]
							</div>
							
						</div>
					</li>
                    
					<li class="col-md-3">
						<div class="thumbnail">
							<a data-rel="fancybox-button" data-fancybox-type="iframe" title="7 Things you need to know about ASEAN  [2:24]" href="//www.youtube.com/embed/Rswa_M1xKuo?controls=0&showinfo=0" class="fancybox-button">
                            	<img src="<?php echo get_template_directory_uri(); ?>/images/video_thumbnails/thumb2.jpg" class="img-responsive">
                            </a>    
                             
							<div class="youtube_title">
								7 Things you need to know about ASEAN  [2:24]
							</div>
							
						</div>
					</li>
                    
					<li class="col-md-3">
						<div class="thumbnail">
                        
							<a data-rel="fancybox-button" data-fancybox-type="iframe" title="Myanmar's new entrepreneurs  [4:15]" href="//www.youtube.com/embed/Wc6ffmHCoco?controls=0&showinfo=0" class="fancybox-button">
                            	<img src="<?php echo get_template_directory_uri(); ?>/images/video_thumbnails/thumb3.jpg" class="img-responsive">
                            </a>    
                           
							<div class="youtube_title">
								Myanmar's new entrepreneurs  [4:15]
							</div>
							
						</div>
					</li>
                    
                    <li class="col-md-3">
						<div class="thumbnail">
                        
							<a data-rel="fancybox-button" data-fancybox-type="iframe" title="Myanmar Business Forum | 25 March 2014  [4:34]" href="//www.youtube.com/embed/MLirQqwfDAw?controls=0&showinfo=0" class="fancybox-button">
                            	<img src="<?php echo get_template_directory_uri(); ?>/images/video_thumbnails/thumb4.jpg" class="img-responsive">
                            </a>    
                           
							<div class="youtube_title">
								Myanmar Business Forum | 25 March 2014  [4:34]
							</div>
							
						</div>
					</li>
                    
                    
                    <li class="col-md-3">
						<div class="thumbnail">
							
                            <a data-rel="fancybox-button"  data-fancybox-type="iframe" title="AustCham Business in Myanmar 2014  [3:20]" href="//www.youtube.com/embed/Jmco2zbHynQ?controls=0&showinfo=0" class="fancybox-button">
                                <img src="<?php echo get_template_directory_uri(); ?>/images/video_thumbnails/thumb5.jpg" class="img-responsive">
                            </a>
                            
							<div class="youtube_title">
								AustCham Business in Myanmar 2014  [3:20]
							</div>
							
						</div>
					</li>
                    
					<li class="col-md-3">
						<div class="thumbnail">
							<a data-rel="fancybox-button" data-fancybox-type="iframe" title="Myanmar Focus Daily: Which business should invest now/later? : Doing business in Myanmar  [2:44]" href="//www.youtube.com/embed/vnvjIuSw_9Q?controls=0&showinfo=0" class="fancybox-button">
                            	<img src="<?php echo get_template_directory_uri(); ?>/images/video_thumbnails/thumb6.jpg" class="img-responsive">
                            </a>    
                             
							<div class="youtube_title">
								Myanmar Focus Daily: Which business should invest now/later? : Doing business in Myanmar  [2:44]
							</div>
							
						</div>
					</li>
					
					 <li class="col-md-3">
						<div class="thumbnail">
							<a data-rel="fancybox-button" data-fancybox-type="iframe" title="Oxford Business Group launches The Report: Myanmar 2014  [3:10]" href="//www.youtube.com/embed/dTes4QeW290?controls=0&showinfo=0" class="fancybox-button">
                            	<img src="<?php echo get_template_directory_uri(); ?>/images/video_thumbnails/thumb7.jpg" class="img-responsive">
                            </a>    
                             
							<div class="youtube_title">
								Oxford Business Group launches The Report: Myanmar 2014  [3:10]
							</div>
							
						</div>
					</li>
                    
                    
                    <li class="col-md-3">
						<div class="thumbnail">
							<a data-rel="fancybox-button" data-fancybox-type="iframe" title="Myanmar's business boom  [2:34]" href="//www.youtube.com/embed/fzfiU2k91GA?controls=0&showinfo=0" class="fancybox-button">
                            	<img src="<?php echo get_template_directory_uri(); ?>/images/video_thumbnails/thumb8.jpg" class="img-responsive">
                            </a>    
                             
							<div class="youtube_title">
								Myanmar's business boom  [2:34]
							</div>
							
						</div>
					</li>


				</ul>               
			</div>
          
           </div> 
            
             </div> */ ?>
             
              <div id="list" style="float: left; width: 230px; height: 356px; overflow: scroll; padding: 0;">
<ul id="videolist" style="list-style-type: none; padding: 0; margin-left: 10;">
<?php
$youtube = simplexml_load_file('http://gdata.youtube.com/feeds/api/videos?alt=rss&orderby=published&author=freddiew');
$first = $youtube->channel->item[0]; 
foreach ($youtube->channel->item as $item) { ?>
<li style="cursor:pointer;">
<img src="<?php echo $item->children('media', true)->group->children('media',true)->thumbnail->attributes()->url; ?>" onclick="play('<?php echo basename($item->guid); ?>');" width="200" height="150">
</li>
<?php } ?>
</ul>
</div> 
       <!-- END Myanmar To your Business -->