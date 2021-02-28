<?php 
$terms_post_id = 489;
$terms_post = get_post($terms_post_id);
$terms_post_content = apply_filters('the_content', $terms_post->post_content);

if (isset($_POST['btn_agree'])) {
    $terms_accepted = filter_input(INPUT_POST, 'chk_agree', FILTER_VALIDATE_INT);
    if ($terms_accepted == 1) {
        $current_company_id = biz_portal_get_current_company_id();
        $res = $wpdb->update(_biz_portal_get_table_name(BP_Company::$table_name), 
                array('terms_accepted' => 1), array('id' => $current_company_id), array('%d'), array('%d'));
        
        wp_redirect(site_url('dashboard'));
        exit();
    }
}

?>

<?php get_header(); ?>
<!-- END HEADER -->
<div class="clearfix"></div>
<!-- BEGIN CONTAINER -->
<div
	class="page-container  page-body profile-inner">

	<!-- BEGIN PAGE -->
	<div class="container min-hight">


		<!-- BEGIN PAGE HEADER-->
		<div class="row">
			<div class="col-md-12 margin-bottom-30">
				<!-- BEGIN PAGE TITLE & BREADCRUMB-->
				<h3 class="header_title_2">Welcome</h3>
				<?php if (BP_FlashMessage::HasMessages()) : ?>
				<?php biz_portal_get_messages(); ?>
				<?php endif; ?>
				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="row">
			<div class="col-md-12">
				<div class="note note-info">
					<h4 class="block">
						<?php echo $terms_post->post_title; ?>
					</h4>
					<p>Please read below and agree to the terms of use before you
						proceed. Thank you.</p>
				</div>
				<h2>
					<?php //echo $terms_post->post_title; ?>
				</h2>

				<?php echo $terms_post_content; ?>
				<p>&nbsp;</p>
				<form action="<?php echo site_url('dashboard/welcome') ?>" method="POST">
				<div class="well well-sm">
				    <label><input type="checkbox" value="1" name="chk_agree" class="" /> I agree to the Terms and Conditions above.</label>
				</div>
				<div>
				    <input type="submit" value="Agree" name="btn_agree" class="btn btn-success" />
				</div>
				</form>
			</div>
		</div>
		<!-- END PAGE CONTENT-->
	</div>
	<!-- END PAGE -->
</div>
<!-- END CONTAINER -->
<?php get_footer(); ?>