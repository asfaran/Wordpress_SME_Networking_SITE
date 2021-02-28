<?php 
if (!defined('DIRECTORY'))
    die('You can not call this script.');

$stats = NULL;
$name = '';
$count = 0;
$link_url = '#';
$additional_classes = '';

switch (DIRECTORY) {
    case 'SME':
        $stats = get_option('dashboard_stats_option_sme');
        $name = 'SMEs';
        $count = biz_portal_count_company(BP_MemberType::TYPE_SME);
        $link_url = site_url('dashboard/list/sme');
        $additional_classes = 'blue sme';
        break;
    case 'BIZ_PARTNER':
        $stats = get_option('dashboard_stats_option_partner');
        $name = 'Business Partners';
        $count = biz_portal_count_company('', BP_BizNeedType::PARTNER);
        $link_url = site_url('dashboard/list/business-partners');
        $additional_classes = 'green sme';
        break;
    case 'SERV_PRO':
        $stats = get_option('dashboard_stats_option_provider');
        $name = 'Service Providers';
        $count = biz_portal_count_company('', BP_BizNeedType::PROVIDE_SERVICE);
        $link_url = site_url('dashboard/list/service-providers');
        $additional_classes = 'purple sme';
        break;
    case 'INVESTORS':
        $stats = get_option('dashboard_stats_option_investor');
        $name = 'Investors';
        $count = biz_portal_count_company('', BP_BizNeedType::PROVIDE_INVEST);
        $link_url = site_url('dashboard/list/nonprofit-organizations');
        $additional_classes = 'yellow sme';
        break;
    case 'NGO':
        $stats = get_option('dashboard_stats_option_nonprofit');
        $name = 'NonProfit Organizations';
        $count = biz_portal_count_company(BP_MemberType::TYPE_NGO);
        $link_url = site_url('dashboard/list/nonprofit-organizations');
        $additional_classes = 'pink';
        break;
}

if (is_null($stats)) { wp_redirect(site_url()); exit(); }

?>
<div class="row" style="background-color: #f8f7fc; min-height:260px;">
	<div class="col-md-12">
		<!-- BEGIN CONTAINER -->
		<div class="container">
			<!-- BEGIN SERVICE BOX -->

			<div class="row service-box">
				<div class="col-md-8 col-sm-8" style="text-align: justify">

				<?php /*?>
					<h4>
						<?php echo isset($stats['title']) ? $stats['title'] : 'SMEs DASHBOARD' ?>
					</h4>
				<?php */ ?>
					<p>
						<?php echo isset($stats['summary']) ? $stats['summary'] : ''; ?>
					</p>



				</div>
				<div class="col-md-4 col-sm-4 dashboard-stats-i">
					<div class="dashboard-stat <?php echo $additional_classes; ?>">
    				<div class="visual">
    					<i class="fa fa-shopping-cart"></i>
    				</div>
    				<div class="details">
    					<div class="number">
    						<?php echo $count; ?>
    					</div>
    					<div class="desc">                           
    						<?php echo $name; ?>
    					</div>
    				</div>
    				<a class="more" href="/dashboard">
    				Dashboard <i class="m-icon-swapright m-icon-white"></i>
    				</a>                 
    			</div>
				</div>

			</div>
			<!-- END SERVICE BOX -->

		</div>



	</div>
	<!-- END CONTAINER -->
</div>
