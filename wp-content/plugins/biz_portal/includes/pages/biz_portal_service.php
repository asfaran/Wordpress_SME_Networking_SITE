<?php
/**
 * Page biz_portal_service
 *
 * @author SWISS BUREAU
 * @developer asfaran
 */

global $wpdb;
$forms_ngo_srvs=get_option('biz_forms_ngo_services');
if(!$forms_ngo_srvs){
    $forms_ngo_srvs= array();
    add_option('biz_forms_ngo_services',$forms_ngo_srvs);
    
}

if(isset($_POST['btn_submit'])){
    $srv_name = filter_input(INPUT_POST, 'srv_name', FILTER_SANITIZE_STRING);
    
    if($srv_name):
    $wpdb->insert(_biz_portal_get_table_name('biz_services'), array('service_name' => $srv_name));
        $message ='<span style="color:#009900"> New service added successfully</span>';
        
    else:
        $message ='<span style="color:#FF0000">Please,Add valid service name</span>';
    endif;
}

if(isset($_POST['btn_delete'])){
    $del_id = filter_input(INPUT_POST, 'del_id', FILTER_VALIDATE_INT);
    
    $ngo_srvs_count_query = " SELECT COUNT(*)
    FROM "._biz_portal_get_table_name('biz_services')." as srvs
    INNER JOIN "._biz_portal_get_table_name('biz_need_ngo_services')." ngo_srvs 
        ON srvs.id = ngo_srvs.service_id Where srvs.id=$del_id ";
    $ngo_srvs_count = (int)$wpdb->get_var($ngo_srvs_count_query);
    
    $give_srvs_count_query = " SELECT COUNT(*)
    FROM "._biz_portal_get_table_name('biz_services')." as srvs
    INNER JOIN "._biz_portal_get_table_name('biz_give_services')." give_srvs 
        ON srvs.id = give_srvs.service_id Where srvs.id=$del_id ";
    $give_srvs_count = (int)$wpdb->get_var($give_srvs_count_query);
    
    $need_srvs_count_query = " SELECT COUNT(*)
    FROM "._biz_portal_get_table_name('biz_services')." as srvs
    INNER JOIN "._biz_portal_get_table_name('biz_need_services')." need_srvs 
        ON srvs.id = need_srvs.service_id Where srvs.id=$del_id ";
    $need_srvs_count =  (int)$wpdb->get_var($need_srvs_count_query);
    
    if($del_id && $ngo_srvs_count ==0 && $give_srvs_count ==0 &&  $need_srvs_count ==0):
    $wpdb->delete(_biz_portal_get_table_name('biz_services'), array( 'id' => $del_id ) );
        $message_up ='<span style="color:#009900">Selected Service Deleted successfully</span>';
    elseif($del_id && ($ngo_srvs_count !=0 || $give_srvs_count !=0 ||  $need_srvs_count !=0)):
        $message_up ='<span style="color:#FF0000">Sorry,there is number of datas related to this<br/>So you cant delete selected data.</span>';   
    else:
        $message_up ='<span style="color:#FF0000">Some error occur in Deleting selected Service</span>';
    endif;
}

if(isset($_POST['btn_update'])){
    $srvs_name = filter_input(INPUT_POST, 'srvs_name', FILTER_SANITIZE_STRING);
    $srvs_id = filter_input(INPUT_POST, 'srvs_id', FILTER_VALIDATE_INT);
    
    $forms_ngo_srvs=get_option('biz_forms_ngo_services');
    if(!$forms_ngo_srvs){
        $forms_ngo_srvs= array();
        add_option('biz_forms_ngo_services',$forms_ngo_srvs);

    }
    
    if(isset($_POST['selected_srvs']) && $_POST['selected_srvs']){ 
        $forms_ngo_srvs[$srvs_id] =$srvs_id;  
        update_option('biz_forms_ngo_services', $forms_ngo_srvs);
    }else{
        if (array_key_exists($srvs_id, $forms_ngo_srvs)) {
            unset($forms_ngo_srvs[$srvs_id]);
            update_option('biz_forms_ngo_services', $forms_ngo_srvs);
            
        }else{
            update_option('biz_forms_ngo_services', $forms_ngo_srvs);
        }
        
    }
    
    if($srvs_name):
        
        $wpdb->update(_biz_portal_get_table_name('biz_services'),
                array('service_name' => $srvs_name),array('id' => $srvs_id),array('%s'));
  
        $message_up ='<span style="color:#009900">Service Name updated successfully</span>';
        
    else:
        $message_up ='<span style="color:#FF0000">Please,Update a valid service name</span>';
    endif;
}

