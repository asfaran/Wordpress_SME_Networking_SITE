<h4 class="well well-sm">Additional Information</h4>
<?php if (!$company_id > 0): ?>
<input type="hidden" name="logo_id" id="logo_id" value="" >
<input type="hidden" name="squre_image_id" id="squre_image_id" value="" >
<input type="hidden" name="attachment" id="attachment" value="" >
<?php endif; ?>

<div class="col-md-12">
	<div class="col-md-12">
        <span class="form-group">
        	<h5>About The Company</h5>
             <textarea class="form-control" rows="5" name="profile_about"><?php 
                echo $BP_Company_Full->profile->body; 
                ?></textarea>
            </span>
        </div>
</div>


<?php if (!$company_id > 0): ?>
<div class="col-md-12">
    <form class="fileupload" action="/upload/php" method="POST" enctype="multipart/form-data">    
    </form>

<div class="col-md-12"> 
    <div class="fileupload_logo">
        <input type="hidden" name="field_name" value="logo_id">
            <div class="row fileupload-buttonbar">
                    <div class="col-lg-4"><h5>Company Logo :</h5></div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <span class="btn green fileinput-button">
                                <i class="fa fa-plus"></i> <span>Upload ..</span> 
                                <input type="file" name="files">
                            </span>
                            <!-- button type="reset" class="btn yellow cancel">
                                    <i class="fa fa-ban"></i> <span>Cancel</span>
                            </button>
                            <input type="checkbox" class="toggle" -->
                            <span class="fileupload-loading"></span>
                        </div>
                    </div>													
            </div>
            <table role="presentation" class="table table-striped clearfix">
                    <tbody class="files"></tbody>
            </table>
    </div>
</div> <!--  col-md-12 Upload ____ -->

<div class="col-md-12"> 
    <div class="fileupload_profile_picture">
        <input type="hidden" name="field_name" value="squre_image_id">
            <div class="row fileupload-buttonbar">
                    <div class="col-lg-4"><h5>Profile Picture :</h5></div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <span class="btn green fileinput-button">
                                <i class="fa fa-plus"></i> <span>Upload ..</span> 
                                <input type="file" name="files">
                            </span>
                            <!-- button type="reset" class="btn yellow cancel">
                                    <i class="fa fa-ban"></i> <span>Cancel</span>
                            </button>
                            <input type="checkbox" class="toggle" -->
                            <span class="fileupload-loading"></span>
                        </div>
                    </div>													
            </div>
            <table role="presentation" class="table table-striped clearfix">
                    <tbody class="files"></tbody>
            </table>
    </div>
</div> <!--  col-md-12 Upload ____ -->

<div class="col-md-12"> 
    <div class="row fileupload-buttonbar">
        
        <div class="col-lg-4">
            <h5>Document Title:</h5>
        </div>
        <div class="col-lg-8"><div class="form-group">
            <input type="text" class="form-control" name="attachment_text"  placeholder="eg:Trade License" value="">
        </div></div>
    </div>
</div><!--  col-md-12 Upload Document Title-->

<div class="col-md-12"> 
    <div class="fileupload_docs">
        <input type="hidden" name="field_name" value="attachment">
            <div class="row fileupload-buttonbar">
                    <div class="col-lg-4"><h5>Document  :</h5></div>
                    <div class="col-lg-8">
                        <div class="form-group">
                            <span class="btn green fileinput-button">
                                <i class="fa fa-plus"></i> <span>Upload ..</span> 
                                <input type="file" name="files">
                            </span>
                            <!-- button type="reset" class="btn yellow cancel">
                                    <i class="fa fa-ban"></i> <span>Cancel</span>
                            </button>
                            <input type="checkbox" class="toggle" -->
                            <span class="fileupload-loading"></span>
                        </div>
                    </div>              
            </div>
            <table role="presentation" class="table table-striped clearfix">
                    <tbody class="files"></tbody>
            </table>
    </div>
</div> <!--  col-md-12 Upload Document  -->


</div>
    
  
<!--row  (Additional Information)  -->
    
<script id="template-upload" type="text/x-tmpl">
		{% for (var i=0, file; file=o.files[i]; i++) { %}
		    <tr class="template-upload fade">
		        <td>
		            <span class="preview"></span>
		        </td>
		        <td>
		            <p class="name">{%=file.name%}</p>
		            {% if (file.error) { %}
				<div><span class="label label-warning">Attention</span> {%=file.error%}</div>
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
		                <button name="btn_start" class="btn blue start">
		                    <i class="fa fa-upload"></i>
		                    <span>Start</span>
		                </button>
		            {% } %}
		            {% if (!i) { %}
		                <button name="btn_cancel" class="btn red cancel">
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
		                <button class="btn red delete pull-right" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
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

<?php endif; ?>
