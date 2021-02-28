<?php
/*
  Template Name: Resources Page
 */

if (!is_user_logged_in()) {
    BP_FlashMessage::Add('You should to log into view this section', BP_FlashMessage::ERROR);
    wp_redirect(home_url('signin'));
    exit();
}

define('SHOW_RESOURCES_TOPIC', true, true);
define('SUBMENU_ITEM','resources');
define('PRIVATE', true, true);

global $wpdb;
$sql = "SELECT * FROM " . _biz_portal_get_table_name('node_category');
$node_categories = $wpdb->get_results($sql);
$categories =array();
foreach ($node_categories as $cat) :
    $categories[$cat->id]=$cat->category_name;
endforeach;

$message='';
if (isset($_GET['search_form'])){
//if(isset($_GET)){
    $search_term = filter_input(INPUT_GET, 'search_term', FILTER_SANITIZE_STRING);
    
    if($search_term): 
       // $sword=$search_term;
    else:
        $message ='<span style="color:#FF0000">Please,Add Correct Search Term</span>';
        //$sword='';
    $search_term='';
    
    endif;
}

$current_page = filter_input(INPUT_GET, 'pg', FILTER_VALIDATE_INT);
$tab_cat = filter_input(INPUT_GET, 'c', FILTER_VALIDATE_INT);

if(!$tab_cat):$tab_cat=0;endif; 
if(!$search_term):$search_term='';endif;   
if(!$current_page){$current_page = 1;}

$count = 10;

$offset = ($current_page * $count) - $count;
$resource_result=biz_portal_node_get_list(BP_Node::NODE_TYPE_RESOURCE, (int)$tab_cat, $search_term, 'FULL', 0, $count, $offset);
$pages=$resource_result->total;
//$total_pages = ceil($pages/$count);


$current_user_can_edit_post = current_user_can('edit_post');




function select_data($action ,$value){
global $wpdb;
        if($action==='company_name'){

            $sql = "SELECT company_name FROM "._biz_portal_get_table_name('companies')." Where id=".$value;
            $com_name = $wpdb->get_var($sql);
            echo $com_name;

        }
		else if ($action === 'url') {
			foreach ($value as $file) {
				return biz_portal_get_file_url($file->id, 0, 1, 1);
			}
		}
		elseif($action==='attachments'){
            if(is_array($value) && count($value)){
                foreach ($value as $file) {
                        if($file->id):
                            $url = biz_portal_get_file_url($file->id, 0, 1, 1);
                            echo'<a target="_blank" href="'.$url.'">Download</a>';
                        endif;
                }
        
            }
            
        }
}

get_header();
?>


<style>
    .resources_right h2,
    .resources_right h2 a {
        text-align:left;
    }

	.top_banner_header{
		background-image:  url('<?php echo get_template_directory_uri(); ?>/images/resources_header.jpg');
	}
        
        @media (min-width: 992px) {
		.top_banner_header{
			background-image:  url('<?php echo get_template_directory_uri(); ?>/images/resources-hd.jpg');
		}
	}
	
	@media (min-width: 992px) {
		.top_banner_header{
			background-image:  url('<?php echo get_template_directory_uri(); ?>/images/resources_header.jpg');
		}
	}
	
	
	@media (max-width: 992px) {
		.top_banner_header{
			background-image:  url('<?php echo get_template_directory_uri(); ?>/images/resources_header.jpg');
		}
	}
	
	@media(max-width:767px){
		.top_banner_header{
			background-image:  url('<?php echo get_template_directory_uri(); ?>/images/resources_header.jpg');
		}
	}
