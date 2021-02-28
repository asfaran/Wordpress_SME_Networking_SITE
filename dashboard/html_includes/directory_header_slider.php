<?php
/**
 * Page directory_slider
 * folder html_includes
 * @author SWISS BUREAU
 * @developer asfaran
 */
global $wpdb;
$result = get_option('dashboard_directory_slider_'.$type);

$type_arr=array(
    'sme' => BP_CustomPage::SME,
    'partner' => BP_CustomPage::BUSINESS_PARTNER,
    'provider' => BP_CustomPage::SERVICE_PROVIDER,
    'investor' => BP_CustomPage::INVESTOR,
    'nonprofit' => BP_CustomPage::NGOs
);

$select_count = "SELECT COUNT(*) ";
$select_result = "SELECT com.*,profile.header_image_id as img_id  ";

if($type_arr[$type] == BP_CustomPage::NGOs):
    
    $directry_sql = " FROM " . _biz_portal_get_table_name('companies')." as com
            INNER JOIN " . _biz_portal_get_table_name('company_profile')." as profile 
                ON com.id = profile.company_id
                LEFT JOIN " . _biz_portal_get_table_name('scores')." as score 
                    ON com.id = score.company_id 
                    WHERE  (bool_biz_need_partner_in=1 OR  
                    bool_biz_need_service=1 AND bool_biz_need_invest=1 OR  
                    bool_biz_need_ngo_supp_serv=1 OR bool_biz_give_service=1 OR 
                    bool_biz_give_invest=1 ) 
                    AND com.member_type_id=".BP_MemberType::TYPE_NGO." 
                        AND profile.header_image_id > 0 
                        ORDER BY score.scores DESC
                        LIMIT 2 ";

elseif($type_arr[$type] == BP_CustomPage::INVESTOR):
    
        $directry_sql = "SELECT com.*,profile.header_image_id as img_id 
        FROM " . _biz_portal_get_table_name('companies')." as com
            INNER JOIN " . _biz_portal_get_table_name('company_profile')." as profile 
                ON com.id = profile.company_id
                LEFT JOIN " . _biz_portal_get_table_name('scores')." as score 
                    ON com.id = score.company_id 
                    WHERE  bool_biz_give_invest = 1
                    AND profile.header_image_id  > 0  
                    ORDER BY score.scores DESC
                    LIMIT 2 ";
    
elseif($type_arr[$type] == BP_CustomPage::BUSINESS_PARTNER):
    
        $directry_sql = "SELECT com.*,profile.header_image_id as img_id 
        FROM " . _biz_portal_get_table_name('companies')." as com
            INNER JOIN " . _biz_portal_get_table_name('company_profile')." as profile 
                ON com.id = profile.company_id
                LEFT JOIN " . _biz_portal_get_table_name('scores')." as score 
                    ON com.id = score.company_id 
                    WHERE  bool_biz_need_partner_in= 1 
                    AND profile.header_image_id > 0 
                    ORDER BY score.scores DESC
                    LIMIT 2 ";
    
elseif($type_arr[$type] == BP_CustomPage::SME):
    
    $directry_sql = "SELECT com.*,profile.header_image_id as img_id 
    FROM " . _biz_portal_get_table_name('companies')." as com
        INNER JOIN " . _biz_portal_get_table_name('company_profile')." as profile 
            ON com.id = profile.company_id
            LEFT JOIN " . _biz_portal_get_table_name('scores')." as score 
                ON com.id = score.company_id 
                WHERE  (bool_biz_need_partner_in=1 OR  
                bool_biz_need_service=1 AND bool_biz_need_invest=1 OR  
                bool_biz_need_ngo_supp_serv=1 OR bool_biz_give_service=1 OR 
                bool_biz_give_invest=1 ) 
                AND com.member_type_id=".BP_MemberType::TYPE_SME."  
                    AND profile.header_image_id > 0  
                    ORDER BY score.scores DESC
                    LIMIT 2 ";
    
