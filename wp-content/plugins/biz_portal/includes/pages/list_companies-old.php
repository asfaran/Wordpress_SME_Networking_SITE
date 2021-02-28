<?php
//$companies_vm = biz_portal_search_companies(array(), array(), 0, 50);
//$companies = $companies_vm->companies;
$q = filter_input(INPUT_POST, 'q', FILTER_SANITIZE_STRING);
$CUR_PAGE = filter_input(INPUT_POST, 'cp', FILTER_VALIDATE_INT);
if(isset($_POST['btn_submit'])){
$com_ids = $_POST['com_ids'];
$count=count($com_ids);
$com_arr=array();
if($count >0 && $count != null ){
    for ($i=0; $i<$count; $i++){
        $company = biz_portal_get_company($com_ids[$i]);
                if ($company){
                    $com_arr[] = biz_portal_load_company_relations($company);       
                }

        }
       
//        header('Content-disposition: attachment; filename=jsonFile.json');
//header('Content-type: application/json');
       header("Content-Type: text/plain");
header("Content-disposition: attachment; filename=\"company_list.txt\""); 
$json= file_put_contents("company_list.txt",json_encode($com_arr));

echo( $json);
       
}else{
  ?>
<script> alert('Pls Select Atleast One Company to Export');</script>
<?php 
    
}  
   
}


$countries = biz_portal_get_country_list();
$sql_base = "FROM " . _biz_portal_get_table_name('companies');
if (!empty($q))
{
    $sql_base .= " WHERE LOWER(company_name) LIKE '%" . strtolower($q) . "%'";
}
$sql_count = "SELECT COUNT(*) " . $sql_base;

$COUNT = $wpdb->get_var($sql_count);
$PER_PAGE = 30;
$TOTAL_PAGES = ceil($COUNT/$PER_PAGE);

if ($CUR_PAGE > $TOTAL_PAGES)
    $CUR_PAGE = $TOTAL_PAGES;
if ($CUR_PAGE < 1 )
    $CUR_PAGE = 1;
$START = (($CUR_PAGE * $PER_PAGE ) - $PER_PAGE);

$sql = "SELECT * " . $sql_base . ' ORDER BY created DESC LIMIT ' . $START . ', ' . $PER_PAGE;
$companies = $wpdb->get_results($sql);

?>
<style>
.label {padding:1px 4px;border-radius: 5px}
.label-warning {background-color:#FAAC58;}
.label-success {background-color:#9FF781;}
.pagination li {
    list-style: none;
    float: left;
}
.pagination li a {
    display: block;
    display: block;
    padding: 5px;
    border: 1px #ccc solid;
    margin-right: 10px;
    background: #ddd;
    text-decoration:none;
}
.pagination li a:hover {
    background: #cccccc;
}
</style>
<script>
function checkAll() {
    var ele = document.getElementById('com_check');
     var checkboxes = document.getElementsByName('com_ids[]');
     if (ele.checked===true) {
         for (var i = 0; i < checkboxes.length; i++) {
             
                 checkboxes[i].checked = true;
         }
     } else {
         for (var i = 0; i < checkboxes.length; i++) {
             console.log(i)
                 checkboxes[i].checked = false;
         }
     }
 }
</script>
<div class="wrap"><div id="icon-tools" ></div>
    <h2>List Companies</h2>
    <form method="post" action="">
        <div><input type="submit" name="btn_submit" id="btn_submit" value="Export" class="button button-primary">
            &nbsp;&nbsp;<strong>Search</strong> 
            <input type="text" name="q" id="q" value="<?php echo isset($q) ? $q : ''; ?>" />
            <input type="hidden" name="page" id="page" value="<?php echo $_GET['page'] ?>" />&nbsp;
            <input type="button" value="Clear Search" onClick="location.href='?page=admin-list-companies'"  class="button button-primary">
        
        </div>
    
    <table class="wp-list-table widefat fixed posts">
        <thead>
            <tr>
                <th width="5%"><input type="checkbox" name="com_check" id="com_check" value=""  onchange="checkAll()"></th>
                <th>Name</th>
                <th>Registration No.</th>
                <th>Country of Incorporate</th>
                <th>Year of Incorporate</th>
                <th>Head Office</th>
                <th>Type</th>
                <th>Created</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            <?php foreach ($companies as $company) : ?>
                <?php $country = biz_portal_select_country($company->country_of_incorporate, $countries); ?>
                <?php $alternate = $i%2==0 ? 'alternate' : ''; 
                $link_update = '?page=admin-list-companies&local_page=view&company_id=' . $company->id;
                ?>
                <tr class="format-standard <?php echo $alternate; ?>">
                    <?php $active_class = $company->active ? 'label-success' : 'label-warning'; ?>
                    <td><input type="checkbox" name="com_ids[]" id="com_ids" value="<?php echo $company->id; ?>" ></td>
                    <td>
                        <a href="<?php echo $link_update; ?>">
                            <span class="label <?php echo $active_class; ?>">
                                <?php echo $company->company_name ?>
                            </span>
                        </a>
                    </td>
                    <td><?php echo $company->reg_number ?></td>
                    <td><?php echo $country['country_name'] ?></td>
                    <td><?php echo $company->year_of_incorporate ?></td>
                    <td><?php echo $company->location_head_office ?></td>
                    <td>
                        <?php 
                        if ($company->member_type_id === BP_MemberType::TYPE_SME)
                            echo 'SME';
                        else if ($company->member_type_id === BP_MemberType::TYPE_INTL)
                            echo 'International';
                        else if ($company->member_type_id === BP_MemberType::TYPE_NGO)
                            echo 'NGO';
                        else if (!empty($company->member_type_id))
                            echo esc_attr($company->member_type_id);  
                        ?>
                    </td>
                    <td><?php echo $company->created ?></td>
                    <td>
                        <a href="<?php echo $link_update; ?>">View</a>
                    </td>
                </tr>
            <?php $i++; endforeach; ?>
        </tbody>               
    </table>
    </form>
</div>
<div>
    Pages <ul class="pagination">
        <?php for ($i=0; $i<$TOTAL_PAGES;$i++) : ?>
            <?php 
            if (isset($_GET['q']))
                $url = "?page=admin-list-companies&cp=" . ($i+1) . "&q=" . $_GET['q'];
            else
                $url = "?page=admin-list-companies&cp=" . ($i+1);
            ?>
            <li><a href="<?php echo $url; ?>"><?php echo ($i+1); ?></a></li>
        <?php endfor ?>
    </ul>
</div>

<script>
$(document).ready( function() {
    BizPortal_Admin.init({rootUrl:'<?php echo site_url(); ?>'});
});
</script>