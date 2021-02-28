<?php
define ( 'PRIVATE_SUBMENU', true, true );
define ( 'PROFILE_PAGE', true, true );
define('MESSAGES_PAGE', true, true);
define('PARENT', 'MYACCOUNT', true);


$company_id = biz_portal_get_current_company_id();

$img_arr = array(
					'logo' 		=> 'detail_image_logo.jpg',
					'header' 	=> 'detail_image_header.jpg',
					'profile' 	=> 'detail_image_profile.jpg',
					'lightbox' 	=> 'detail_image_lightbox.jpg'
);


if (!$company_id)
{
    BP_FlashMessage::Add('No company is associated with your account', BP_FlashMessage::ERROR);
    wp_redirect(site_url('dashboard/profile'));
    exit();
}

$current_profile = null;
if ($company_id > 0)
    $current_profile = biz_portal_get_company_profile($company_id);

if ($current_profile == null)
    $current_profile = new BP_CompanyProfile($company_id);


if (isset($_POST['company_id']))
{
    $company_id = filter_input(INPUT_POST, 'company_id', FILTER_VALIDATE_INT);

    $file_upload_logo = filter_input(INPUT_POST, "file_logo", FILTER_VALIDATE_INT);
    $file_upload_header = filter_input(INPUT_POST, 'file_header', FILTER_VALIDATE_INT);
    $file_upload_squre = filter_input(INPUT_POST, 'file_squre', FILTER_VALIDATE_INT);
    $file_upload_lighbox = filter_input(INPUT_POST, 'file_lighbox', FILTER_VALIDATE_INT);

    $body = filter_input(INPUT_POST, 'summary_main', FILTER_SANITIZE_STRING);
    $body = trim($body);
    $body_looking_for = filter_input(INPUT_POST, 'summary_lookingfor', FILTER_SANITIZE_STRING);
    $body_looking_for = trim($body_looking_for);

    if ($file_upload_logo > 0)
        $current_profile->logo_id = $file_upload_logo;
    if ($file_upload_header > 0)
        $current_profile->header_image_id = $file_upload_header;
    if ($file_upload_squre > 0)
        $current_profile->squre_image_id = $file_upload_squre;
    if ($file_upload_lighbox)
        $current_profile->lightbox_image_id = $file_upload_lighbox;

    $current_profile->body = $body;
    $current_profile->body_looking_for = $body_looking_for;

    $BP_Repo_Companies = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix());
    $res = $BP_Repo_Companies->save_company_profile($current_profile);
    if ($res || $res == 0)
    {
        BP_FlashMessage::Add("Profile udpated successfully", BP_FlashMessage::SUCCESS);
        biz_portal_add_file_usage($current_profile->logo_id);
        biz_portal_add_file_usage($current_profile->header_image_id);
        biz_portal_add_file_usage($current_profile->squre_image_id);
        biz_portal_add_file_usage($current_profile->lightbox_image_id);
        wp_redirect(site_url('dashboard/profile'));
        exit();
    }
}

