<?php
/**
 * Page action_industry
 * @date :2014/09/30
 * @author SWISS BUREAU
 * @developer asfaran
 */

global $wpdb;

$ind_id = filter_input(INPUT_GET, 'ind_id', FILTER_SANITIZE_STRING);

$sql_query = " FROM " . _biz_portal_get_table_name('industries');
$sql = "SELECT * " . $sql_query;
$sql .=" where id=" .$ind_id;
$industry = $wpdb->get_row($sql);
?>
<div class="wrap"><div id="icon-tools" ></div>
    <h2>Manage Industries:</h2><h4>Delete a Industry</h4>
    <p>&nbsp;</p>
    
    <form action='?page=business-portal-industry' method='post'>
        <input type='hidden' name='del_id' id='del_id' value='<?php echo $ind_id; ?>' >
    <div>
        <strong>Are You sure</strong>,You want to delete <strong><?php echo $industry->ind_name; ?></strong> Industry From System?<br/>
        <input type='submit' name='btn_delete' id='btn_delete' value='Yes,Confirm' class='button button-primary'>
    </div>
</form>
</div>
