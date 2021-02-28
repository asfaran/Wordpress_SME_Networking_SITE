<?php
/*
 Template Name: Private Individual Page
*/
define('PRIVATE_SUBMENU', true, true);

$company_id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$res_id = filter_input(INPUT_GET, 'res_id', FILTER_VALIDATE_INT, array('options' => array('default' => 0)));
$pst_id = filter_input(INPUT_GET, 'pst_id', FILTER_VALIDATE_INT, array('options' => array('default' => 0)));
if (!$company_id)
{
    BP_FlashMessage::Add('Invalid parameter', BP_FlashMessage::ERROR);
    wp_redirect(site_url('dashboard'));
}

$current_company_id = biz_portal_get_current_company_id();

$BP_Company = biz_portal_get_company($company_id);
if (!$BP_Company || $BP_Company->active == 0) {
    wp_redirect(site_url('404.html'));
    exit();
}

$BP_Company_Full = biz_portal_load_company_relations($BP_Company);
$BP_CompanyProfile = biz_portal_get_company_profile($company_id);

$country_list = biz_portal_get_country_list();
if ($BP_Company_Full->country_of_incorporate > 0) {
    $country = biz_portal_select_country($BP_Company_Full->country_of_incorporate,$country_list);
}
else {
    $country = new BP_Country();
}

$NEED_INVEST = NULL;

foreach ($BP_Company_Full->biz_need_details as $key => $value)
{
    switch ($value->biz_need_type_id) {
        case BP_BizNeedType::NEED_INVEST :
            $NEED_INVEST = $value;
            break;
    }
}


biz_portal_add_visit(BP_VisitPageType::COMPANY, $company_id);

$vm_latest_downloads = biz_portal_node_get_list(BP_Node::NODE_TYPE_DOWNLOAD, 0, '', '', $BP_Company->id, 3);
//error_log(print_r($vm_lates_downloads, true));
$vm_latest_resources =  biz_portal_node_get_list(BP_Node::NODE_TYPE_RESOURCE, 0, '', '', $BP_Company->id, 3);

$logo_url = '';
if (isset($BP_CompanyProfile->logo_id)) {
    $logo_url = biz_portal_get_file_url($BP_CompanyProfile->logo_id, 0, 0, 0);    
}
$squre_image_url = '';
if (isset($BP_CompanyProfile->squre_image_id) && $BP_CompanyProfile->squre_image_id > 0) {
    $squre_image_url = biz_portal_get_file_url($BP_CompanyProfile->squre_image_id, 0, 0, 0) . '&w=450&h=400'; 
}
else {
    $squre_image_url = get_template_directory_uri() . '/images/company_default.jpg';
}