</style>
		


    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body" style="font-size:13px">
        
        <div class="top_banner_header img-responsive" ></div>
        <!--<div class="row">
         <!-- BEGIN CONTAINER -->
    		
        <!-- END CONTAINER -->
        <!--</div>--> <!-- END ROW -->
        <div class="row  " >
                    	<div class="breadcrumbs breadcrumbs_dark">
                            <div class="col-md-12 col-sm-12 ">
                           
                                <div class="submenu ">
                                   <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                                    <button class="navbar-toggle btn navbar-btn" data-toggle="collapse" data-target="#submenu" onClick="$('#submenu').toggle();">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                    <ul class="submenu_list" id="submenu">
                                        <li <?php echo $all; ?>><a class="submenu_title_i">Resources</a></li>
                                    	<?php $category = filter_input(INPUT_GET,'c',FILTER_VALIDATE_INT);  ?>
                                    	<?php $all =  (!isset($category)) ? " class='active' ":"";  ?>
                                        	<li <?php echo $all; ?>><a href="/<?php echo SUBMENU_ITEM; ?>/">ALL</a></li>
                                        <?php
                                        $x = 1;
										foreach ($node_categories as $cat) :
											$active = ((isset($category)) && ($category == $x)) ? " class='active' ":"";
                                            ?>
                                        	<li <?php echo $active; ?>><a href="/<?php echo SUBMENU_ITEM; ?>/?c=<?php echo $cat->id; ?>"><?php echo $cat->category_name;?></a></li>
                                        <?php $x++; endforeach; ?>
                                    </ul>
                                </div>  
                            </div>
                        </div>
                    </div>
        <div class="clearfix"></div>
        
        <div class="row">
            <!-- BEGIN CONTAINER -->
    		    <div class="container">
                	<div class="col-md-12 text-center padding-top-40">
                    	<?php 
                            $edit_class = ''; $edit_location='';
                            if ($current_user_can_edit_post) {
                                $edit_class = 'admin_udpate_spot';
                                $edit_location = 'options';
                            }
                        ?>
                        <h3><span data-location="<?php echo $edit_location; ?>" data-id="content_resource_page_header_1" 
                        class="<?php echo $edit_class; ?>"><?php echo get_option('content_resource_page_header_1', 'header_1'); ?></span></h3>
                        <?php 
                            $edit_class = ''; $edit_location='';
                            if ($current_user_can_edit_post) {
                                $edit_class = 'admin_udpate_spot';
                                $edit_location = 'options';
                            }
                        ?>
                        <p data-location="<?php echo $edit_location; ?>" data-id="content_resource_page_description_1" 
                        class="<?php echo $edit_class; ?>"><?php echo stripslashes(get_option('content_resource_page_description_1', 'descriptions_text_1'))?></p>
                    </div>
                </div>
        	<!-- END CONTAINER -->
        </div> <!-- END ROW -->
        
        <div class="row">
        	<div class="container" style="border-bottom:#ccc 1px solid; padding:0px 0;">
            	<form action="<?php echo $_SERVER["REQUEST_URI"]; ?>" method="get" >
                	<div class="input-group input-medium pull-right">
                              <input type="text" class="form-control" style="border-bottom: 0px;" placeholder="Search" value="<?php echo $search_term;?>" id="search_term" name="search_term">
                              <input type="hidden"  value="<?php echo $tab_cat;?>" id="c" name="c">
                              <input type="hidden"   name="search_form">
                              <span class="input-group-btn">
                                  <input class="btn blue"  type="submit" value="Go"   >
                              </span>
                    </div><!-- /input-group -->
                    
                </form>
                    
                <?php echo "<center>".$message."</center>"; ?>
            </div>
        </div><!-- END ROW -->
        
        <div class="row">
        	<div class="container">
            		<div class="col-md-8">
                            <?php
                        if(count($resource_result->nodes)>0){
                          foreach ($resource_result as $resources) :
                                if(is_array($resources)){
                                    foreach ($resources as $resource) :
                                        if($resource->title){
                                            ?>
                            <div class="resources_item">
                                <h2><a href="<?php echo select_data('url', $resource->attachments) ?>"><?php echo $resource->title;?></a></h2>
                                <p>
                                    <em><?php echo date("jS F, Y", strtotime($resource->created));?></em>
                                    - <?php echo $resource->body;?></p>
                                <ul class="blog-info">
                                    <?php
                                    $company_url = '#';
                                    if ($resource->company_id > 1)
                                        $company_url = site_url('dashboard/view-company') . '?id=' . $resource->company_id;
                                     ?>
                                    <li><?php select_data('attachments',$resource->attachments,$current_page); ?></li>
                                    <li>| <a  class="resource_title" data-id="<?php echo $resource->id ?>"
                                    data-cid="<?php echo $resource->company_id; ?>" 
                                    data-toggle="modal" data-target="#resource_window" href="">View All From <?php echo select_data('company_name',$resource->company_id);?></a></li>
                                    
                                </ul>
                            </div>
                            
                            <?php 
                            
                            }endforeach;
                                        }endforeach;
                        }else{
                           ?>
                            <div class="resources_item">
                                <h4>Sorry,No Records for this category.</h4>
                            </div>
                        <?php  }?>
                            
                            
                                
                            
                    <div align="center">
                            <?php sbpssme_create_pager($_GET,$_SERVER["REQUEST_URI"], $count, $pages, 'pagination pagination-centered', 'active', 'pg'); ?>
                     </div>
                            
                    </div> <!-- col-md-8 -->
                    
                    <div class="col-md-4">
                    	
						<div class="resources_right">                        
                            <div class="text-center">
                                <h2><a href="<?php echo site_url('dashboard/list/sme') ?>">SMEs</a></h2>
                            </div> 
                            <div style="">
                            <?php 
                            $edit_class = ''; $edit_location='';
                            if ($current_user_can_edit_post) {
                                $edit_class = 'admin_udpate_spot';
                                $edit_location = 'options';
                            }
                            ?>
                                <p style="text-align:left;" >
                                <span data-location="<?php echo $edit_location; ?>" data-id="content_resource_page_sidebar_1_row_1" 
                        class="<?php echo $edit_class; ?>"><?php echo get_option('content_resource_page_sidebar_1_row_1', 'content_resource_page_sidebar_1_row_1')?></span></p>
                                 <div class="sidebar_bottom_link">
                                    <a href="<?php echo site_url('dashboard/list/sme') ?>">SMEs Section</a>
                                </div>
                            </div>
                         </div> 
                         
                         <div class="clearfix"></div>  
                         
                         <div class="resources_right">                        
                            <div class="text-center">
                                <h2><a href="<?php echo site_url('dashboard/list/business-partners') ?>">Business Partners</a></h2>
                            </div> 
                            <div style="">
                            <?php 
                            $edit_class = ''; $edit_location='';
                            if ($current_user_can_edit_post) {
                                $edit_class = 'admin_udpate_spot';
                                $edit_location = 'options';
                            }
                            ?>
                                <p style="text-align:left;" >
                                <span data-location="<?php echo $edit_location; ?>" data-id="content_resource_page_sidebar_1_row_2" 
                        class="<?php echo $edit_class; ?>"><?php echo get_option('content_resource_page_sidebar_1_row_2', 'content_resource_page_sidebar_1_row_2') ?></span></p>
                                 <div class="sidebar_bottom_link">
                                    <a href="<?php echo site_url('dashboard/list/business-partners') ?>">Business Partners</a>
                                </div>
                            </div>
                         </div>  
                         
                         <div class="clearfix"></div> 
                         
                         <div class="resources_right">                        
                            <div class="text-center">
                                <h2><a href="<?php echo site_url('dashboard/list/service-providers') ?>">Service Providers</a></h2>
                            </div> 
                            <div style="">
                            <?php 
                            $edit_class = ''; $edit_location='';
                            if ($current_user_can_edit_post) {
                                $edit_class = 'admin_udpate_spot';
                                $edit_location = 'options';
                            }
                            ?>
                                <p style="text-align:left;" ><span data-location="<?php echo $edit_location; ?>" data-id="content_resource_page_sidebar_1_row_3" 
                        class="<?php echo $edit_class; ?>"><?php echo get_option('content_resource_page_sidebar_1_row_3', 'content_resource_page_sidebar_1_row_3') ?></span></p>
                                 <div class="sidebar_bottom_link">
                                    <a href="<?php echo site_url('dashboard/list/service-providers') ?>">Service Providers</a>
                                </div>
                            </div>
                         </div>  
                         
                         <div class="clearfix"></div> 
                         
                         <div class="resources_right">                        
                            <div class="text-center">
                                <h2><a href="<?php echo site_url('dashboard/list/investors') ?>">Investors</a></h2>
                            </div> 
                            <div style="">
                            <?php 
                            $edit_class = ''; $edit_location='';
                            if ($current_user_can_edit_post) {
                                $edit_class = 'admin_udpate_spot';
                                $edit_location = 'options';
                            }
                            ?>
                                <p style="text-align:left;" ><span data-location="<?php echo $edit_location; ?>" data-id="content_resource_page_sidebar_1_row_4" 
                        class="<?php echo $edit_class; ?>"><?php echo get_option('content_resource_page_sidebar_1_row_4', 'content_resource_page_sidebar_1_row_4') ?></span></p>
                                 <div class="sidebar_bottom_link">
                                    <a href="<?php echo site_url('dashboard/list/investors') ?>">Investors</a>
                                </div>
                            </div>
                         </div>  
                         
                         <div class="clearfix"></div> 
                         
                         <div class="resources_right">                        
                            <div class="text-center">
                                <h2><a href="<?php echo site_url('dashboard/list/nonprofit-organizations') ?>">NonProfit Organizations</a></h2>
                            </div> 
                            <div style="">
                            <?php 
                            $edit_class = ''; $edit_location='';
                            if ($current_user_can_edit_post) {
                                $edit_class = 'admin_udpate_spot';
                                $edit_location = 'options';
                            }
                            ?>
                                <p style="text-align:left;" ><span data-location="<?php echo $edit_location; ?>" data-id="content_resource_page_sidebar_1_row_5" 
                        class="<?php echo $edit_class; ?>"><?php echo get_option('content_resource_page_sidebar_1_row_5', 'content_resource_page_sidebar_1_row_5') ?></span></p>
                                 <div class="sidebar_bottom_link">
                                    <a href="<?php echo site_url('dashboard/list/nonprofit-organizations') ?>">NonProfit Organizations</a>
                                </div>
                            </div>
                         </div>  
                        
                       
                        
                    </div> <!-- col-md-4 -->
                    
            </div><!-- container -->
        </div> <!-- END ROW -->
        

	</div>
    <!-- END PAGE CONTAINER -->  
	
	<script>
	var resource_selected = <?php echo is_numeric($res_id) ? $res_id : 0; ?>;
	var company_id = <?php echo $company_selected > 0 ? $company_selected : 0; ?>;
	var file_download_url = '<?php echo site_url('file_download'); ?>'; 
	var site_url = '<?php echo site_url(); ?>';

	var hash = window.location.hash;
	if (hash.length > 1) {
		hash = hash.substring(1);
		if (hash.indexOf(',') > 0) {
		    resource_selected = hash.substring(0, hash.indexOf(','));
		    company_id = hash.substring(hash.indexOf(',') + 1);
		}

		if (!resource_selected > 0 && !company_id > 0)
		{
			company_id = 0;
			resource_selected = 0;
		}
	}
	
	function __initialize_resources_view()
    {
	    $('.resource_title').click(function() {
	    	__reset_modal();
		    var res_id = $(this).attr('data-id');
		    var company_id = $(this).attr('data-cid');
		    if (typeof res_id != 'undefined' && res_id > 0)
		    {			  
			    //window.location.href = window.location.href + '#' + res_id + ',' + company_id;
		    	resource_selected = res_id;
		    	__load_resources(resource_selected, company_id);
		    	__load_company(company_id);
		    }
	    });

	    if (resource_selected > 0) {
	    	__reset_modal();
		    $("#resource_window").modal('show');    
	    	__load_resources(resource_selected, company_id);
	    	__load_company(company_id);
	    }
    } 

    function __reset_modal()
    {
    	$("#list_items").html($("#content_loading").html());
    	$("#model_company_sidebar").html("");
    	$("#model_company_logo").html("");
    }   

    function __load_resources(resource_selected, company_id)
    {
        var data_type = '<?php echo BP_Node::NODE_TYPE_RESOURCE; ?>';
    	$.ajax({
			type: "POST",
			url: "<?php echo get_site_url('','ajax', 'relative'); ?>/",
			data: {mode:'NODES_LIST', type:data_type, cat:0, option_id:resource_selected, company_id:company_id},
			success: function(data){
				$("#list_items").html(data.html);
								
				if (resource_selected > 0) {
					setTimeout(function(){
						$("#scroller_window").scrollTop(0);
    					var scroller_window_top = $("#scroller_window").offset().top;
    					var scroll_length = $("li#list_" + resource_selected).offset().top;
    					scroll_length  = scroll_length - scroller_window_top;
    					$("#scroller_window").animate({scrollTop:scroll_length}, 'slow');
    					resource_selected = 0;
					}, 1000);
				}
			},
			error: function() {
				$("#list_items").text('There was an error fetching the resources');
			}
		});	
    }

    function __load_company(company_id)
    {
    	$.ajax({
			type: "POST",
			url: "<?php echo get_site_url('','ajax', 'relative'); ?>/",
			data: {mode:'GET_COMPANY', company_id:company_id},
			success: function(data){
				
				if (data.hasOwnProperty('success') && data.success === true)
				{
					if (data.hasOwnProperty('result')) {
						var company_name = '';
						var address = '';
						var company_link = '';
						var pm_link = '';
						var sidebar_image_url = '';
						if (data.result.hasOwnProperty('company')) {
							company_name = data.result.company.company_name;
							if (data.result.company.id > 1) {
								if (data.result.company.addresses.length > 0) {
									$.each(data.result.company.addresses, function(index, value) {
										address += value.postal_code + ', ' + value.company_number + ', ' + value.street + '<br />'
									        + value.region + '<br />'
									        + value.city;
									});
								}

								company_link = site_url + '/dashboard/view-company?id=' + data.result.company.id;
								pm_link = company_link;
								company_link = '<a href="' + company_link + '"><i class="fa fa-folder-open"></i> View Page</a> <br>';
								pm_link = '<a href="' + pm_link + '"><i class="fa fa-envelope-o"></i> Send Message</a>';
							}
						}
						if (data.result.hasOwnProperty('profile')) {
							if(data.result.profile.hasOwnProperty('logo_id')) {
								if (data.result.profile.logo_id > 0) {
									new Image().src = file_download_url + '/?file_id=' + data.result.profile.logo_id;
								    var html = '<img src="' + file_download_url + '/?file_id=' + data.result.profile.logo_id + '" />';
								    $("#model_company_logo").html(html);
								}
							}
							if (data.result.profile.hasOwnProperty('lightbox_image_id')) {
								if (data.result.profile.lightbox_image_id > 0) {
									sidebar_image_url = file_download_url + '/?file_id=' + data.result.profile.lightbox_image_id + '&default=1&w=295&h=400';
									new Image().src = sidebar_image_url;
								}
							}
						}
						//$("#model_company_sidebar")
						var html = '';
						html = '<img src="' + sidebar_image_url + '" class="img-responsive">' +
						        '<div style="padding:10px 0 0 15px;">' +
                            	'<h5 style="font-weight:bold">' + company_name + '</h5>' +
                                '<p style="line-height:normal">' +
                                    address +
                                '</p>' +
                                '<p style="line-height:normal">' +
                                    company_link + //'<a href="#"><i class="fa fa-folder-open"></i> View Page</a> <br>' + 
                                    pm_link + //'<a href="#"><i class="fa fa-envelope-o"></i> Send Message</a>' +
                                '</p>' +
                            '</div>';

                            $("#model_company_sidebar").html(html);
                        
					}			
				}				
			},
			error: function() {
				$("#model_company_sidebar").text('There was an error fetching the company information');
			}
		});
    }
    
	</script>
