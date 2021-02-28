var FormFileUpload = function () {

	var $ = jQuery;

    return {
        //main function to initiate the module
        init: function () {

             // Initialize the jQuery File Upload widget:
            $('.fileupload').fileupload({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},                
            	autoUpload: true,
                url: '/upload/php/'
                
            });
            
            $('.fileupload').bind('fileuploadcompleted', function(e, data) {            	
            	var file = data.result.files[0];
            	var id = file.id;
            	var field_name = $('input[name=field_name]', this).val();
            	$("#" + field_name).val(id);
            });

            // Enable iframe cross-domain access via redirect option:
            $('.fileupload').fileupload(
                'option',
                'redirect',
                window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                )
            );

            // settings:
            $('.fileupload').fileupload('option', {
                url: $('.fileupload').fileupload('option', 'url'),
                // Enable image resizing, except for Android and Opera,
                // which actually support image resizing, but fail to
                // send Blob objects via XHR requests:
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                maxFileSize: 30000000,
                acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
            });
            
            
            
            
            
            
            // FILE UPLOAD LOGO
            // ===========================================================================
            $('.fileupload_logo input[type=file]').closest('div')
            	.append("<br /><span class='help-block'><small>Max filesize: 56KB, Recommended image dimensions: 50x50 pixels</small></span>")
            $('.fileupload_logo').fileupload({
            	autoUpload: true,
                url: '/upload/php/',
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                acceptFileTypes: /^image\/(gif|jpe?g|png)$/i,
                maxFileSize: 56000,
                formData: {validate_min_width: 50, validate_min_height: 50, validate_accept_file_types: '/\.(gif|jpe?g|png)$/i'}
            });
            
           // Enable iframe cross-domain access via redirect option:
            $('.fileupload_logo').fileupload(
                'option',
                'redirect',
                window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                )
            );
            
            $('.fileupload_logo').bind('fileuploadcompleted', function(e, data) {            	
            	var file = data.result.files[0];
            	var id = file.id;
            	var field_name = $('input[name=field_name]', this).val();
            	$("#" + field_name).val(id);
            });
            
            
            // FILE UPLOAD PROFILE PICTURE
            // ===========================================================================
            $('.fileupload_profile_picture input[type=file]').closest('div')
            	.append("<br /><span class='help-block'><small>Max filesize: 256KB, Recommended image dimensions: 700x370 pixels</small></span>")
            $('.fileupload_profile_picture').fileupload({
            	autoUpload: true,
                url: '/upload/php/',
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                acceptFileTypes: /^image\/(gif|jpe?g|png)$/i,
                maxFileSize: 256000,
                formData: {validate_min_width: 700, validate_min_height: 370, validate_accept_file_types: '/\.(gif|jpe?g|png)$/i'}
            });
            
           // Enable iframe cross-domain access via redirect option:
            $('.fileupload_profile_picture').fileupload(
                'option',
                'redirect',
                window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                )
            );
            
            $('.fileupload_profile_picture').bind('fileuploadcompleted', function(e, data) {            	
            	var file = data.result.files[0];
            	var id = file.id;
            	var field_name = $('input[name=field_name]', this).val();
            	$("#" + field_name).val(id);
            });
            
            
            
            // FILE UPLOAD PROFILE HEADER IMAGE
            // ===========================================================================
            $('.fileupload_profile_header_image input[type=file]').closest('div')
            	.append("<br /><span class='help-block'><small>Max filesize: 512KB, Recommended image dimensions: 1900x418 pixels</small></span>")
            $('.fileupload_profile_header_image').fileupload({
            	autoUpload: true,
                url: '/upload/php/',
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                acceptFileTypes: /^image\/(gif|jpe?g|png)$/i,
                maxFileSize: 512000,
                formData: {validate_min_width: 1900, validate_min_height: 418, validate_accept_file_types: '/\.(gif|jpe?g|png)$/i'}
            });
            
           // Enable iframe cross-domain access via redirect option:
            $('.fileupload_profile_header_image').fileupload(
                'option',
                'redirect',
                window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                )
            );
            
            $('.fileupload_profile_header_image').bind('fileuploadcompleted', function(e, data) {            	
            	var file = data.result.files[0];
            	var id = file.id;
            	var field_name = $('input[name=field_name]', this).val();
            	$("#" + field_name).val(id);
            });
            
            
            
            // FILE UPLOAD LIGHTBOX IMAGE
            // ===========================================================================
            $('.fileupload_lightbox_image input[type=file]').closest('div')
            	.append("<br /><span class='help-block'><small>Max filesize: 256KB, Recommended image dimensions: 300x300 pixels</small></span>")
            $('.fileupload_lightbox_image').fileupload({
            	autoUpload: true,
                url: '/upload/php/',
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                acceptFileTypes: /^image\/(gif|jpe?g|png)$/i,
                maxFileSize: 256000,
                formData: {validate_min_width: 300, validate_min_height: 300, validate_accept_file_types: '/\.(gif|jpe?g|png)$/i'}
            });
            
           // Enable iframe cross-domain access via redirect option:
            $('.fileupload_lightbox_image').fileupload(
                'option',
                'redirect',
                window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                )
            );
            
            $('.fileupload_lightbox_image').bind('fileuploadcompleted', function(e, data) {            	
            	var file = data.result.files[0];
            	var id = file.id;
            	var field_name = $('input[name=field_name]', this).val();
            	$("#" + field_name).val(id);
            });
            
            
            
            
            // FILE UPLOAD MAIN FORM DOCUMENT ATTACHMENT
            // ===========================================================================
            //$('.fileupload_docs input[type=file]').closest('div')
            //	.append("<br /><span class='help-block'><small>Max filesize: 256KB, Recommended image dimensions: 300x300 pixels</small></span>")
            $('.fileupload_docs').fileupload({
            	autoUpload: true,
                url: '/upload/php/',
                disableImageResize: /Android(?!.*Chrome)|Opera/
                    .test(window.navigator.userAgent),
                acceptFileTypes: /(\.|\/)(pdf|doc|doc?|zip|gif|jpe?g|png)$/i,
                maxFileSize: 30000000
            });
            
           // Enable iframe cross-domain access via redirect option:
            $('.fileupload_docs').fileupload(
                'option',
                'redirect',
                window.location.href.replace(
                    /\/[^\/]*$/,
                    '/cors/result.html?%s'
                )
            );
            
            $('.fileupload_docs').bind('fileuploadcompleted', function(e, data) {            	
            	var file = data.result.files[0];
            	var id = file.id;
            	var field_name = $('input[name=field_name]', this).val();
            	$("#" + field_name).val(id);
            	
            	var attachment_text = $('input[name=attachment_text]').val();
            	if (attachment_text.length > 0)
            		$('.template-download .name a', this).text(attachment_text);
            });
            
            
            $('.fileupload-buttonbar input[name=attachment_text]').keyup(function() {
            	var val = $(this).val();
            	if ($('.fileupload_docs .template-download .name a').length > 0) {
            		$('.fileupload_docs .template-download .name a').text(val);
            	}
            });
            
            
            
            
            
            

                // Upload server status check for browsers with CORS support:
            /*if ($.support.cors) {
                $.ajax({
                    url: '/upload/php/',
                    type: 'HEAD'
                }).fail(function () {
                    $('<div class="alert alert-danger"/>')
                        .text('Upload server currently unavailable - ' +
                                new Date())
                        .appendTo('.fileupload');
                });
            }*/
            
            ////////////////////

            // Initialize the jQuery File Upload widget:
            /*$('.fileupload').fileupload({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                autoUpload: true,
                url: '/upload/php/'
            });*/
                        
            /*$('.fileupload').bind('fileuploaddone', function(e, data) {
            	console.log(JSON.stringify(data.responseJSON));
            	$.each(data.files, function (index, file) {
                    //console.log('Added file: ' + file.name + ' ' + file.field_name + ' ' + file.id);
            		console.log(JSON.stringify(file));
                });
            });*/
            

            // initialize uniform checkboxes  
            //App.initUniform('.fileupload-toggle-checkbox');
        }

    };

}();