get_header();
?>
<style>
.bg_individual_squre {
    background-image:url(<?php echo $squre_image_url; ?>);
    background-size:   cover;                      /* <------ */
    background-repeat: no-repeat;
    background-position: center center; 
}
</style>
<!-- BEGIN PAGE CONTAINER -->
<div class="page-container page-body"
	style="margin-top: 115px;">

	<div class="fullwidthbanner-container"
		style="background-color: #f7f7f7">
		<div class="container">
			<div class="col-md-6 col-md-offset-6">
			    <div style="width:450;height:370px;" class="bg_individual_squre">
			            <?php if ($current_company_id == $company_id) : ?>
                        <span class="camera_class" style="float:right;" id="camera_profile" ><i class="fa fa-camera" id="black_camera"></i></span>
                		<?php endif; ?>
			<?php if (!empty($squre_image_url)) :?>
				<!-- <img
					src="<?php echo $squre_image_url . '&w=450&h=400'; ?>"
					class="img-responsive"> -->
			<?php endif; ?>
            		
			    </div>
                
			</div>
			<div class="sme_individual_white">
				<div style="display: block;">
					<div class="sme_individual_top">
						<div class="icon_item">
							<a href="#" id="link_add_favourite"><i class="fa fa-star-o"></i>Favorites</a>
						</div>
						<div class="icon_item">
							<a href="#" data-toggle="modal" data-target="#modal_message_window"><i class="fa fa-envelope-o"></i>Messages</a>
						</div>
					</div>
					<div class="sme_individual_body">
						<div class="sme_individual_header">
                        		
						<?php $long_company_name = false;?>
						<?php if (!empty($logo_url)) :?>
							<img
								src="<?php echo $logo_url . '&w=300&h=50'; ?>">
								<?php if ($current_company_id == $company_id) : ?>
                                <small>
                                <span class="camera_class" id="camera_logo" style="padding:3px;" ><i class="fa fa-camera" id="black_camera_logo"></i></span>
                                </small>
                                <?php endif; ?>
						<?php else : ?>
						    
                            <h3>
								<?php echo $BP_Company_Full->company_name;  ?>
								<?php if (strlen($BP_Company_Full->company_name) > 36) :?>
								<?php $long_company_name = true; ?>
								<?php endif;?>
								<?php if ($current_company_id == $company_id) : ?>
                                <small>
                                <span class="camera_class" id="camera_logo" style="padding:3px;" ><i class="fa fa-camera" id="black_camera_logo"></i></span>
                                </small>
                                <?php endif; ?>
							</h3>
                            
						<?php endif; ?>
						</div>
						<div class="clearfix"></div>
						<div class="sme_individual_content" style="height: <?php echo $val = $long_company_name ? '150px;margin-top:30px' : '170px'?>;overflow:hidden;">
							<p>
								<?php echo esc_attr(nl2br($BP_Company_Full->summary));  ?>
							</p>
						</div>
						<!-- sme_individual_content -->
					</div>
					<!-- sme_individual_body -->

				</div>
				<div
					style="position: absolute; clear: both; bottom: 0; text-align: center; width: 100%;"
					id="about_company">
					<?php /*?><a href="#about_company" class="btn btn-warning"><i
						class="fa fa-chevron-down"></i> </a> */ ?>
				</div>
			</div>
			<!-- sme_individual_white -->
			<div class="clearfix"></div>
		</div>
	</div>
	<!-- fullwidthbanner-container -->


	<div class="clearfix">&nbsp;</div>


	<div class="row" style="background-color: #fff; position: relative;">
		<div class="col-md-12">
			<!-- BEGIN CONTAINER -->
			<div class="container margin-bottom-30">
				<!-- BEGIN SERVICE BOX -->

				<div class="row">
					<div class="col-md-8 col-sm-8 " style="text-align: justify">
						<div style="text-align: left; text-transform: uppercase;">
							<h3 class="header_title_2">
								About
								<?php echo $BP_Company_Full->company_name;  ?>
							</h3>
						</div>
						<div class="about_parag_left">
						<?php /*?> 
							<p>
								<?php
								if (!empty($BP_CompanyProfile->body))  
								    echo esc_attr(nl2br($BP_CompanyProfile->body));
								else
								    echo 'n/a';  
								?>
							</p>*/?>

							<h5>
								<strong>Looking for:</strong>
							</h5>
							<p>
								<?php
								/*if(!is_null($NEED_INVEST)){
								    echo nl2br($NEED_INVEST->detail);
								}*/
								//if (!empty($BP_CompanyProfile->body_looking_for))
								//    echo esc_attr(nl2br($BP_CompanyProfile->body_looking_for));
								//else
								//    echo 'n/a';
								
								$found = false;
								foreach ($BP_Company_Full->biz_need_details as $details)
								{
								    if ($details instanceof BP_BizNeedDetail) {
								        if (!empty($details->detail)) {
    								        echo $details->detail;
    								        if ($found)
    								            echo '<hr />';
    								        $found = true;
								        }
								    }
								}
								
								if (!$found)
								    echo 'n/a';
								?>
							</p>

						</div>

					</div>
					<!-- col-md-8 col-sm-8 -->
					<div class="col-md-4 col-sm-4">
						<div class="individual_sidebar">
						<div style="text-align: left; text-transform: uppercase;">
							<h3 class="header_title_2">Fast Facts</h3>
						</div>
						<div class="fast_facts_items">
							Country of Incorporation:
							<div class="fast_facts_items_answer">
								<?php echo $country['country_name'];  ?>
							</div>
						</div>
						<div class="fast_facts_items">
							Year of Incorporation:
							<div class="fast_facts_items_answer">
								<?php echo $BP_Company_Full->year_of_incorporate;  ?>
							</div>
						</div>
						<div class="fast_facts_items">
							Type of Business:
							<div class="fast_facts_items_answer">
								<?php if (is_array($BP_Company_Full->biz_types)) :  ?>
								<?php 
								foreach($BP_Company_Full->biz_types as $key => $value) :
								echo $value->type_text . "<br>";
								endforeach;
								?>
								<?php endif ?>
							</div>
						</div>
						<div class="fast_facts_items">
							Industry:
							<div class="fast_facts_items_answer">
								<?php if (is_array($BP_Company_Full->industries)) :  ?>
								<?php 
								foreach($BP_Company_Full->industries as $key => $value) :
								echo $value->ind_name . "<br>";
								endforeach;
								?>
								<?php endif ?>
							</div>
						</div>

						<div class="fast_facts_items">
							Annual Turnover:
							<div class="fast_facts_items_answer">
								US $
								<?php echo $BP_Company_Full->turnover_min;  ?>
								-
								<?php echo $BP_Company_Full->turnover_max;  ?>
							</div>
						</div>
						<div class="fast_facts_items">
							Number of Employees:
							<div class="fast_facts_items_answer">
								<?php echo $BP_Company_Full->num_employee_min;  ?>
								-
								<?php echo $BP_Company_Full->num_employee_max;  ?>
							</div>
						</div>


						<div class="clearfix devider_style_i">
							<div>&nbsp;</div>
						</div>

						<div style="text-align: left; text-transform: uppercase;">
							<h3 class="header_title_2">Contact Details</h3>
						</div>

						<div class="fast_facts_items">
							<a href="#" data-toggle="modal" data-target="#modal_message_window" class="btn btn-warning">Send Message</a>
						</div>

						<div class="fast_facts_items">
							<h5 style="font-weight: bold">
								<?php echo $BP_Company_Full->company_name;  ?>
							</h5>
							<address>
								<?php //print_r($BP_Company_Full->addresses) ?>
								<br />
								<?php if (is_array($BP_Company_Full->addresses)) : ?>
								<?php foreach ($BP_Company_Full->addresses as $key => $value) : ?>
								<?php if ($key > 0) : ?>
								<?php echo (isset($value->address_number)) ? $value->address_number . '  ,' : "";  ?>
								<?php echo $value->street;  ?>
								<br>
								<?php echo $value->city;  ?>
								<br>
								<?php echo $value->postal_code;  ?>

								<?php 
								$country = biz_portal_select_country($value->country_id,$country_list);
										echo $country['country_name'];  ?>
								<?php break; ?>
								<?php endif; ?>
								<?php endforeach; ?>
								<?php endif; ?>
							</address>
						</div>

						</div>
					</div>
					<!-- col-md-4 col-sm-4 -->

				</div>
				<!-- END SERVICE BOX -->


			</div>

			<div class="clearfix"></div>

		</div>
		<!-- END CONTAINER -->
	</div>