$sql_query = " FROM " . _biz_portal_get_table_name('biz_services');
$sql = "SELECT * " . $sql_query;
$services = $wpdb->get_results($sql);

$sql_count = "SELECT COUNT(*) " . $sql_query;
?>
<script>
jQuery(document).ready(function($){
    
    $('.editraw').click(function(){
        var theRowId = $(this).closest('tr').attr('id');
        if($('#inline_'+theRowId).css('display') == 'none'){ 
            $('#inline_'+theRowId).css('display', 'block');
            $('#'+theRowId).children('div.row-actions').css('display', 'none');
        }else{
            $('#inline_'+theRowId).css('display', 'none');
            $('#'+theRowId).children('div.row-actions').css('display', 'block');
        }
    });
    });
</script>
<div class="wrap"><div id="icon-tools" ></div>
    <h2>Manage Services</h2>
    <p>&nbsp;</p>
    
<div width="50%" style="float:left">
<table class="wp-list-table widefat">
        <thead>
            <tr>
                <th >Service name</th>
                <th  width="10%"><center>Options</center></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2"><?php echo $message_up; ?></td>
            </tr>
            <?php 
            $i = 0;
            if($sql_count):
            foreach ($services as $service) :
                $delete_link = '?page=business-portal-service&action=delete&srvs_id='.$service->id;
                ?>
            <tr id="row<?php echo $i;?>">
                        <td class="post-title page-title column-title">
                                 <a class="row-title" ><strong><?php echo $service->service_name; ?> </strong></a>
                                 <div class="row-actions">
                                        <span class="inline hide-if-no-js">
                                        <span class="editraw" title="Edit this item inline" href=""><a>Edit</a></span>
                                        |
                                        </span>
                                        <span class="trash">
                                        <a class="submitdelete" href="<?php echo $delete_link; ?>" title="Move this item to the Trash">Delete</a>
                                        |
                                        </span>
                                 </div>
                                 
                                <!-- hiden fields for updation -->
                                <div id="inline_row<?php echo $i;?>" style="display:none">
                                    <form action="" method="post">
                                    <table class="wp-list-table widefat" >
                                            <thead>
                                                    <tr>
                                                        <th colspan="3" width="100%"><strong><center>Quick Update </center></strong></th>
                                                    </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Service Name</td>
                                                    <td>
                                                        <input type="text" id="srvs_name" name="srvs_name"  value="<?php echo $service->service_name; ?>">
                                                        <input type="hidden" id="srvs_id" name="srvs_id"  value="<?php echo $service->id; ?>">
                                                    </td>
                                                    <td  align="right" rowspan="2"><input type="submit" name="btn_update" id="btn_update" value="Update" class="button button-primary"></td>
                                                </tr>
                                                <tr>
                                                   <td colspan="2">
                                                      <input type="checkbox" name="selected_srvs" value="<?php echo $service->id; ?>"  
                                                            <?php  if (array_key_exists($service->id, $forms_ngo_srvs)) { echo "checked='checked'";}  ?>>
                                                        Add This Type to Selected type
                                                   </td> 
                                                </tr>
                                            </tbody>

                                        </table>
                                        </form>

                                </div>
                                <!-- hiden fields for updation ,it's also in inside of table td-->
                        </td>
                        <td><a class="submitdelete" href="<?php echo $delete_link; ?>" title="Move this item to the Trash">Delete</a></td>
                    </tr>
            <?php $i++; endforeach;
            else: ?>
            <tr>
                <td colspan="3">There is no records in Services</td>
            </tr>
            <?php 
            endif;
            ?>
         </tbody>               
    </table>
</div>
    <div width="50%" style="float:left">
        <form action="" method="post">
        <table class="wp-list-table widefat" >
            <thead>
                    <tr>
                        <th colspan="2" width="100%"><strong><center>Add New Service</center></strong></th>
                    </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2"><?php echo $message; ?></td>
                </tr>
                <tr>
                    <td>Service Name</td>
                    <td><input type="text" id="srv_name" name="srv_name" ></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><input type="submit" name="btn_submit" id="btn_submit" value="Add Service" class="button button-primary"></td>
                </tr>
            </tbody>
                
        </table>
         </form>
    </div>
</div>