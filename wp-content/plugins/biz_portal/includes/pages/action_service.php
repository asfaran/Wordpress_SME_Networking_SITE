<?php
/**
 * Page action_service
 * @date :2014/09/30
 * @author SWISS BUREAU
 * @developer asfaran
 */

global $wpdb;

$srvs_id = filter_input(INPUT_GET, 'srvs_id', FILTER_SANITIZE_STRING);

$sql_query = " FROM " . _biz_portal_get_table_name('biz_services');
$sql = "SELECT * " . $sql_query;
$sql .=" where id=" .$srvs_id;
$service = $wpdb->get_row($sql);

?>
<div class="wrap"><div id="icon-tools" ></div>
    <h2>Manage Services:</h2><h4>Delete a Service</h4>
    <p>&nbsp;</p>
    
    <form action='?page=business-portal-service' method='post'>
        <input type='hidden' name='del_id' id='del_id' value='<?php echo $srvs_id; ?>' >
    <div>
        <strong>Are You sure</strong>,You want to delete <strong><?php echo $service->service_name; ?></strong> Service From System?<br/>
        <input type='submit' name='btn_delete' id='btn_delete' value='Yes,Confirm'  class='button button-primary'>
    </div>
</form>
</div>