</div>
<!-- row  -->

<div class="clearfix"></div>

<div class="row margin-bottom-40">
	<div class="container downloadable_docs">
		<div style="text-align:center; width:100%; ">
        <hr style="color:#ccc 1px solid;" />
        </div>
		<div class="col-md-6 ">
			<div style="margin-top:40px">
            	<h5>Downloadable Documents</h5>
            </div>
            <div class="about_parag_left downloadable_border_right join_community" style="">
			<?php 
			$html = '';
			$summary = NULL;
			foreach ($vm_latest_downloads->nodes as $node) {
			   $html .= '<li class="dotted-bottom-grey"><a href="#" data-toggle="modal" data-target="#downloadable_window" data-type="' . BP_Node::NODE_TYPE_DOWNLOAD . '" class="dialog_nodes" rel="' . $node->id . '">' . $node->title . '</a></li>';
			   if (is_null($summary)) { 
			       $summary = '';
			       if (preg_match('/^.{1,160}\b/s', $node->body, $match))
			       {
			           $summary=$match[0] . ' ..';
			       }
			   }
			} ?>
			<p><?php 
                $edit_class = ''; $edit_location='';
                if (current_user_can('edit_post')) {
                    $edit_class = 'admin_udpate_spot';
                    $edit_location = 'options';
                }
                ?>
                &nbsp;<br />
                <span data-location="<?php echo $edit_location; ?>" data-id="content_download_introtext" class="<?php echo $edit_class; ?>">
                <?php echo get_option('content_download_introtext', 'content_download_introtext') ?></span>
			    <?php /*“This section includes / may include corporate documentation made available by the 	company. Companies are not required to upload any if they prefer not to do so” */ ?>
			</p>
			<ul class="list-unstyled">
			<?php echo $html; ?>
			</ul>
			<?php if (count($vm_latest_downloads->nodes) > 0) :?>
			<p>
				<a href="#" data-toggle="modal" data-target="#downloadable_window"
					id="view_company">View All</a>
			</p>
			<?php endif; ?>
            </div>
		</div>
		<!-- col-md-6 col-sm-6 -->

		<div class="col-md-6 padding-left-30" >
			<div style="margin-top:40px; ">
            	<h5>Resources Provided</h5>
            </div>
			<div class="about_parag_left"  >
			<?php 
			$html = '';
			$summary = NULL;
			foreach ($vm_latest_resources->nodes as $node) {
			   $html .= '<li class="dotted-bottom-grey"><a href="#" data-toggle="modal" data-target="#downloadable_window" data-type="' . BP_Node::NODE_TYPE_RESOURCE . '" class="dialog_nodes" rel = "' . $node->id . '">' . $node->title . '</a></li>';
			   if (is_null($summary)) { 
			       $summary = '';
			       if (preg_match('/^.{1,160}\b/s', $node->body, $match))
			       {
			           $summary=$match[0] . ' ..';
			       }
			   }
			} ?>
			<p>
			    <?php 
                $edit_class = ''; $edit_location='';
                if (current_user_can('edit_post')) {
                    $edit_class = 'admin_udpate_spot';
                    $edit_location = 'options';
                }
                ?>
                &nbsp;<br />
                <span data-location="<?php echo $edit_location; ?>" data-id="content_resource_introtext" class="<?php echo $edit_class; ?>">
                <?php echo get_option('content_resource_introtext', 'content_resource_introtext') ?></span>
			    <?php /*“This section includes voluntary resources contributions from this company which are shared with the community. Companies are not required to upload any if they prefer not to do so”*/?>
			</p>
			<ul class="list-unstyled">
				<?php echo $html; ?>
			</ul>
			<?php if (count($vm_latest_resources->nodes) > 0) :?>
			<p>
				<a href="#" data-toggle="modal" data-target="#downloadable_window"
					id="view_resources">View All</a>
			</p>			
			<?php endif; ?>
            </div>
		</div>
		<!-- col-md-6 col-sm-6 -->


	</div>