$unread_messages = biz_portal_pm_new();
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
				<h3 class="page-title">Profile Details</h3>
				<?php if (BP_FlashMessage::HasMessages()) : ?>
				<?php biz_portal_get_messages(); ?>
				<?php endif; ?>

				<!-- END PAGE TITLE & BREADCRUMB-->
			</div>
		</div>
		<!-- END PAGE HEADER-->
		<!-- BEGIN PAGE CONTENT-->
		<div class="row profile">
			<div class="col-md-12">
				<!--BEGIN TABS-->
				<div class="tabbable tabbable-custom tabbable-full-width">
					<ul class="nav nav-tabs">
							<li class="active"><a href="<?php echo site_url('dashboard/profile') ?>">Overview</a></li>
							<li><a href="<?php echo site_url('dashboard/profile/accounts'); ?>" >Account</a></li>
							<li><a href="<?php echo site_url('dashboard/profile/resources'); ?>?type=<?php echo urlencode(strtolower(BP_Node::NODE_TYPE_RESOURCE)) ?>" >Resources</a></li>
							<li><a href="<?php echo site_url('dashboard/profile/resources'); ?>?type=<?php echo urlencode(strtolower(BP_Node::NODE_TYPE_POST)) ?>" >Posts</a></li>
							<li><a href="<?php echo site_url('dashboard/profile/resources'); ?>?type=<?php echo urlencode(strtolower(BP_Node::NODE_TYPE_DOWNLOAD)) ?>" >Corporate Documents</a></li>
							
						</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab_1_1">
							<div class="row">
                                                            <?php /*?>
								<div class="col-md-3">
									<ul class="list-unstyled profile-nav">
										<li>
                                                                                    <img src="<?php echo biz_portal_get_file_url($current_profile->logo_id, 1, 0, 1) ?>"
											class="img-responsive" alt="" />
                                                                                </li>
										<li><a href="<?php echo site_url('dashboard'); ?>">Dashboard</a></li>
                                                                                        <li><a href="/dashboard/profile/details">Profile Details</a></li>
											<li><a href="<?php echo site_url('dashboard/messages'); ?>">Messages
                                                                                            <?php if ($unread_messages) : ?>
                                                                                                <span><?php echo $unread_messages; ?></span>
                                                                                                    <?php endif;?></a></li>
											<li><a href="<?php echo site_url('dashboard/favourites'); ?>">Favorites</a></li>
										

									</ul>
								</div>   */ ?>

								<div class="col-md-12">
									<div class="row">
										<div class="col-md-12 profile-info">
											<!--  <a href="/dashboard/profile" class="btn btn-success"><i
												class="fa fa-arrow-circle-left"></i> Back to profile</a><br />&nbsp;<br /> -->


											<!-- File Upload Forms with label by asfa -->
											<form class="fileupload_logo" action="/upload/php" method="POST"
												enctype="multipart/form-data">
												<input type="hidden" name="field_name" value="file_logo">
												<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
												<div class="row fileupload-buttonbar">
													<div class="col-lg-4">
														<span class="page-title"><h3>Logo  <sup><small><a href="#" class="display_image lightbox_example" data-id="logo" ><i class="fa fa-question-circle"></i></a></small></sup></h3> </span>
													</div>
													<div class="col-lg-3">
                                                                                                            <a target="_blank" href="<?php echo biz_portal_get_file_url($current_profile->logo_id) ?>">
													    <img src="<?php echo biz_portal_get_file_url($current_profile->logo_id, 1, 0, 1) ?>" /></a>
													</div>
													<div class="col-lg-5">
														<!-- The fileinput-button span is used to style the file input field as button -->
														<span class="btn green fileinput-button"> <i
															class="fa fa-plus"></i> <span>Upload ..</span> <input
															type="file" name="files">
														</span>
														<!-- button type="reset" class="btn yellow cancel">
															<i class="fa fa-ban"></i> <span>Cancel</span>
														</button>
														<input type="checkbox" class="toggle" -->
														<!-- The loading indicator is shown during file processing -->
														<span class="fileupload-loading"></span>
													</div>													
												</div>
												<!-- The table listing the files available for upload/download -->
												<table role="presentation"
													class="table table-striped clearfix">
													<tbody class="files"></tbody>
												</table>
											</form>
											<hr size="3">
											<form class="fileupload_profile_header_image" action="/upload/php" method="POST"
												enctype="multipart/form-data">
												<input type="hidden" name="field_name" value="file_header">
												<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
												<div class="row fileupload-buttonbar">
													<div class="col-lg-4">
														<span class="page-title"><h3>Header Image <sup><small><a href="#" data-id="header" class="display_image lightbox_example" ><i class="fa fa-question-circle"></i></a></small></sup></h3> </span>
													</div>
													<div class="col-lg-3">
													<a target="_blank" href="<?php echo biz_portal_get_file_url($current_profile->header_image_id) ?>">
													    <img src="<?php echo biz_portal_get_file_url($current_profile->header_image_id, 1, 0, 1) ?>" /></a>
													</div>
													<div class="col-lg-5">
														<!-- The fileinput-button span is used to style the file input field as button -->
														<span class="btn green fileinput-button"> <i
															class="fa fa-plus"></i> <span>Upload ..</span> <input
															type="file" name="files">
														</span>
														<!-- button type="reset" class="btn yellow cancel">
															<i class="fa fa-ban"></i> <span>Cancel</span>
														</button>
														<input type="checkbox" class="toggle" -->
														<!-- The loading indicator is shown during file processing -->
														<span class="fileupload-loading"></span>
													</div>													
												</div>
												<!-- The table listing the files available for upload/download -->
												<table role="presentation"
													class="table table-striped clearfix">
													<tbody class="files"></tbody>
												</table>
											</form>
											<hr size="3">
											<form class="fileupload_profile_picture" action="/upload/php" method="POST"
												enctype="multipart/form-data">
												<input type="hidden" name="field_name" value="file_squre">
												<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
												<div class="row fileupload-buttonbar">
													<div class="col-lg-4">
														<span class="page-title"><h3>Profile Picture <sup><small><a href="#" data-id="profile" class="display_image lightbox_example" ><i class="fa fa-question-circle"></i></a></small></sup></h3> </span>
													</div>
													<div class="col-lg-3">
													<a target="_blank" href="<?php echo biz_portal_get_file_url($current_profile->squre_image_id) ?>">
													    <img src="<?php echo biz_portal_get_file_url($current_profile->squre_image_id, 1, 0, 1) ?>" /></a>
													</div>
													<div class="col-lg-5">
														<!-- The fileinput-button span is used to style the file input field as button -->
														<span class="btn green fileinput-button"> <i
															class="fa fa-plus"></i> <span>Upload ..</span> <input
															type="file" name="files">
														</span>
														<!-- button type="reset" class="btn yellow cancel">
															<i class="fa fa-ban"></i> <span>Cancel</span>
														</button>
														<input type="checkbox" class="toggle" -->
														<!-- The loading indicator is shown during file processing -->
														<span class="fileupload-loading"></span>
													</div>													
												</div>
												<!-- The table listing the files available for upload/download -->
												<table role="presentation"
													class="table table-striped clearfix">
													<tbody class="files"></tbody>
												</table>
											</form>
											<hr size="3">
											<form class="fileupload_lightbox_image" action="/upload/php" method="POST"
												enctype="multipart/form-data">
												<input type="hidden" name="field_name" value="file_lighbox">
												<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
												<div class="row fileupload-buttonbar">
													<div class="col-lg-4">
														<span class="page-title"><h3>Lightbox Image  <sup><small><a href="#" class="display_image lightbox_example" data-id="lightbox"><i class="fa fa-question-circle"></i></a></small></sup></h3> </span>
													</div>
													<div class="col-lg-3">
													<a target="_blank" href="<?php echo biz_portal_get_file_url($current_profile->lightbox_image_id) ?>">
													    <img src="<?php echo biz_portal_get_file_url($current_profile->lightbox_image_id, 1, 0, 1) ?>" /></a>
													</div>
													<div class="col-lg-5">
														<!-- The fileinput-button span is used to style the file input field as button -->
														<span class="btn green fileinput-button"> <i
															class="fa fa-plus"></i> <span>Upload ..</span> <input
															type="file" name="files">
														</span>
														<!-- button type="reset" class="btn yellow cancel">
															<i class="fa fa-ban"></i> <span>Cancel</span>
														</button>
														<input type="checkbox" class="toggle" -->
														<!-- The loading indicator is shown during file processing -->
														<span class="fileupload-loading"></span>
													</div>													
												</div>
												<!-- The table listing the files available for upload/download -->
												<table role="presentation"
													class="table table-striped clearfix">
													<tbody class="files"></tbody>
												</table>
											</form>
											<hr size="3">
											<!-- File Upload Forms end -->
											

											<form method="post">
												<input type="hidden" name="company_id" id="company_id"
													value="<?php echo $company_id; ?>" /> <input type="hidden"
													name="file_logo" id="file_logo"
													value="<?php echo $current_profile->logo_id ?>" /> <input
													type="hidden" name="file_header" id="file_header"
													value="<?php echo $current_profile->header_image_id ?>" />
												<input type="hidden" name="file_squre" id="file_squre"
													value="<?php echo $current_profile->squre_image_id ?>" /> <input
													type="hidden" name="file_lighbox" id="file_lighbox"
													value="<?php echo $current_profile->lightbox_image_id ?>" />
												<?php /*?><h2>Summary</h2>
												<p>
													<textarea class="form-control" name="summary_main"
														id="summary_main"><?php 
														echo $current_profile->body; 
														?></textarea>
												</p>
												
												<h2>Summary looking for</h2>
												<p>
													<textarea class="form-control" name="summary_lookingfor"
														id="summary_lookingfor"><?php 
														echo $current_profile->body_looking_for; 
														?></textarea>
												</p>
												*/ ?>
												<div>
												<a href="/dashboard/profile" class="btn btn-success pull-left"><i
												class="fa fa-arrow-circle-left "></i> Back to profile</a>
													<input class="btn btn-success pull-right" type="submit"
														name="btn_submit" id="btn_submit" value="Update" />
												</div>
											</form>
										</div>
										<!--end col-md-4-->
									</div>
									<!--end row-->

								</div>
							</div>
						</div>


						<!--end tab-pane-->
					</div>
				</div>
				<!--END TABS-->
			</div>
		</div>
		<!-- END PAGE CONTENT-->
	</div>
	<!-- END PAGE -->
