<?php
/*
  Template Name: Private Investors Page
 */
define('PRIVATE_SUBMENU', true, true);
define('SUBMENU_ITEM', 'investors');
define('DIRECTORY', 'INVESTORS', true);

$scroll_to_boundry = false;

$count = 10;
//$offset = (isset($wp_query->query_vars['page'])) ? $wp_query->query_vars['page'] : 0 ;
$current_page = filter_input(INPUT_GET, 'p', FILTER_VALIDATE_INT);
if (!isset($current_page))
    $current_page = 1;

$offset = ($current_page * $count) - $count;

$BP_Company_Filter = new BP_Company_Filter();
//$BP_Company_Filter->member_type = BP_MemberType::TYPE_SME;
$BP_Company_Filter->bool_biz_give_invest = true;
$search_form = false;

if (isset($_POST['filter_biz_invest'])) {
    $filter_values = filter_input_array(INPUT_POST, $BP_Company_Filter->get_validators());
    $BP_Company_Filter->exchange_array($filter_values);
    //var_dump($filter_values);
    $scroll_to_boundry = true;
    $search_form = true;
}

if (isset($_GET['p'])) $scroll_to_boundry = true;

$BP_Repo_Companies = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix());
$ViewModel_Companies = $BP_Repo_Companies->filter_companies($BP_Company_Filter, $count, $offset);

$total_pages = ceil($ViewModel_Companies->total / $ViewModel_Companies->count);

biz_portal_add_visit(BP_VisitPageType::CUSTOM_PAGE, BP_CustomPage::INVESTOR);

get_header();

