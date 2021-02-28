 <!-- BEGIN Myanmar To your Business -->  
 <?php 
 $video_result=get_option('video_module_content');
 
 ?>
 <div class="row"  style="background-color:#16171b">
     <div class="container fixed-height">
         <div class="header_title" >
             <h3 style="color:#fff"><?php echo $video_result['title']; ?></h3>
         </div>
         <div class="front-team">
             <ul class="list-unstyled">
                     <?php
                     if($video_result['type']=='channel'){
                         $youtube = simplexml_load_file('http://gdata.youtube.com/feeds/api/users/'.$video_result['link'].'/uploads?alt=rss&max-results='.$video_result['count']);
                     }else{
                         
                         $youtube = simplexml_load_file('http://gdata.youtube.com/feeds/api/playlists/'.$video_result['link'].'?alt=rss&max-results='.$video_result['count']);
                     }
                     $raw_column = 12/($video_result['count']/2);
                     
                     foreach ($youtube->channel->item as $item) {
                         
                         $guid_split = parse_url($item->link);
                         parse_str($guid_split['query'],$temp_v);
                         $duration =biz_portal_get_video_duration('youtube' ,$item->link );
                         $thumbnail = (string)$item->children('media', true)->group->thumbnail[0]->attributes()->url;
                         $thumbnail = str_replace('0.jpg', 'mqdefault.jpg', $thumbnail);
                         
                         
                         ?>
                         <li class="col-md-<?php echo $raw_column; ?>">
                             <div class="thumbnail">

                                    <a data-rel="fancybox-button"  data-fancybox-type="iframe" title="<?php echo $item->title." &nbsp;[".$duration."]"; ?>" href="//www.youtube.com/embed/<?php echo $temp_v['v']; ?>?controls=0&showinfo=0" class="fancybox-button">
                                        <img  src="<?php echo $thumbnail; ?>" class="img-responsive">
                                    </a>
                                 <div class="youtube_title">
                                     <?php echo $item->title." &nbsp;[".$duration."]"; ?>
                                 </div>

                             </div>
                         </li>
                     <?php } ?>                  
             </ul>
         </div>
     </div>
 </div>
       <!-- END Myanmar To your Business -->