</div>

<div class="clearfix"></div>
<!--  FAQ   -->

<?php
$vm_posts = biz_portal_node_get_list(BP_Node::NODE_TYPE_POST, 0, '', '', $BP_Company->id, 9, 0);
$posts = $vm_posts->nodes;
?>

<div id="myCarousel" style="<?php echo count($posts) == 0 ? 'height:370px;':''; ?>"
	class="fixed-height ">
	<!-- BEGIN CAROUSEL -->
	<div class="front-carousel ">
		<div class="header_title">
			<h3>Company Latest Posts</h3>
		</div>
		<div class="container faq_body">

			<div class="carousel slide ">
				<!-- Carousel items -->
				<div class="carousel-inner">
				<?php if (count($posts) == 0) :?>
				    <div style="text-align:center">No posts</div>
				<?php endif; ?>
				
				<?php $i=1;?>
				<?php $div_opened = false; ?>
				<?php $div_closed = false; ?>
				
				<?php foreach ($posts as $node) : ?>
				<?php if ($i%3 == 1) : ?>
				    <div class="item <?php echo $i == 1 ? 'active' : ''; ?>">
				    <?php $div_opened = true; $div_closed = false; ?>
				<?php endif;?>
				    <?php
				    $line=$node->body;
				    if (preg_match('/^.{1,260}\b/s', $node->body, $match))
				    {
				        $line=$match[0];
				    }
				    ?>
				    <div class="col-md-4 col-sm-4 company_posts">
						<a href="#" data-toggle="modal" data-target="#downloadable_window" class="box shadow-radial lates_posts" rel="<?php echo $node->id; ?>"><?php echo esc_attr($line); ?> </a>
					</div>
				
				<?php if ($i%3 == 0) : ?>
				    </div>
				    <?php $div_opened = false; $div_closed = true; ?>
				<?php endif;?>
				<?php $i++; ?>				
				<?php endforeach; ?>
				<?php if ($div_opened && !$div_closed) : ?>
				    </div>
				<?php endif; ?>
				</div>
			</div>
		</div>
		<div class="text_down">
		<?php if (count($posts) > 0) :?>		
			<a href="#" data-toggle="modal" data-target="#downloadable_window"
				id="view_posts">View All Posts 
			</a>
		<?php endif; ?>
		</div>
	</div>
	<!-- END CAROUSEL -->
