<?php
/**
 * Page sidebar_adds
 * folder html_includes
 * @author SWISS BUREAU
 * @developer asfaran
 */
?>
<div style="padding:5px 20px;" class="margin-bottom-40">
                        <?php 
                        $image_array=array();
                        $image_res1=biz_portal_get_advertisement('ADS_TYPE_SIDEBAR');
                        $img_id1=$image_res1->image_id;
                        $image_array[]=$img_id1;
                        biz_portal_add_ads_view($image_res1->id);
                        ?>
                        <a href="/dashboard/link?type=ads&id=<?php echo $image_res1->id;?>" target="_blank">
                        <img src="<?php echo biz_portal_get_file_url($img_id1); ?>" class="img-responsive" >
                        </a>
</div>
                    
<div style="padding:5px 20px;" class="margin-bottom-40">
                        <?php 
                        $image_res2=biz_portal_get_advertisement('ADS_TYPE_SIDEBAR',$image_array);
                        $img_id2=$image_res2->image_id;
                        $image_array[]=$img_id2;
                        biz_portal_add_ads_view($image_res2->id);
                        
                        ?>
                        <a href="/dashboard/link?type=ads&id=<?php echo $image_res2->id;?>"  target="_blank">
                    	<img src="<?php echo biz_portal_get_file_url($img_id2); ?>" class="img-responsive" >
                        </a>
</div>