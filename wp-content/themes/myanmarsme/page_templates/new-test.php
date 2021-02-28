<!-- BEGIN Directory SLIDER -->    
    <div class="row fixed-height" >
    <div>
        <div>
            <div  id="carousel-directory" class="carousel slide" data-ride="carousel">
                <!-- Wrapper for slides -->
                <div class="carousel-inner">
                  <?php 
                  $default_img=get_template_directory_uri().'/images/private_images/sme_header.jpg';
                          
                  $image_array=array();
                  $image_res1=biz_portal_get_advertisement('ADS_TYPE_DIRECTORY');
                  $img_id1=$image_res1->image_id;
                  $image_array[]=$img_id1;
                  
                  biz_portal_add_ads_view($image_res1->id);
                  ?>
                    <div class="item active">
                        <div class="brightness">
                            <div class="overlay"></div>
                            <img 
                                src="<?php if($img_id1){ echo biz_portal_get_file_url($img_id1);}else{ echo $default_img;} ?>"  style="bottom:0;left:0;">
                        </div>
                    </div>
                <?php
                
                if($img_id1){
                    $image_res2=biz_portal_get_advertisement('ADS_TYPE_DIRECTORY',$image_array);
                    $img_id2=$image_res2->image_id;
                    $image_array[]=$img_id2;
                    biz_portal_add_ads_view($image_res2->id);
                    ?>
                    <div class="item active">
                        <div class="brightness">
                            <div class="overlay"></div>
                            <img src="<?php echo biz_portal_get_file_url($img_id2); ?>"  style="bottom:0;left:0;">
                        </div>
                    </div>
                <?php } ?>
                </div>
                  

              <!-- Controls -->
              <a class="left carousel-control" href="#carousel-directory" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
              </a>
              <a class="right carousel-control" href="#carousel-directory" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
              </a>
            </div>
        </div>                  
    </div>
    </div>
<!-- BEGIN Directory SLIDER -->