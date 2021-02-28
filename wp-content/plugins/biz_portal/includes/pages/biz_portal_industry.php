<?php
/**
 * Page biz_portal_industry
 *
 * @author SWISS BUREAU
 * @developer asfaran
 */
global $wpdb;

if(isset($_POST['btn_submit'])){
    $ind_name = filter_input(INPUT_POST, 'ind_name', FILTER_SANITIZE_STRING);
    
    if($ind_name):
    $wpdb->insert(_biz_portal_get_table_name('industries'), array('ind_name' => $ind_name));
        $message ='<span style="color:#009900"> New Industry saved Successfully</span>';
        
    else:
        $message ='<span style="color:#FF0000">Please,Add valid industry name</span>';
    endif;
}

if(isset($_POST['btn_delete'])){
    $del_id = filter_input(INPUT_POST, 'del_id', FILTER_VALIDATE_INT);
    
    $com_ind_count_query = " SELECT COUNT(*)
    FROM "._biz_portal_get_table_name('industries')." as ind
    INNER JOIN "._biz_portal_get_table_name('company_industry')." com_ind 
        ON ind.id = com_ind.industry_id ";
    $com_ind_count = var_dump( (int)$wpdb->get_var($com_ind_count_query));
    
    $partner_ind_count_query = " SELECT COUNT(*)
    FROM "._biz_portal_get_table_name('industries')." as ind
    INNER JOIN "._biz_portal_get_table_name('biz_need_partner_industries')." part_ind 
        ON ind.id = part_ind.industry_id ";
    $partner_ind_count = var_dump( (int)$wpdb->get_var($partner_ind_count_query));
    
    $invest_ind_count_query = " SELECT COUNT(*)
    FROM "._biz_portal_get_table_name('industries')." as ind
    INNER JOIN "._biz_portal_get_table_name('investments_industries')." inve_ind 
        ON ind.id = inve_ind.industry_id ";
    $invest_ind_count = var_dump( (int)$wpdb->get_var($invest_ind_count_query));
    
    if($del_id && $com_ind_count==0 && $partner_ind_count ==0 && $invest_ind_count ==0):
    $wpdb->delete(_biz_portal_get_table_name('industries'), array( 'id' => $del_id ) );
        $message_up ='<span style="color:#009900">Selected Industry Deleted successfully</span>';
        
    else:
        $message_up ='<span style="color:#FF0000">Some error occur in Deleting selected Industry</span>';
    endif;
}

if(isset($_POST['btn_update'])){
    $ind_name = filter_input(INPUT_POST, 'ind_name', FILTER_SANITIZE_STRING);
    $ind_id = filter_input(INPUT_POST, 'ind_id', FILTER_VALIDATE_INT);
    
    if($ind_name):        
        $wpdb->update(_biz_portal_get_table_name('industries'),
                array('ind_name' => $ind_name),array('id' => $ind_id),array('%s'));
  
        $message_up ='<span style="color:#009900">Industry Name updated successfully</span>';
        
    else:
        $message_up ='<span style="color:#FF0000">Please,Update a valid Industry name</span>';
    endif;
}


$sql_query = " FROM " . _biz_portal_get_table_name('industries');
$sql = "SELECT * " . $sql_query;
$industries = $wpdb->get_results($sql);

$sql_count = $wpdb->get_results('SELECT COUNT(*) '.$sql_query);
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
    <h2>Manage Industries</h2>
    <p></p>
    
    <div width="50%" style="float:left">
        <table class="wp-list-table widefat"  >
                <thead>
                    <tr>
                        <th >Industry Name</th>
                        <th  width="20%"><center>Options</center></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2"><?php echo $message_up; ?></td>
                    </tr>
                    <?php 
                    $i = 0;
                    if($sql_count):
                    foreach ($industries as $industry) :
                        $delete_link = '?page=business-portal-industry&action=delete&ind_id='.$industry->id;
                    ?>
                    <tr id="row<?php echo $i;?>">
                        <td class="post-title page-title column-title">
                                 <a class="row-title" ><strong><?php echo $industry->ind_name; ?> </strong></a>
                                 <div class="row-actions">
                                        <span class="inline hide-if-no-js">
                                        <span class="editraw" title="Edit this item inline" href=""><a>Edit</a></span>
                                        |
                                        </span>
                                        <span class="trash">
                                        <a class="submitdelete" href="<?php echo $delete_link;?>" title="Move this item to the Trash">Delete</a>
                                        |
                                        </span>
                                 </div>
                                 
                                <!-- hiden fields for updation -->
                                <div id="inline_row<?php echo $i;?>" style="display:none">
                                    <form action="" method="post">
                                    <table class="wp-list-table widefat" >
                                            <thead>
                                                    <tr>
                                                        <th colspan="2" width="100%"><strong><center>Quick Update </center></strong></th>
                                                    </tr>
                                            </thead>
                                            <tbody>
                                               <tr>
                                                    <td>Industry Name</td>
                                                    <td>
                                                        <input type="text" id="ind_name" name="ind_name"  value="<?php echo $industry->ind_name; ?>">
                                                        <input type="hidden" id="ind_id" name="ind_id"  value="<?php echo $industry->id; ?>">
                                                    </td>
                                                    <td  align="right"><input type="submit" name="btn_update" id="btn_update" value="Update" class="button button-primary"></td>
                                                </tr>
                                            </tbody>

                                        </table>
                                        </form>

                                </div>
                                <!-- hiden fields for updation ,it's also in inside of table td-->
                        </td>
                        <td><a class="submitdelete" href="<?php echo $delete_link;?>" title="Move this item to the Trash">Delete</a></td>
                    </tr>
                    <?php $i++; endforeach;
                    else: ?>
                    <tr>
                        <td colspan="2">There is no records related to Industry</td>
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
                        <th colspan="2" width="100%"><strong><center>Add a New Industry </center></strong></th>
                    </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="2"><?php echo $message; ?></td>
                </tr>
                <tr>
                    <td>Industry Name</td>
                    <td><input type="text" id="ind_name" name="ind_name" ></td>
                </tr>
                <tr>
                    <td colspan="2" align="right"><input type="submit" name="btn_submit" id="btn_submit" value="Add Industry" class="button button-primary"></td>
                </tr>
            </tbody>
                
        </table>
         </form>
    </div>
</div>