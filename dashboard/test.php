<?php 

/*$count_above = 23;
$count_below = 24;
$total = $count_above+$count_below;
 
$offset = 0;
$count = 10;
 
if ($total < $count)
    $offset = 0;
else if ($count_below >= ($count/2) && $count_above >= ($count/2))
    $offset = $count_below - ($count/2);
else if ($count_above < (($count/2)) -1 )
    $offset = (($total - $count_below) > 0) ? ($total - $count_below) : 0;

echo $offset;*/

$repo_node = new BP_Repo_Nodes($wpdb, biz_portal_get_table_prefix());

//$type = filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING);/
//$option_id = filter_input(INPUT_POST, 'option_id', FILTER_VALIDATE_INT);
//$cat = filter_input(INPUT_POST, 'cat', FILTER_VALIDATE_INT);

$results = $repo_node->find_nodes_included(BP_Node::NODE_TYPE_RESOURCE, 45, 10);

echo "<pre>";
print_r($results);
echo "</pre>";

exit();


get_header();
?>


			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			<p>&nbsp;</p>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<blockquote>
						<p style="font-size:16px">File Upload widget with multiple file selection, drag&amp;drop support, progress bars and preview images for jQuery.<br>
							Supports cross-domain, chunked and resumable file uploads and client-side image resizing.<br>
							Works with any server-side platform (PHP, Python, Ruby on Rails, Java, Node.js, Go etc.) that supports standard HTML form file uploads.
						</p>
					</blockquote>
					<br>
					<form class="fileupload" action="/upload/php" method="POST" enctype="multipart/form-data">
						<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
						<div class="row fileupload-buttonbar">
							<div class="col-lg-7">
								<!-- The fileinput-button span is used to style the file input field as button -->
								<span class="btn green fileinput-button">
								<i class="fa fa-plus"></i>
								<span>Add files...</span>
								<input type="file" name="files">
								</span>
								<button type="reset" class="btn yellow cancel">
								<i class="fa fa-ban"></i>
								<span>Cancel upload</span>
								</button>
								<input type="checkbox" class="toggle">
								<!-- The loading indicator is shown during file processing -->
								<span class="fileupload-loading"></span>
							</div>
							<!-- The global progress information -->
							<div class="col-lg-5 fileupload-progress fade">
								<!-- The global progress bar -->
								<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
									<div class="progress-bar progress-bar-success" style="width:0%;"></div>
								</div>
								<!-- The extended global progress information -->
								<div class="progress-extended">&nbsp;</div>
							</div>
						</div>
						<!-- The table listing the files available for upload/download -->
						<table role="presentation" class="table table-striped clearfix">
							<tbody class="files"></tbody>
						</table>
					</form>
					<div>test</div>
					<form class="fileupload" action="/upload/php" method="POST" enctype="multipart/form-data">
						<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
						<div class="row fileupload-buttonbar">
							<div class="col-lg-7">
								<!-- The fileinput-button span is used to style the file input field as button -->
								<span class="btn green fileinput-button">
								<i class="fa fa-plus"></i>
								<span>Add files...</span>
								<input type="file" name="files">
								</span>
								<button type="reset" class="btn yellow cancel">
								<i class="fa fa-ban"></i>
								<span>Cancel upload</span>
								</button>
								<input type="checkbox" class="toggle">
								<!-- The loading indicator is shown during file processing -->
								<span class="fileupload-loading"></span>
							</div>
							<!-- The global progress information -->
							<div class="col-lg-5 fileupload-progress fade">
								<!-- The global progress bar -->
								<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
									<div class="progress-bar progress-bar-success" style="width:0%;"></div>
								</div>
								<!-- The extended global progress information -->
								<div class="progress-extended">&nbsp;</div>
							</div>
						</div>
						<!-- The table listing the files available for upload/download -->
						<table role="presentation" class="table table-striped clearfix">
							<tbody class="files"></tbody>
						</table>
					</form>
					<div class="panel panel-success">
						<div class="panel-heading">
							<h3 class="panel-title">Demo Notes</h3>
						</div>
						<div class="panel-body">
							<ul>
								<li>The maximum file size for uploads in this demo is <strong>5 MB</strong> (default file size is unlimited).</li>
								<li>Only image files (<strong>JPG, GIF, PNG</strong>) are allowed in this demo (by default there is no file type restriction).</li>
								<li>Uploaded files will be deleted automatically after <strong>5 minutes</strong> (demo setting).</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
	<!-- END CONTAINER -->
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
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
		                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
		            {% } %}
		        </td>
		        <td>
		            <span class="size">{%=o.formatFileSize(file.size)%}</span>
		        </td>		        
		    </tr>
		{% } %}
	</script>
	<?php get_footer();