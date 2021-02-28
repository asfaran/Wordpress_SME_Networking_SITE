<?php
define('PRIVATE_SUBMENU', true, true);
define('PARENT', 'MYACCOUNT', true);

$current_company_id = biz_portal_get_current_company_id();
if ($current_company_id == 0) {
    BP_FlashMessage::Add('You should have a company associated with your account to view the favourites', BP_FlashMessage::ERROR);
    wp_redirect(site_url('dashboard'));
    exit();
}

$repo_fav = new BP_Repo_Favourites($wpdb, biz_portal_get_table_prefix());
$favs = $repo_fav->get_list($current_company_id);
$countries = biz_portal_get_country_list();

?>

<?php get_header(); ?>

    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body profile-inner">
	
       

		<!-- BEGIN CONTAINER -->   
		<div class="container min-hight">
			<div class="row margin-bottom-40">
				

				<div class="col-md-12">
                    <!-- BEGIN TAB CONTENT -->
                    
                    <h3 class="page-title">Favorites</h3>
                    <?php
                    if (BP_FlashMessage::HasMessages()) {
            			biz_portal_get_messages();
            		}
                    ?>
                    
                    <div class="tab-content">
                      
                                           
                      <!-- START TAB 2 -->
                      <div id="tab_2" class="tab-pane  active">
                         <div class="container">
                         		<!-- Favorites Page   -->
                         		<div class="row">
                                    <div class="col-md-12">
                                       	<table class="table table-striped table-advance table-hover">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Country</th>
                                                    <th>Company Name</th>    
                                                                                                            
                                                    <th class="pagination-control text-right" colspan="2" align="right">
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (count($favs) == 0) :?>
                                                <tr><td colspan="4">No favourites found.</td></tr>
                                            <?php endif; ?>
                                            <?php foreach ($favs as $fav) :?>
                                                <tr>
                                                    <td class="inbox-small-cells">
                                                        <a href="" rel="<?php echo $fav->company_id; ?>" class="link_remove_favourite">
                                                            <i class="fa fa-star"></i></a></td>
                                                    <td class="view-message  hidden-xs">
                                                        <?php $country 
                                                                = biz_portal_select_country(
                                                                        $fav->target_company->country_of_incorporate, $countries); 
                                                            echo isset($country['country_name']) ? $country['country_name'] : ''; ?></td>
                                                    <td class="view-message ">
                                                        <a href="<?php echo site_url('dashboard/view-company') . '?id=' . $fav->target_company_id; ?>" 
                                                            title="<?php echo $fav->target_company->company_name; ?>">
                                                            <?php echo $fav->target_company->company_name; ?></a></td>
                                                    <td class="view-message  inbox-small-cells"><i class="fa fa-paper-clip"></i></td>
                                                    <td class="view-message  text-right">
                                                        <?php echo date('d M, Y', strtotime($fav->created)); ?></td>
                                                </tr>
                                             <?php endforeach; ?>                                             
                                            </tbody>
                                        </table>
                                    </div>
                                   
                                </div>
                         		<!-- Inbox Page  -->
                         </div>
                      </div>
                      <!-- END TAB 2 -->
                      
                      
                    </div>
                    <!-- END TAB CONTENT -->
				</div>            
			</div> <!-- ROW -->
            
            <div class="clearfix"></div>
            
     
           
		</div>
		<!-- END CONTAINER -->

	</div>
    <!-- END PAGE CONTAINER -->  

	<script>

	function __initialize_favourites()
	{
		var current_company_id = "<?php echo biz_portal_get_current_company_id(); ?>";
        var viewing_company_id = 0;
        
		$(".link_remove_favourite").click(function(e) {
			e.preventDefault();
			var tr = $(this).closest("tr");
			var table = $(this).closest("table");
			
			viewing_company_id = $(this).attr('rel');
			if (viewing_company_id > 0 && current_company_id > 0) {				
			    var res = company_view_remove_favourite(current_company_id, viewing_company_id, tr, table);
			}
		});
	}

	function company_view_remove_favourite(current_company_id, viewing_company_id, elem, table)
    {
    	$.ajax({
			type:"POST",
			url:"<?php echo get_site_url('','ajax', 'relative'); ?>/",
			dataType:'json',
			data:{mode:'REMOVE_FAVOURITE',s_cid:current_company_id, t_cid:viewing_company_id },
			success: function(data){
				if (data.hasOwnProperty('done') && data.done === true) {
					if (data.hasOwnProperty('success') && data.success === true) {
						elem.remove();
					}
				}				
			}
	  });
  	  return false;
    }
	
	</script>
  <?php 
      Theme_Vars::add_script_ready('__initialize_favourites();');
  ?>

<?php get_footer(); ?>