<?php
//$companies_vm = biz_portal_search_companies(array(), array(), 0, 50);
//$companies = $companies_vm->companies;
$q = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_STRING);
$CUR_PAGE = filter_input(INPUT_GET, 'cp', FILTER_VALIDATE_INT);


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
<div class="wrap"><div id="icon-tools" ></div>
    <h2>List Companies</h2>
    <form method="get" action="">
        <div>Search <input type="text" name="q" id="q" value="<?php echo isset($q) ? $q : ''; ?>" />
        <input type="hidden" name="page" id="page" value="<?php echo $_GET['page'] ?>" />
        &nbsp;<a href="?page=admin-list-companies">Clear Search </a>
        </div>
    </form>
    <table class="wp-list-table widefat fixed posts">
        <thead>
            <tr>
                <th>Name</th><th>Registration No.</th><th>Country of Incorporate</th><th>Year of Incorporate</th><th>Head Office</th><th>Type</th><th>Created</th>
                <th>Tools</th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0; ?>
            <?php foreach ($companies as $company) : ?>
                <?php $country = biz_portal_select_country($company->country_of_incorporate, $countries); ?>
                <?php $alternate = $i%2==0 ? 'alternate' : ''; ?>
                <tr class="format-standard <?php echo $alternate; ?>">
                    <?php $active_class = $company->active ? 'label-success' : 'label-warning'; ?>
                    <td><span class="label <?php echo $active_class; ?>"><?php echo $company->company_name ?></span></td>
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
                    <?php
                        $link_update = '?page=admin-list-companies&local_page=view&company_id=' . $company->id;
                    ?>
                        <a href="<?php echo $link_update; ?>">View</a>
                    </td>
                </tr>
            <?php $i++; endforeach; ?>
        </tbody>               
    </table>
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