</div>
<!-- END CONTAINER -->
<script id="template-upload" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
		    <tr class="template-upload fade">
		        <td>
		            <span class="preview"></span>
		        </td>
		        <td>
		            <p class="name">{%=file.name%}</p>
		            {% if (file.error) { %}
		                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
		            {% } %}
		        </td>
		        <td>
		            <p class="size">{%=o.formatFileSize(file.size)%}</p>
		            {% if (!o.files.error) { %}
		                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
		                <div class="progress-bar progress-bar-success" style="width:0%;"></div>
		                </div>
		            {% } %}
		        </td>
		        <td>
		            {% if (!o.files.error && !i && !o.options.autoUpload) { %}
		                <button class="btn blue start">
		                    <i class="fa fa-upload"></i>
		                    <span>Start</span>
		                </button>
		            {% } %}
		            {% if (!i) { %}
		                <button class="btn red cancel">
		                    <i class="fa fa-ban"></i>
		                    <span>Cancel</span>
		                </button>
		            {% } %}
		        </td>
		    </tr>
		{% } %}
	</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
		    <tr class="template-download fade">
		        <td>
		            <span class="preview">
		                {% if (file.thumbnailUrl) { %}
		                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
		                {% } %}
		            </span>
		        </td>
		        <td>
		            <p class="name">
		                {% if (file.url) { %}
		                    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
		                {% } else { %}
		                    <span>{%=file.name%}</span>
		                {% } %}
		            </p>
		            {% if (file.error) { %}
		                <div><span class="label label-warning">Attention</span> {%=file.error%}</div>
		            {% } %}
		        </td>
		        <td>
		            <span class="size">{%=o.formatFileSize(file.size)%}</span>
		        </td>
                <td>
		            {% if (file.deleteUrl) { %}
		                <button class="btn red delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
		                    <i class="fa fa-trash-o"></i>
		                    <span>Delete</span>
		                </button>
		                <!-- input type="checkbox" name="delete" value="1" class="toggle" -->
		            {% } else { %}
		                <button class="btn yellow cancel">
		                    <i class="fa fa-ban"></i>
		                    <span>Cancel</span>
		                </button>
		            {% } %}
		        </td>		        
		    </tr>
		{% } %}
	</script>
    
    <script>
		var image_selected = '';
		var image_arr = {
			'logo' : 'detail_image_logo.jpg',
			'profile' : 'detail_image_profile.jpg',
			'header' : 'detail_image_header.jpg',
			'lightbox' : 'detail_image_lightbox.jpg',
			};
			
       function initialize_lightboxes()
	   {
		   var path = $('#imageShow #image_example').attr('data-path');
		   
		   var images = new Array(4);
		   
		   images[0] = new Image();
		   images[0].src = path + image_arr['logo'];
		   
		   images[1] = new Image();
		   images[1].src = path + image_arr['profile'];
		   
		   images[2] = new Image();
		   images[2].src = path + image_arr['header'];
		   
		   images[3] = new Image();
		   images[3].src = path + image_arr['lightbox'];
		   
		   
		   $('.lightbox_example').click(function(e) {
			   e.preventDefault();
			   $('#imageShow #image_example').attr('src', '');
			   var id = $(this).attr('data-id');
			   if (typeof id != 'undefined') {
				   if(image_arr.hasOwnProperty(id)) {
				  		image_selected = image_arr[id];
				   }
			   }
			   
			   
			   $('#imageShow #image_example').attr('src', path + image_selected);
			   $('#imageShow').modal('show');
		   });
	   }
	   
	</script>
    
    
    
<?php 
Theme_Vars::add_script_ready('initialize_lightboxes();');

get_footer(); ?>
<!-- Modal -->
<div class="modal fade" id="imageShow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Display Picture</h4>
      </div>
      <div class="modal-body">
        <div id="detail_picture_content">
        	<img data-path="<?php echo get_template_directory_uri(); ?>/images/private_images/" id="image_example" src="" class="img-responsive"  />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>