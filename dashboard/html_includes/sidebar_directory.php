<?php 
if (!defined('DIRECTORY'))
    die('This script can not be called independently');

$dir_title = '';
$dir_text = '';
$dir_link_text = '';
$dir_link = '#';
$dir_title = 'Myanmar Directory';
$dir_link_text = "View Directory";
switch (DIRECTORY) {   
    case 'SME':
        $dir_title = 'Myanmar SME\'s Directory';
        $dir_text = 'Myanmar uses technology to leapfrog its SME sector';
        //$dir_link_text = 'Myanmar Directory';
        break;
    case 'BIZ_PARTNER':
        $dir_title = 'Business Partners Directory';
        $dir_text = 'Myanmar uses technology to leapfrog its SME sector';
        //$dir_link_text = 'Myanmar Directory';
        break;
    case 'SERV_PRO' :
        $dir_title = 'Service Providers Directory';
        $dir_text = 'Myanmar uses technology to leapfrog its SME sector';
        //$dir_link_text = 'Myanmar Directory';
        break;
    case 'INVESTORS' :
        $dir_title = 'Investors Directory';
        $dir_text = 'Myanmar uses technology to leapfrog its SME sector';
        //$dir_link_text = 'Myanmar Directory';
        break;
    case 'NGO' :
        $dir_title = 'Nonprofit Organizations Directory';
        $dir_text = 'Myanmar uses technology to leapfrog its SME sector';
        //$dir_link_text = 'Myanmar Directory';
        break;
}
?>
<div
	class="col-md-4 sme_sidebar"
	style="font-size: 13px; text-align: justify;">

	<h3 class="header_title_1"><?php echo $dir_title; ?></h3>
	<div style="">

		<div class="testimonials-v1">
			<h5 class="success_title"><?php echo $dir_text; ?></h5>
		</div>
		<!-- testimonials-v1 -->

		<div class="sidebar_bottom_link">
			<a href="<?php echo $dir_link; ?>" data-target="#directory_window" data-toggle="modal"><?php echo $dir_link_text; ?></a>
		</div>
	</div>

	<div class="clearfix devider_style_ii">
		<div>&nbsp;</div>
	</div>



	<?php include __DIR__ . '/../html_includes/sidebar_success_stories.php'; ?>
	<!-- Success Stories -->
	<div class="clearfix devider_style_ii">
		<div>&nbsp;</div>
	</div>
	<?php include __DIR__ . '/../html_includes/sidebar_resources.php'; ?>
	<!-- Resources -->
	<div class="clearfix devider_style_ii">
		<div>&nbsp;</div>
	</div>


	<?php include_once("html_includes/sidebar_adds.php"); ?>


</div>
<!-- col-md-4 -->