<?php 
Theme_Vars::add_script_ready('__initialize_resources_view();');
?>
   

   <?php get_footer(); ?>
    
    
     <!-- Modal (Advertise With Us) -->
    <div class="modal fade" id="resource_window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content" style="font-size:13px;">
                  
          
          		<div class="row">
                	<div class="col-md-4" id="model_company_sidebar">                	    
                    </div>
                    <div class="col-md-8">
                       <div class="row">
                       		<div class="text-center margin-top-20">
                            	<div id="model_company_logo"></div>
                        		<h4>Shared Resources</h4>
                            </div>
                          	
                            <!-- uploaded resources  -->
                            <div class="container">
                            <div id="scroller_window" class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
                            <div class="hidden" id="content_loading">
                                <p>&nbsp;<br />&nbsp;<br/></p>
                                <p>Please wait ..</p>
                                <div class="progress progress-striped active" style="width:60%;">
    								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
    									<span class="sr-only">Loading</span>
    								</div>
    							</div>
                            </div>
                            <div id="list_items">                            
								</div>
							</div>
                            
                            </div>
                            <!-- uploaded resources  -->
                       </div>
                    </div>
                </div>
          
         
         <div class="modal-footer">
         	<div class="col-md-5">
            	<!-- img src="images/modal_logo.jpg" id="logoimg" alt="" class="img-responsive" -->
            </div>
            <div class="col-md-7">
            	&copy; <?php echo date('Y'); ?> <?php echo MAIN_COMPANY_NAME; ?>. All Rights Reserved
            </div>
         </div>
         
      </div>
    </div>
    
    <!-- Modal (Advertise With Us) -->
 