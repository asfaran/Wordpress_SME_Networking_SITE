<?php
/**
 * Page action_biztype
 * @date :2014/09/30
 * @author SWISS BUREAU
 * @developer asfaran
 */

global $wpdb;

$biztype_id = filter_input(INPUT_GET, 'biztype_id', FILTER_SANITIZE_STRING);

$sql_query = " FROM " . _biz_portal_get_table_name('biz_types');
$sql = "SELECT * " . $sql_query;
$sql .=" where id=" .$biztype_id;
$biztype = $wpdb->get_row($sql);
?>
<div class="wrap"><div id="icon-tools" ></div>
    <h2>Manage Business Type:</h2><h4>Delete a Biz Type</h4>
    <p>&nbsp;</p>

<form action='?page=business-portal-type' method='post'>
    <input type='hidden' name='del_id' id='del_id' value='<?php echo $biztype_id; ?>' >
    <div>
        <strong>Are You sure</strong>,You want to delete <strong><?php echo $biztype->type_text; ?></strong> Business Type From System?<br/>
        <input class='button button-primary' type='submit' name='btn_delete' id='btn_delete' value='Yes,Confirm'>
    </div>
</form>

</div>