</div>


<!--  FAQ   -->

<div class="clearfix"></div>



</div>
<!-- END PAGE CONTAINER -->

<script>
    var is_favourited = false;
    var resource_selected = <?php echo is_numeric($res_id) ? $res_id : 0; ?>;
    var post_main_selected = <?php echo is_numeric($pst_id) ? $pst_id : 0; ?>;
    var hash = window.location.hash;
    var show_all_resources = hash.indexOf('resources');
    var show_all_posts = hash.indexOf('posts');
    var show_all_downlaods = hash.indexOf('downlaods');
    
    function initialize_company_view()
    {	
        var current_company_id = "<?php echo biz_portal_get_current_company_id(); ?>";
        var viewing_company_id = "<?php echo $company_id; ?>";       

        $('.dialog_nodes').click(function() {
            var selected_download = 0;
            var data_type = $(this).attr('data-type');
            $("#list_items").html("");
            if (data_type === '<?php echo BP_Node::NODE_TYPE_DOWNLOAD ?>')
                $("#dialog_title").text("Downloads");
            else if (data_type === '<?php echo BP_Node::NODE_TYPE_RESOURCE ?>')
            	$("#dialog_title").text("Downloadable Resources");
        	var selected = $(this).attr('rel');
        	if (selected > 0)
        		selected_download = selected;       	

        	$.ajax({
				type: "POST",
				url: "<?php echo get_site_url('','ajax', 'relative'); ?>/",
				data: {mode:'NODES_LIST', type:data_type, cat:0, option_id:selected_download, company_id:viewing_company_id},
				success: function(data){
					$("#list_items").html(data.html);
									
					if (selected_download > 0) {
    					setTimeout(function(){
    						$("#scroller_window").scrollTop(0);
        					var scroller_window_top = $("#scroller_window").offset().top;
        					var scroll_length = $("li#list_" + selected_download).offset().top;
        					scroll_length  = scroll_length - scroller_window_top;
        					$("#scroller_window").animate({scrollTop:scroll_length}, 'slow');
        					selected_download = 0;	
        					//console.log($("#scroller_window").scrollTop());
    					}, 1500);
					}
				}
			});	
        }); 
        
    	$("#view_posts").click(function(){
    		$("#dialog_title").text("Company Posts");
			$.ajax({
				type: "POST",
				url: "<?php echo get_site_url('','ajax', 'relative'); ?>/",
				data: {mode:'NODES_LIST', type:'<?php echo BP_Node::NODE_TYPE_POST ?>', cat:0, option_id:post_main_selected,company_id:viewing_company_id},
				success: function(data){
					$("#list_items").html(data.html);
					if (post_main_selected > 0) {
						setTimeout(function(){
    						$("#scroller_window").scrollTop(0);
    						var scroller_window_top = $("#scroller_window").offset().top;
        					var scroll_length = $("li#list_" + post_main_selected).offset().top;
        					scroll_length = scroll_length - scroller_window_top;
        					$("#scroller_window").animate({scrollTop:scroll_length}, 'slow');
        					post_main_selected = 0;
    					}, 1500);
					}
				}
			});			
		});

		$('.lates_posts').click(function(e) {
			e.preventDefault();
			$("#dialog_title").text("Company Posts");
			var post_selected = $(this).attr('rel');
			if (!post_selected > 0) post_selected = 0;
			$.ajax({
				type: "POST",
				url: "<?php echo get_site_url('','ajax', 'relative'); ?>/",
				data: {mode:'NODES_LIST', type:'<?php echo BP_Node::NODE_TYPE_POST ?>', cat:0, option_id:post_selected, company_id:viewing_company_id},
				success: function(data){
					$("#list_items").html(data.html);
					if (post_selected > 0) {
    					setTimeout(function(){
    						$("#scroller_window").scrollTop(0);
    						var scroller_window_top = $("#scroller_window").offset().top;
        					var scroll_length = $("li#list_" + post_selected).offset().top;
        					scroll_length = scroll_length - scroller_window_top;
        					$("#scroller_window").animate({scrollTop:scroll_length}, 'slow');
        					post_selected = 0;
    					}, 1500);
					}
				}
			});	
		});

		// Resource provided [View All]
		$("#view_resources").click(function(){
			$("#dialog_title").text("Downloadable Resources");
			$.ajax({
				type: "POST",
				url: "<?php echo get_site_url('','ajax', 'relative'); ?>/",
				data: {mode:'NODES_LIST', type:'<?php echo BP_Node::NODE_TYPE_RESOURCE ?>', cat:0, option_id:resource_selected, company_id:viewing_company_id},
				success: function(data){
					$("#list_items").html(data.html);
					if (resource_selected > 0) {
    					setTimeout(function(){
    						$("#scroller_window").scrollTop(0);
    						var scroller_window_top = $("#scroller_window").offset().top;
        					var scroll_length = $("li#list_" + resource_selected).offset().top;
        					scroll_length = scroll_length - scroller_window_top;
        					$("#scroller_window").animate({scrollTop:scroll_length}, 'slow');
        					resource_selected = 0;
    					}, 1500);
					}
				}
			});	
		});		
		
		$("#view_company").click(function(){
			$("#dialog_title").text("Company Documents");
			$.ajax({
				type: "POST",
				url: "<?php echo get_site_url('','ajax', 'relative'); ?>/",
				data: {mode:'NODES_LIST', type:'<?php echo BP_Node::NODE_TYPE_DOWNLOAD ?>', cat:0, option_id:resource_selected,company_id:viewing_company_id},
				success: function(data){
					$("#list_items").html(data.html);
				}
			});		
		});

		$("#link_add_favourite").click(function(e) {
			e.preventDefault();
			if (!is_favourited)
			    company_view_add_favourite(current_company_id, viewing_company_id);
			else
				company_view_remove_favourite(current_company_id, viewing_company_id);
		});

		$("#send_message").click(function(e) {
			e.preventDefault();
			_company_view_send_message(current_company_id, viewing_company_id);
		});

		if (resource_selected > 0) {
			$("#view_resources").trigger("click");
		}
		if (post_main_selected > 0) {
			$("#view_posts").trigger('click');
		}
		else if (show_all_posts > 0) {
			$("#view_posts").trigger('click');
		}
		else if (show_all_resources > 0) {
			$("#view_resources").trigger('click');
		}
		else if (show_all_downlaods > 0) {
			$("#view_company").trigger('click');
		}

		if (current_company_id > 0 && viewing_company_id >0)
		{
    		$.ajax({
    			type:"POST",
    			url:"<?php echo get_site_url('','ajax', 'relative'); ?>/",
    			dataType:'json',
    			data:{mode:'CHECK_FAVOURITE',s_cid:current_company_id, t_cid:viewing_company_id },
    			success: function(data){
    					if (data.hasOwnProperty('done') && data.done === true) {
    						if (data.hasOwnProperty('found') && data.found === true) {
    							is_favourited = true;
    							$("#link_add_favourite i").removeClass("fa-star-o");
    							$("#link_add_favourite i").addClass("fa-star");
    						}
    					}
    			}
    	  });
		}
    }

    function company_view_add_favourite(current_company_id, viewing_company_id)
    {
    	if (current_company_id == 0 || viewing_company_id == 0)
            return;
        
    	_company_view_favourite_style_set(true);
        $.ajax({
				type:"POST",
				url:"<?php echo get_site_url('','ajax', 'relative'); ?>/",
				dataType:'json',
				data:{mode:'ADD_FAVOURITE',s_cid:current_company_id, t_cid:viewing_company_id },
				success: function(data){
					if (data.hasOwnProperty('done') && data.done === true) {
						if (data.hasOwnProperty('success') && data.success === true) {
							is_favourited = true;
						}
					}
					_company_view_favourite_style_set(is_favourited);
				}
		  });
    }

    function company_view_remove_favourite(current_company_id, viewing_company_id)
    {
    	if (current_company_id == 0 || viewing_company_id == 0)
            return;
        
    	_company_view_favourite_style_set(false);
    	$.ajax({
			type:"POST",
			url:"<?php echo get_site_url('','ajax', 'relative'); ?>/",
			dataType:'json',
			data:{mode:'REMOVE_FAVOURITE',s_cid:current_company_id, t_cid:viewing_company_id },
			success: function(data){
				if (data.hasOwnProperty('done') && data.done === true) {
					if (data.hasOwnProperty('success') && data.success === true) {
						is_favourited = false;
					}
				}
				_company_view_favourite_style_set(is_favourited);
			}
	  });
    }

    function _company_view_favourite_style_set(favourited) 
    {
        if (favourited) {
        	$("#link_add_favourite i").removeClass("fa-star-o");
    		$("#link_add_favourite i").addClass("fa-star");
        }
        else {
        	$("#link_add_favourite i").removeClass("fa-star");
    		$("#link_add_favourite i").addClass("fa-star-o");
        }
    }

    function _company_view_send_message(current_company_id, viewing_company_id)
    {        
        if (current_company_id == 0 || viewing_company_id == 0)
            return; 
        
        var sent = false;
        $('.alert').addClass('hidden');        
        var message_text = $("#message_text").val();

        if (current_company_id == viewing_company_id) {
        	$('.alert-danger').html('<i class="fa fa-warning"></i> Sorry! You can not message yourself');
			$('.alert-danger').removeClass('hidden');
			return false;
        }
        
        if (message_text.length > 5) {
        	$('.loading').removeClass('hidden');
        	$("#send_message").prop('disabled', true);
        	$.ajax({
            	type: "POST",
            	url:"<?php echo get_site_url('','ajax', 'relative'); ?>/",
    			dataType:'json',
    			data:{mode:'SEND_MESSAGE',s_cid:current_company_id, t_cid:viewing_company_id, message: message_text},
    			success: function(data){
    				if (data.hasOwnProperty('done') && data.done === true) {
    					if (data.hasOwnProperty('success') && data.success === true) {
    						$('.alert-success').html('<i class="fa fa-check"></i> Your message was sent');
    						$('.alert-success').removeClass('hidden');
    						$("#send_message").prop('disabled', true);
    						sent = true;
    					}
    					else {
    						$('.alert-danger').html('<i class="fa fa-warning"></i> There was a problem sending your message');
    						$('.alert-danger').removeClass('hidden');
    					}
    				}
    				else {
    					$('.alert-danger').html('<i class="fa fa-warning"></i> There was a problem sending your message');
						$('.alert-danger').removeClass('hidden');
    				}
    				$('.loading').addClass('hidden');
    			},
    			complete : function() {
        			if (!sent)
        			    $("#send_message").prop('disabled', false);
    			}
            });
        }
        else {
            $('.alert-danger').html('Message text is too small');
            $('.alert-danger').removeClass('hidden');
        }
    }
	
	
			$('#camera_profile').hover(function(){
				
				$(this).addClass('update_block_logo');
				$(this).prepend('<a href="<?php echo site_url('dashboard/profile/details') ?>"><span style="color:#fff; font-size:13px">Update Profile <i class="fa fa-camera"></i></span> </a>');
				$('#black_camera').hide();
			}, function(){
				
				$(this).removeClass('update_block_logo');
				$( this ).find( "a:last" ).remove();
				$('#black_camera').show();
			});
			
			
			$('#camera_logo').hover(function(){
				
				$(this).addClass('update_block_logo');
				$(this).append('<a href="<?php echo site_url('dashboard/profile/details') ?>"> <span style="color:#fff; font-size:13px"><i class="fa fa-camera"></i>  Update Logo</span> </a>');
				$('#black_camera_logo').hide();
			}, function(){
				
				$(this).removeClass('update_block_logo');
				$( this ).find( "a:last" ).remove();
				$('#black_camera_logo').show();
			});
	
	
    </script>