elseif($type_arr[$type] == BP_CustomPage::SERVICE_PROVIDER):
    
    $directry_sql = "SELECT com.*,profile.header_image_id as img_id 
    FROM " . _biz_portal_get_table_name('companies')." as com
        INNER JOIN " . _biz_portal_get_table_name('company_profile')." as profile 
            ON com.id = profile.company_id
            LEFT JOIN " . _biz_portal_get_table_name('scores')." as score 
                ON com.id = score.company_id 
                WHERE 
                bool_biz_give_service=1   
                AND profile.header_image_id > 0
                ORDER BY score.scores DESC
                LIMIT 2 ";
    
endif;

$dir_header_list = $wpdb->get_results($select_result.$directry_sql, ARRAY_A);

$list_count= $wpdb->get_var($select_count.$directry_sql);
if($list_count === 2){
$dir_imge_id_one=$dir_header_list[0]->img_id;
$dir_imge_id_two=$dir_header_list[1]->img_id;
}elseif($list_count === 1){
$dir_imge_id_one=$dir_header_list[0]->img_id; 
}

?>

 <div class="top_banner_header">
        <div>
            <div >
                <div  id="carousel-directory" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                      <?php 
                      $default_img=$result['img_big'];
                      $default_small= $result['img_small'];
                      
                     $content_default = "<div class='item  active'>";
                     $content_default .= "<div class='brightness desktop_only' style='height: 418px; background-image:  url(&#39;".$default_img."&#39;);' ></div>";
                     $content_default .= "<div class='brightness mobile_only' style='height: 220px;  background-image:  url(&#39;".$default_small."&#39;);' ></div>";
                     $content_default .= "</div>";
                      
                      if($result['mode']== 1){
                      $image_array=array();
                      $image_res1=biz_portal_get_advertisement('ADS_TYPE_DIRECTORY');
                      $img_id1=$image_res1->image_id;
                      $image_array[]=$img_id1;
                      
                      if($img_id1){
      
                      ?>
                        <div class="item active">
                            <div class="brightness"  style="height: 418px; background-image:  url('<?php  echo biz_portal_get_file_url($img_id1); ?>');">
                            </div>
                        </div>
                     <?php 
                      }else{
                          
                          echo $content_default;
                      }
                     if($dir_imge_id_one){
                         ?>
                         <div class="item">
                            <div class="brightness" style="height: 418px; background-image:  url('<?php echo biz_portal_get_file_url($dir_imge_id_one); ?>');">
                            </div>
                        </div>
                     <?php  } elseif($img_id1) { 
                         
                         echo $content_default;
                         
                     }
                     if(is_array(implode(",", $image_array))){
                        $result_array = array_map('trim',implode(",", $image_array));
                        $image_res2=biz_portal_get_advertisement('ADS_TYPE_DIRECTORY',$result_array);
                        if(is_array($image_res2) && count($image_res2)>0){
                        $img_id2=$image_res2->image_id;
                        $image_array[]=$img_id2;
                        biz_portal_add_ads_view($image_res2->id);
                        ?>
                        <div class="item">
                            <div class="brightness" style="height: 418px; background-image:  url('<?php echo biz_portal_get_file_url($img_id2); ?>');">
                            </div>
                        </div>
                    <?php  } }elseif($dir_imge_id_one){  
                        
                        echo $content_default;
                    } 
                    if($dir_imge_id_two){
                    ?> 
                        <div class="item">
                            <div class="brightness" style=" height: 418px; background-image:  url('<?php echo biz_portal_get_file_url($dir_imge_id_two); ?>');">
                            </div>
                        </div>
                    <?php }elseif($img_id2){ 
                        
                        echo $content_default;
                        
                        }
                     
                      }else{
                          
                       echo $content_default; 
                       
                      }
                      
                    ?>
                    </div>
                  <!-- Controls -->
                  <?php 
                  if($result['mode']== 1):
//                      && $list_count >= (int)1
                  ?>
                  <a class="left carousel-control banner-fixed-height" href="#carousel-directory" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                  </a>
                  <a class="right carousel-control banner-fixed-height" href="#carousel-directory" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                  </a>
		  <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- END Directory SLIDER -->
        </div>