?>

    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body" >
        
        <?php
        $type='investor';
        include __DIR__ . '/html_includes/directory_header_slider.php'; ?>
        
        <?php
        if (BP_FlashMessage::HasMessages()) {
			biz_portal_get_messages();
		}
        ?>

        <?php include __DIR__ . '/html_includes/directory_stats.php'; ?>
        </div> <!-- row  -->
        
        <?php /*?>
        <div id="scroll_boundry" class="row" style="background-color:#b6b5a0">
        	<div class="container line_break">
            	<div class="col-md-12">
                	To view all Category Dashboards, go to <strong>"My Account > Dashboard"</strong> or <a href="<?php echo site_url('dashboard'); ?>" style="color:#fff">click here &raquo; </a>
                </div>    
            </div> <!-- container  -->
        </div> <!-- row  -->
        <?php */ ?>
        
        
        <div class="row" style="background-color:#fff">
        	<div class="container margin-bottom-30">
            	<div>
                
                	<h3 class="header_title_2">COMPANY LISTING</h3>
                    <div class="margin-bottom-20 margin-top-20" style="border-top:#dedede 1px solid;display:block">
                        
                        <div>
                       		<div class="small_menu" >
                       		<form id="form_filter" action="<?php echo site_url('dashboard/list/investors'); ?>" method="post">
                       		<input type="hidden" value="1" name="filter_biz_invest" />
                                    <ul>
                                        <li><a href="<?php echo site_url('dashboard/list/investors'); ?>">All</a></li>
                                        
                                        <li class="dropdown" id="business_type_form">
                                        	<a href="#" class="dropdown-toggle"  data-hover="dropdown" data-close-others="true">Investing Amount</a>
                                           <div class="dropdown-menu extended notification" style="padding:0 0 10px 10px;">
                                            	<h4>Investing Amount</h4>
                                               <div >
                                                    	<div class="form-group">
                                                         
                                                          <div class="checkbox-list">
                                                             <?php foreach ($BP_Company_Filter->invest_amount_values as $value) : ?>
                                                             <label>
                                                             	<input type="checkbox" name="filter_do_invest[]" value="<?php echo $value['value'] ?>" <?php 
                                                             	echo ($BP_Company_Filter->is_min_max_selected($BP_Company_Filter->do_invest, $value['value_min'], $value['value_max'])) ? 'checked="checked"' : '';?>> <?php echo $value['text'] ?>
                                                             </label>
                                                          <?php endforeach; ?>                                                                 
                                                          </div>
                                                       </div>
                                                       <div class="form-actions">
                                                           <button type="submit" class="btn yellow">Apply Filters <i class="fa fa-angle-double-down"></i></button>
                                                                                   
                                                        </div>  
                                               	</div>
                                            </div>
                                        </li>
                                        <li class="dropdown list_sub_menu" id="industry_form">
                                        	<a href="#" class="dropdown-toggle"  data-hover="dropdown" data-close-others="true">Industry Focus</a>
                        					<div class="dropdown-menu extended notification" style="padding:0 0 10px 10px;">
                                            	<h4>Industry Focus</h4>
                                               <div >
                                                    	<div class="form-group">
                                                         
                                                          <div class="checkbox-list">
                                                          <?php foreach (biz_portal_get_industries_list() as $industry) : ?>
                                                          <?php if ($industry['id'] > 0) :?>
                                                             <label>
                                                             	<input type="checkbox" name="filter_invest_in_industries[]" value="<?php echo $industry['id']; ?>" <?php echo in_array($industry['id'], $BP_Company_Filter->invest_in_industries ) ? 'checked="checked"' : ''; ?>> <?php echo $industry['ind_name']?>
                                                             </label>
                                                          <?php endif; ?>
                                                          <?php endforeach;?>
                                                          </div>
                                                       </div>
                                                       <div class="form-actions">
                                                           <button type="submit" class="btn yellow">Apply Filters <i class="fa fa-angle-double-down"></i></button>
                                                                                   
                                                        </div>  
                                               	</div>
                                            </div>
                        				</li>
                                        <li class="dropdown" id="turnover_form">
                                        	<a href="#" class="dropdown-toggle" data-hover="dropdown" data-close-others="true">Turnover (Req)</a>
                                            <div class="dropdown-menu extended notification" style="padding:0 0 10px 10px;">
                                            	<h4>Turnover Requirement</h4>
                                               <div >
                                                    	<div class="form-group">
                                                         
                                                          <div class="checkbox-list">
                                                          
                                                          <?php foreach ($BP_Company_Filter->invest_turnover_values as $value) :?>                                                             
                                                             <label>
                                                             	<input type="checkbox" name="filter_invest_req_turnover[]" value="<?php echo $value['value'] ?>"<?php
                                                             	echo ($BP_Company_Filter->is_min_max_selected($BP_Company_Filter->invest_req_turnover, $value['value_min'], $value['value_max'])) ? 'checked="checked"' : ''; ?>> <?php echo $value['text'] ?>
                                                             </label>
                                                          <?php endforeach; ?>                                                            
                                                          </div>
                                                       </div>
                                                       <div class="form-actions">
                                                           <button type="submit" class="btn yellow">Apply Filters <i class="fa fa-angle-double-down"></i></button>
                                                                                   
                                                        </div> 
                                               	</div>
                                            </div>
                                        </li>
                                        <li class="dropdown" id="num_employees_form">
                                        	<a href="#" class="dropdown-toggle" data-hover="dropdown" data-close-others="true">Years in Business</a>
                                            <div class="dropdown-menu extended notification" style="padding:0 0 10px 10px;">
                                            	<h4>Years in Business</h4>
                                               <div >
                                                    	<div class="form-group">
                                                         
                                                          <div class="checkbox-list">
                                                          <?php foreach ($BP_Company_Filter->years_in_business as $value) : ?>                                                          
                                                             <label>
                                                             	<input type="checkbox" name="filter_invest_req_years_biz[]" value="<?php echo $value['value'] ?>" <?php 
                                                             	echo ($BP_Company_Filter->is_min_max_selected($BP_Company_Filter->invest_req_years_biz, $value['value_min'], $value['value_max'])) ? 'checked="checked"' : '';?>> <?php echo $value['text'] ?>
                                                             </label>
                                                          <?php endforeach ;?>                                                           
                                                          </div>
                                                       </div>
                                                       <div class="form-actions">
                                                           <button type="submit" class="btn yellow">Apply Filters <i class="fa fa-angle-double-down"></i></button>
                                                        </div>   
                                               	</div>
                                            </div>
                                        </li>
                                        <li class="dropdown list_sub_menu" id="industry_form">
                                        	<a href="#" class="dropdown-toggle" data-hover="dropdown" data-close-others="true">Country</a>
                        					<div class="dropdown-menu extended notification" style="padding:0 0 10px 10px;">
                                            	<h4>Country</h4>
                                               <div >
                                                    	<div class="form-group">
                                                         
                                                          <div class="checkbox-list">
                                                             <?php foreach (biz_portal_get_filter_country_list() as $country) : ?>
                                                             <label>
                                                             	<input type="checkbox" name="filter_country[]" value="<?php echo $country['id']; ?>" <?php 
                                                             	echo (in_array($country['id'], $BP_Company_Filter->country_of_incorporate)) ? 'checked="checked"' : ''; ?>> <?php echo $country['country_name']; ?>
                                                             </label>
                                                          <?php endforeach; ?>
                                                          </div>
                                                       </div>
                                                       <div class="form-actions">
                                                           <button type="submit" class="btn yellow">Apply Filters <i class="fa fa-angle-double-down"></i></button>
                                                                                   
                                                        </div>  
                                               	</div>
                                            </div>
                        				</li>
                                    </ul>
                                    </form>
                            </div>
                        </div> <!--  col-md-12 -->
                       
                    </div>  <!--  margin-bottom-20 -->
                     <div style="border-bottom:#dedede 1px solid;">&nbsp;</div>
                    
                    <div class="clearfix"></div>
                	
                    <div class="col-md-8">
                    
                    	<?php	if (count($ViewModel_Companies->companies) > 0) :  ?>
                        
                        	<?php foreach($ViewModel_Companies->companies as $company): ?>
                        
                                <div class="private_item margin-top-20">
                                    
                                
                                    <h4 class="bold"><a href="/dashboard/view-company?id=<?php echo $company->id; ?>" class="success_title"><?php echo $company->company_name;  ?> </a> </h4>
                                    <p><?php echo $company->summary;  ?></p>
                                    <a class="more" href="/dashboard/view-company?id=<?php echo $company->id; ?>">View <?php echo $company->company_name;  ?></a>
                                </div> <!-- private_item  -->
                        
                       		<?php endforeach;  ?>
                       
                       <?php else : ?>
                           <?php 
                            $edit_class = ''; $edit_location='';
                            if (current_user_can('edit_post')) {
                                $edit_class = 'admin_udpate_spot';
                                $edit_location = 'options';
                            }
                            ?>
                            &nbsp;<br />
                            <div data-location="<?php echo $edit_location; ?>" data-id="content_investor_nocontent" class="<?php echo $edit_class; ?>">
                            <?php echo get_option('content_investor_nocontent', 'No listing found.') ?></div>
                       <?php endif;  ?> 
                        
                        <div align="center">
                            <?php sbpssme_create_pager($_GET, $_SERVER['REQUEST_URI'], $ViewModel_Companies->count, $ViewModel_Companies->total, 'pagination pagination-centered', 'active'); ?>
                        </div> 
                        
                    </div>                    
                    <?php include __DIR__ . '/html_includes/sidebar_directory.php'; ?>
                </div>
            </div> <!-- container  -->
        </div> <!-- row  -->

	</div>
    <!-- END PAGE CONTAINER -->  
	    <script>
    function __scroll_to_boundry()
    {
    	var scroll_to_boundry = <?php echo (isset($scroll_to_boundry) && $scroll_to_boundry === true) ? "true" : "false"; ?>;
        if (scroll_to_boundry) {
            var scroll_value = $( '#scroll_boundry' ).offset().top;
            if (scroll_value > 100) scroll_value -= 100;
        	$('html, body').animate({
        		scrollTop: scroll_value
            }, 1000);
        }
    }

    function __submit_pagination()
    {
        var has_search_data = <?php echo $search_form ? 'true' : 'false'; ?>;
        if (has_search_data) {
            $(".pagination li a").click(function(e) {
                e.preventDefault();
                var action_url = $(this).attr('href');
                if (action_url.length > 1) {
                    $("#form_filter").attr('action', action_url);
                    $("#form_filter").submit();
                }
            });
        }
    }
    </script>
	
	<?php Theme_Vars::add_script_ready('__scroll_to_boundry();'); ?>  
	<?php Theme_Vars::add_script_ready('__submit_pagination();'); ?> 
   

   <?php get_footer(); ?>
<?php include __DIR__ . "/pages/myanmar_directory.php"; ?>