<?php 
Theme_Vars::add_script_ready('initialize_company_view();');
?>

<div class="modal fade" id="modal_message_window" role="dialog" aria-labelledby="Message" aria-hidden="true">
    <div class="modal-dialog">
		<div class="modal-content">
		    <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Message To : <strong><?php echo $BP_Company_Full->company_name; ?></strong></h4>
            </div>
            <div class="modal-body">
                <div class="loading hidden progress progress-striped active">
					<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
					    <span class="sr-only">sending message...</span>
				    </div>
				</div>
                <div class="alert alert-success hidden"></div>
				<div class="alert alert-danger hidden"></div>
                <p>
                <textarea id="message_text" class="form-control" rows="5" placeholder="Your message here.."></textarea>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="send_message" class="btn btn-primary">Send <i class="fa fa-arrow-circle-right"> </i></button>
            </div>
		</div>
	</div>
</div>

<?php get_footer(); ?>

<!-- END PAGE LEVEL JAVASCRIPTS -->


<!-- Modal (Advertise With Us) -->
<div class="modal fade"
	id="downloadable_window" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" id="modal_header">
        		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4><?php echo $BP_Company_Full->company_name; ?></h4>
      		</div>
			<div class="row">
				<div class="col-md-4">
				<?php 
				$lightbox_img_url = '';
				$logo_image_url = '';
		        $lightbox_img_url = biz_portal_get_file_url($BP_CompanyProfile->lightbox_image_id, 0, 0, 1);

			    if ($BP_CompanyProfile->logo_id > 0) {
			        $logo_image_url = biz_portal_get_file_url($BP_CompanyProfile->logo_id, 0, 0, 1);
			    }
				?>
					<img
						src="<?php echo $lightbox_img_url; ?>&w=290&h=390"
						class="img-responsive">
					<div style="padding: 10px 0 0 15px;">
						<h5 style="font-weight: bold"><?php echo $BP_Company_Full->company_name; ?></h5>
						<?php foreach ($BP_Company_Full->addresses as $address) : ?>
						<p style="line-height: normal">
							<?php echo $address->company_number; ?><br> <?php echo $address->street . ", " . $address->city; ?>,<br> 
							<?php echo $address->postal_code ?> <?php echo $country['country_name']; ?>
						</p>
						<?php endforeach; ?>
						<p style="line-height: normal">
							<a href="<?php echo site_url('dashboard/view-company') . '?id=' . $BP_Company->id ?>"><i class="fa fa-folder-open"></i> View Page</a> <br>
							<!-- a href="#"><i class="fa fa-envelope-o"></i> Send Message</a -->
						</p>
					</div>
				</div>
				<div class="col-md-8">
					<div class="row">
						<div class="text-center margin-top-20 margin-bottom-30">
						    <?php if (!empty($logo_image_url) && $BP_CompanyProfile->logo_id > 0) :?>
							<img
								src="<?php echo $logo_image_url; ?>&w=300&h=70" />
							<?php else :?>
							    <h2><?php echo $BP_Company->company_name; ?></h2>
							<?php endif; ?>
							<h4>
								<span id="dialog_title">Downloadable Resources</span>
							</h4>
							<div style="width: 100%; text-align: center; padding-left: 25px">
								<div style="width: 90%; border: 1px solid #ddd;"></div>
							</div>
						</div>



						<!-- uploaded resources  -->
						<div class="container">
							<div id="scroller_window" class="scroller" style="height: 300px;"
								data-always-visible="1" data-rail-visible="0">
								<div id="list_items"></div>
							</div>

						</div>
						<!-- uploaded resources  -->
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<div class="col-md-6">
					<img
						src="<?php echo get_template_directory_uri(); ?>/images/modal_logo.jpg"
						id="logoimg" alt="" class="img-responsive">
				</div>
				<div class="col-md-6">
				</div>
			</div>

		</div>
	</div>

	<!-- Modal (Advertise With Us) -->