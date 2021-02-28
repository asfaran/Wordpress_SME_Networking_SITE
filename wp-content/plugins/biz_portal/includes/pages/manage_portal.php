<?php
/**
 * User: muneer
 * Date: 9/28/14
 * Time: 10:31 AM
 */
global $wpdb;
$BP_Repo_Companies = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix());
?>
<style>
 .portal-content{
    float: left;
    background: none repeat scroll 0 0 #fffbcc;
    border: 2px solid #e6db55;
    border-radius: 10px;
    color: #555;
    margin: 0;
    padding: 5px 10px;
    text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8)
        }
</style>
<div class="wrap">
    
    <h2>Business Portal Manager</h2>

    <hr/>

    <div class="portal-content" style="width:20%">
        <center><span><a href="<?php echo admin_url('admin.php?page=admin-list-companies') ?>">
                <img src='../wp-content/plugins/biz_portal/assets/img/Company-icon.png' />
                <h3>List Companies</h3></a></span></center>
    </div>
    <div class="portal-content" style="width:20%">
        <center><span><a href="<?php echo admin_url('admin.php?page=business-portal-options') ?>">
                <img src='../wp-content/plugins/biz_portal/assets/img/signin.png' />
                <h3>Options</h3></a></span></center>
    </div>
    <div class="portal-content" style="width:20%">
        <center><span><a href="<?php echo admin_url('admin.php?page=business-portal-industry') ?>">
                <img src='../wp-content/plugins/biz_portal/assets/img/industries.png' />
                <h3>Manage Industries</h3></a></span></center>
    </div>
    <div class="portal-content" style="width:20%">
        <center><span><a href="<?php echo admin_url('admin.php?page=business-portal-service') ?>">
                <img src='../wp-content/plugins/biz_portal/assets/img/service.png' />
                <h3>Manage Services</h3></a></span></center>
    </div>
    <div class="portal-content" style="width:20%">
        <center><span><a href="<?php echo admin_url('admin.php?page=business-portal-type') ?>">
                <img src='../wp-content/plugins/biz_portal/assets/img/types.png' />
                <h3>Manage Business Types</h3></a></span></center>
    </div>
    <div class="portal-content" style="width:20%">
        <center><span><a href="<?php echo admin_url('admin.php?page=business-portal-resource') ?>">
                <img src='../wp-content/plugins/biz_portal/assets/img/resources.png' />
                <h3>Business Resources</h3></a></span></center>
    </div>
    <div class="portal-content" style="width:20%;align:center">
        <center><span><a href="<?php echo admin_url('admin.php?page=portal-email-template') ?>">
                <img src='../wp-content/plugins/biz_portal/assets/img/email-template.jpg' />
                <h3>Email Template's</h3></a></span></center>
    </div>
    <?php /*<div class="portal-content" style="width:20%">
        <center><span><a href="<?php echo admin_url('admin.php?page=portal-dashboard-stats') ?>">
                <img src='../wp-content/plugins/biz_portal/assets/img/stats.png' />
                <h3>Dashboard Stat Options</h3></a></span></center>
    </div> */ ?>
    <div class="portal-content" style="width:20%">
        <center><span><a href="<?php echo admin_url('admin.php?page=biz-portal-advertisement') ?>">
                <img src='../wp-content/plugins/biz_portal/assets/img/advertisement.png' />
                <h3>Manage Advertisement's</h3></a></span></center>
    </div>
    <div class="portal-content" style="width:20%">
        <center><span><a href="<?php echo admin_url('admin.php?page=biz-portal-sliders') ?>">
                <img src='../wp-content/plugins/biz_portal/assets/img/sliders.png' />
                <h3>Manage Top Slider</h3></a></span></center>
    </div>
    <div class="portal-content" style="width:20%">
        <center><span><a href="<?php echo admin_url('admin.php?page=biz-portal-image') ?>">
                <img src='../wp-content/plugins/biz_portal/assets/img/image.png' />
                <h3>Manage Image's</h3></a></span></center>
    </div>
    <div class="portal-content" style="width:20%">
        <center><span><a href="<?php echo admin_url('admin.php?page=biz-portal-pages') ?>">
                <img src='../wp-content/plugins/biz_portal/assets/img/pages.png' />
                <h3>Manage Page's</h3></a></span></center>
    </div>
    <div class="portal-content" style="width:90%">
        <center><h4>Total Number of Companies</h4>
        <?php
        echo $BP_Repo_Companies->count_companies();
        ?>
        <h4>Total Number of <?php echo esc_html("SME's")?></h4>
        <?php
        echo $BP_Repo_Companies->count_companies(array('member_type_id' => BP_MemberType::TYPE_SME));
        ?></center>
    </div>

</div>