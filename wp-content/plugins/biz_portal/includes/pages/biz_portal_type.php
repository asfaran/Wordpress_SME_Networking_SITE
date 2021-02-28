<?php
/**
 * Page biz_portal_type
 *
 * @author SWISS BUREAU
 * @developer asfaran
 */

global $wpdb;
$forms_ngo_type=get_option('biz_forms_ngo_types');
if(!$forms_ngo_type){
    $forms_ngo_type= array();
    add_option('biz_forms_ngo_types',$forms_ngo_type);
    
}

if(isset($_POST['btn_submit'])){
    $biz_name = filter_input(INPUT_POST, 'biz_name', FILTER_SANITIZE_STRING);
    
    
    
    if($biz_name):
    $wpdb->insert(_biz_portal_get_table_name('biz_types'), array('type_text' => $biz_name));
        $message ='<span style="color:#009900"> New business type added successfully</span>';
        
    else:
        $message ='<span style="color:#FF0000">Please,Add valid business type name</span>';
    endif;
}

if(isset($_POST['btn_delete'])){
    $del_id = filter_input(INPUT_POST, 'del_id', FILTER_VALIDATE_INT);
    

    
    $com_biz_count_query = " SELECT COUNT(*)
    FROM "._biz_portal_get_table_name('biz_types')." as biztype
    INNER JOIN "._biz_portal_get_table_name('company_biz_types')." com_biztype 
        ON biztype.id = com_biztype.biz_type_id where biztype.id= $del_id";
    $com_biz_count = (int)$wpdb->get_var($com_biz_count_query);
    
    $partner_biz_count_query = " SELECT COUNT(*)
    FROM "._biz_portal_get_table_name('biz_types')." as biztype
    INNER JOIN "._biz_portal_get_table_name('biz_need_partner_biz_types')." part_biztype 
        ON biztype.id = part_biztype.biz_type_id where biztype.id= $del_id";
    $partner_biz_count = (int)$wpdb->get_var($partner_biz_count_query);
    
    
    
    if($del_id && $com_biz_count== 0 && $partner_biz_count == 0):
    $wpdb->delete(_biz_portal_get_table_name('biz_types'), array( 'id' => $del_id ) );
        $message_up ='<span style="color:#009900">Selected business type Deleted successfully</span>';
        
    elseif($del_id && $com_biz_count!= 0 && $partner_biz_count == 0) :  
        $message_up ='<span style="color:#FF0000">Sorry we cant Delete this record,<br/>There Number of Companies in selected record.</span>';
    elseif($del_id && $com_biz_count== 0 && $partner_biz_count != 0) :  
        $message_up ='<span style="color:#FF0000">Sorry we cant Delete this record,<br/>There Number of Business Need Partners in selected record.</span>';
    elseif($del_id && $com_biz_count!= 0 && $partner_biz_count != 0) :  
        $message_up ='<span style="color:#FF0000">Sorry we cant Delete this record,<br/>There Number of Companies and Business Need Partners in selected record.</span>';
    else:  
        $message_up ='<span style="color:#FF0000">Some error occur in Deleting selected Business Type</span>';
    endif;
}


if(isset($_POST['btn_update'])){
    $btype_name = filter_input(INPUT_POST, 'btype_name', FILTER_SANITIZE_STRING);
    $btype_id = filter_input(INPUT_POST, 'btype_id', FILTER_VALIDATE_INT);
    
    $forms_ngo_type=get_option('biz_forms_ngo_types');
    if(!$forms_ngo_type){
        $forms_ngo_type= array();
        add_option('biz_forms_ngo_types',$forms_ngo_type);

    }
    
    if(isset($_POST['selected_type']) && $_POST['selected_type']){ 
        $forms_ngo_type[$btype_id] =$btype_id;  
        update_option('biz_forms_ngo_types', $forms_ngo_type);
    }else{
        if (array_key_exists($btype_id, $forms_ngo_type)) {
            unset($forms_ngo_type[$btype_id]);
            update_option('biz_forms_ngo_types', $forms_ngo_type);
            
        }else{
            update_option('biz_forms_ngo_types', $forms_ngo_type);
        }
        
    }
    
    
    if($btype_name):
        
        $wpdb->update(_biz_portal_get_table_name('biz_types'),
                array('type_text' => $btype_name),array('id' => $btype_id),array('%s'));
  
        $message_up ='<span style="color:#009900"> Business type updated successfully</span>';
        
    else:
        $message_up ='<span style="color:#FF0000">Please,Update a valid business type name</span>';
    endif;
}

$sql_query = " FROM " . _biz_portal_get_table_name('biz_types');
$sql = "SELECT * " . $sql_query;
$biztypes = $wpdb->get_results($sql);

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
    <h2>Manage Business Types</h2>
    <p>&nbsp;</p>
    
<div width="50%" style="float:left">
<table class="wp-list-table widefat">
        <thead>
            <tr>
                <th >Business Type name</th>
                <th colspan="2" width="10%"><center>Options</center></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3"><?php echo $message_up; ?></td>
            </tr>
            <?php 
            if($sql_count):
            foreach ($biztypes as $biztype) : 
                $delete_link = '?page=business-portal-type&action=delete&biztype_id=' . $biztype->id;
                ?>
            <tr id="row<?php echo $i;?>">
                        <td class="post-title page-title column-title">
                                 <a class="row-title" ><strong><?php echo $biztype->type_text; ?> </strong></a>
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
                                                    <td>Business Type Name</td>
                                                    <td>
                                                        <input type="text" id="btype_name" name="btype_name"  value="<?php echo $biztype->type_text; ?>">
                                                        <input type="hidden" id="btype_id" name="btype_id" value="<?php echo $biztype->id; ?>" >
                                                     </td>
                                                    <td  align="right" rowspan="2"><input type="submit" name="btn_update" id="btn_update" value="Update" class="button button-primary"></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <input type="checkbox" name="selected_type" value="<?php echo $biztype->id; ?>"  
                                                            <?php  if (array_key_exists($biztype->id, $forms_ngo_type)) { echo "checked='checked'";}  ?>>
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
                <td colspan="3">There is no records in Types</td>
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
                        <th colspan="2" width="100%"><strong><center>Add New Business Type</center></strong></th>
                    </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2"><?php echo $message; ?></td>
                </tr>
                <tr>
                    <td>Business Type Name</td>
                    <td><input type="text" id="biz_name" name="biz_name" ></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><input type="submit" name="btn_submit" id="btn_submit" value="Add Biz Type" class="button button-primary"></td>
                </tr>
            </tbody>
                
        </table>
         </form>
    </div>
</div>