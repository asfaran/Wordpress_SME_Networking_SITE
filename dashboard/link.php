<?php
/**
 * Page links
 * folder dashboard
 * @author SWISS BUREAU
 * @developer asfaran
 */



$type=filter_input(INPUT_GET, 'type', FILTER_SANITIZE_STRING);
$id=filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$base_url="http://".$_SERVER['HTTP_HOST'];

if($type==='ads' && $id != null && $id >0){
    global $wpdb;
    $sql = "SELECT * FROM " . _biz_portal_get_table_name('advertisements')."  WHERE id = $id ";
    $advertisement = $wpdb->get_row($sql);
    var_dump($advertisement);
    
    if(isset($advertisement->id) && $advertisement->id>0 ){
        $select_row = "SELECT * FROM " . _biz_portal_get_table_name('ads_clicks');
        $select_row .= " WHERE ads_id= ".$id;
        $ads_row = $wpdb->get_row($select_row);
        $click_count = $ads_row->clicks_count +1;
        var_dump($ads_row);
        
        if(isset($ads_row->ads_id) && $ads_row->ads_id >0){
            $wpdb->update(_biz_portal_get_table_name('ads_clicks'),
                    array('clicks_count' => $click_count),
                    array('ads_id' => $id),array('%d'));
            
            
        }else{
            $wpdb->insert(_biz_portal_get_table_name('ads_clicks'),
                    array('ads_id' =>$id,'clicks_count' => 1,'views_count'=>0));
        }
        $redirect_url=$advertisement->link_url;
        header( 'Location: '.$redirect_url);
        
    }else{
        header( 'Location: '.$base_url);
    }
    
}else{
    
    header( 'Location: '.$base_url);
}

?>
