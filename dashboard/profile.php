<?php
define('PRIVATE_SUBMENU', true, true);
define('PROFILE_PAGE', true, true);
define('PARENT', 'MYACCOUNT', true);

$company_id = biz_portal_get_current_company_id();
if (!$company_id)
{
	BP_FlashMessage::Add('No company is associated with your account', BP_FlashMessage::INFO);
	wp_redirect(site_url('dashboard'));
	exit();
}

$BP_Company = biz_portal_get_company($company_id);

$BP_Company_Full = biz_portal_load_company_relations($BP_Company);

$BP_CompanyProfile = biz_portal_get_company_profile($company_id);

//print_r($BP_CompanyProfile);

/*if ($BP_CompanyProfile == null) {
	$link = site_url('dashboard/profile/details');
	$link = '<a href="' . $link . '">here</a>';
	BP_FlashMessage::Add("You do not have completed the profile yet, please click {$link} to update it now.", BP_FlashMessage::INFO);
}*/

$unread_messages = biz_portal_pm_new();

$member_type_id = $BP_Company->member_type_id;

$biz_types = $BP_Company_Full->biz_types;
$biz_related_industries =  $BP_Company_Full->industries;

$biz_details_title = array(
	'PARTNER' => 'If you are looking for business partners in Myanmar, please describe what type of partners you are looking for. (maximum 350 words) ',
	'PROVIDE_SERVICE' => 'If you are looking for service providers or to provide services, please describe more details. (maximum 350 words)',
	'PROVIDE_INVEST' => 'For those interested in investing in Myanmar, please describe more details. (maximum 350 words)',
	'NGO_SUPPORT_SERVICE' => 'Provide Support/Services as NonProfit Organization, please describe more details. (maximum 350 words)',
	'NEED_SERVICE' => 'If you are looking for service providers or to provide services, please describe more details. (maximum 350 words)',
	'NEED_INVEST' => 'If you are looking for foreign investors, please describe more details. (maximum 350 words)',
);

$BP_Repo_Nodes = new BP_Repo_Nodes($wpdb, biz_portal_get_table_prefix());

?>

<?php get_header(); ?>
    
	<!-- END HEADER -->
	<div class="clearfix"></div>
	<!-- BEGIN CONTAINER -->   
	<div class="page-container  page-body profile-inner">
		<?php //echo $member_type_id; ?>
		<!-- BEGIN PAGE -->
		<div class="container min-hight">
			
			           
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12 margin-bottom-30">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
					<h3 class="page-title">
						Company Profile	 <?php //echo $member_type_id; ?>
					</h3>
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
                                                                                            <img src="<?php echo biz_portal_get_file_url($BP_Company_Full->profile->logo_id, 1, 0, 1) ?>" class="img-responsive" alt="" /> 
												<a href="<?php echo site_url('dashboard/profile/details') ?>" class="profile-edit">edit</a>
											</li>
											<li><a href="<?php echo site_url('dashboard'); ?>">Dashboard</a></li>
                                                                                        <li><a href="/dashboard/profile/details">Profile Details</a></li>
											<li><a href="<?php echo site_url('dashboard/messages'); ?>">Messages
                                                                                            <?php if ($unread_messages) : ?>
                                                                                                <span><?php echo $unread_messages; ?></span>
                                                                                                    <?php endif;?></a></li>
											<li><a href="<?php echo site_url('dashboard/favourites'); ?>">Favorites</a></li>
											
											
										</ul>
									</div>
									*/ ?>
									<div class="col-md-12">
										<div class="row">
											<div class="col-md-8 profile-info">
												<h1><?php echo $BP_Company_Full->company_name; ?> 
												<?php  if ($company_id > 1) :?>
												    <span style="font-size:13px;font-weight:normal;">
												        (<a target="_blank" href="<?php echo site_url('/dashboard/view-company') . '?id=' . $company_id ?>">Preview</a>)</span>
											    <?php endif; ?>
												</h1>
												<p><?php echo $BP_Company_Full->summary; ?></p>
												<?php $company_contacts = $BP_Company_Full->contacts; ?>
                                                
                                                <p><a href="#"><?php echo $company_contacts->web; ?></a></p>
												<ul class="list-inline">
													<li><i class="fa fa-map-marker"></i> 
														<?php 
															$country_list = biz_portal_get_country_list();
															$country =  biz_portal_select_country($BP_Company_Full->country_of_incorporate, $country_list); 
															echo $country['country_name'];
															?>
                                                    </li>
                                                    <li><i class="fa fa-briefcase"></i> <?php echo $BP_Company_Full->reg_number; ?></li>
													<li><i class="fa fa-calendar"></i> <?php echo $BP_Company_Full->year_of_incorporate; ?></li>
												</ul>
											</div>
											<!--end col-md-8-->
											<div class="col-md-4">
												<div class="portlet sale-summary">
													<div class="portlet-title">
														<div class="caption">User Summary</div>
														
													</div>
													<div class="portlet-body">
														<ul class="list-unstyled">
															<li>
																<span class="sale-info">RESOURCES UPLOADED <i class="fa fa-img-up"></i></span> 
																<span class="sale-num"><?php echo $BP_Repo_Nodes->count_nodes(BP_Node::NODE_TYPE_RESOURCE, array('company_id' => $BP_Company->id)) ?></span>
															</li>
															<li>
																<span class="sale-info">COMPANY POSTS <i class="fa fa-img-down"></i></span> 
																<span class="sale-num"><?php echo $BP_Repo_Nodes->count_nodes(BP_Node::NODE_TYPE_POST, array('company_id' => $BP_Company->id)) ?></span>
															</li>
															<li>
																<span class="sale-info">COMPANY DOWNLOADS</span> 
																<span class="sale-num"><?php echo $BP_Repo_Nodes->count_nodes(BP_Node::NODE_TYPE_DOWNLOAD, array('company_id' => $BP_Company->id)) ?></span>
															</li>
															
														</ul>
													</div>
												</div>
											</div>
											<!--end col-md-4-->
										</div>
										<!--end row-->
                                        
                                        <div class="row ">
                                        	<div class="col-md-12  margin-bottom-20">
                                            	<div class="portlet box">
													<div class="portlet-title">
                                            			<div class="margin-bottom-20">
                                                        	<span style="font-size:18px;">Business Related Information</span> 
                                                        	<div class="pull-right"><a href="/dashboard/profile/details" class="btn btn-warning">Edit Images</a>&nbsp;
                                                        	<a href="/form-signup/?mt=<?php echo urlencode(base64_encode($member_type_id)); ?>" class="btn btn-warning">Edit Profile</a></div>
                                                        </div>
                                            		</div>
                                            		<div class="portlet-body">
                                                    	<table class="table table-hover table-bordered">
                                                        	<thead style="background-color:#ddd">
                                                            	<th>Type of Business</th>
                                                                <th>Industry Operates</th>
                                                                <th>Annual Turnover(USD)</th>
                                                                <th>Number of Employees</th>
                                                            </thead>
                                                            <tbody>
                                                            	<td>
                                                                <?php  if(!empty($biz_types)):	?>
                                                                	<ul class="list-unstyled">
                                                                       <?php foreach($biz_types as $key => $value): ?>
                                                                        <li><?php echo $value->type_text; ?></li>
                                                                       <?php endforeach; ?>
                                                                    </ul>
                                                                 <?php endif; ?>   
                                                                    
                                                                </td>
                                                                <td>
                                                                <?php if(!empty($biz_related_industries)):  ?>
                                                                	<ul class="list-unstyled">
                                                                        <?php foreach($biz_related_industries as $key => $value):  ?>
                                                                        	<li><?php echo  $value->ind_name; ?></li>
                                                                        <?php endforeach;  ?>
                                                                    </ul>
                                                                 <?php endif;  ?>   
                                                                </td>
                                                                <td>
                                                                	<?php
																		$turnover = "";
																		$turnover_min = $BP_Company_Full->turnover_min;
																		$turnover_max = $BP_Company_Full->turnover_max;
																		
																		if(($turnover_min == 0) && ($turnover_max == 0))
																			$turnover = "Not Disclosed";
																		else {
																			if(($turnover_min == 0) && ($turnover_max == 1000000))
																				$turnover = "Under 1,000,000";
																			else {
																				if(($turnover_min == 50000000) && ($turnover_max == 0))
																					$turnover = "Over 50,000,000";
																				else {
																					$turnover = number_format($turnover_min) . " - " . number_format($turnover_max);
																				}
																			}
																		}
																		
																		echo $turnover;
																	
																	?>
                                                                </td>
                                                                <td>
																	<?php
                                                                    	$employee = "";
																		$employee_min = $BP_Company_Full->num_employee_min;
																		$employee_max = $BP_Company_Full->num_employee_max;
																		
																		if(($employee_min == 0) && ($employee_max == 100))
																			$employee = "Less than 100";
																		else {
																			if(($employee_min == 500) && ($employee_max == 0))
																				$employee = "Over 500";
																			else {
																				$employee = $employee_min . " - " . $employee_max;
																			}
																		}
                                                                    	echo $employee;
                                                                    ?>
                                                                </td>
                                                            </tbody>
                                                        </table>
                                                     </div>    <!-- portlet-body -->
                                            
                                            	</div> <!--portlet-->
                                            </div> <!--col-md-5-->
                                        </div> <!--end row-->
                                        
                                        
                                        <div class="row margin-bottom-40">
                                        	<div class="col-md-12  margin-bottom-20">
                                            	<div class="portlet box">
													<div class="portlet-title">
                                            			<div class="margin-bottom-20">
                                                        	<span style="font-size:18px;">Business Needs</span> 
                                                        	
                                                            <!--
                                                            <a href="/form-signup/?mt=<?php //echo urlencode(base64_encode($member_type_id)); ?>" class="btn btn-warning pull-right">Update</a>
                                                            -->
                                                        </div>
                                            		</div>
                                            		<div class="portlet-body">
														<table class="table table-hover table-bordered">
                                                        	<thead style="background-color:#ddd">
                                                            	<th>Partner(s) in</th>
                                                                <th>Provide Services in</th>
                                                                <th>Invest</th>
                                                                <?php if($member_type_id == "TYPE_INTL"):  ?>
                                                                <th>Provide Support as NGO</th>
                                                                <?php endif;  ?>
                                                            </thead>
                                                            <tbody>
                                                            	<td>
                                                                	<?php 
																	$biz_need_partner_biz_type = $BP_Company_Full->biz_need_partner_biz_types;
																	if(!empty($biz_need_partner_biz_type)):  ?>
                                                                    	<ul class="list-unstyled">
                                                                        	<?php foreach($biz_need_partner_biz_type as $key => $biz_value):  ?>
                                                                            	<li><?php echo $biz_value->type_text;  ?></li>
                                                                            <?php  endforeach; ?>
                                                                        </ul>                                                                    
                                                                    <?php  endif; ?>
																	
																	
																	
																	<?php
																	$biz_need_partner_industries = $BP_Company_Full->biz_need_partner_industries;
																	if(!empty($biz_need_partner_industries)):  ?>
                                                                    		
                                                                            <ul class="list-unstyled">
                                                                    	
																			<?php foreach($biz_need_partner_industries as $key => $value):  ?>
                                                                                    <li><?php echo $value->ind_name;  ?></li>
                                                                            <?php endforeach;  ?>  
                                                                        
                                                                        	</ul>  
                                                                    
                                                                    <?php endif;  ?>
                                                                    
                                                                    
                                                                </td>
                                                                <td>
																		<?php if($member_type_id == "TYPE_INTL"):  ?>
																		
																			<?php
                                                                                $biz_give_services = $BP_Company_Full->biz_give_services;
                                                                                if(!empty($biz_give_services)):
                                                                            ?>
                                                                            <ul class="list-unstyled">
                                                                                <?php  foreach($biz_give_services as $key => $value): ?>
                                                                                    <li><?php echo $value->service_name;  ?></li>
                                                                                <?php  endforeach; ?>
                                                                            </ul>
                                                                            <?php endif; ?>
                                                                            
                                                                       <?php else: ?>    
                                                                       
                                                                        	<?php
                                                                                $biz_need_services = $BP_Company_Full->biz_need_services;
                                                                                if(!empty($biz_need_services)):
                                                                            ?>
                                                                            <ul class="list-unstyled">
                                                                                <?php  foreach($biz_need_services as $key => $value): ?>
                                                                                    <li><?php echo $value->service_name;  ?></li>
                                                                                <?php  endforeach; ?>
                                                                            </ul>
                                                                            <?php endif; ?>
                                                                            
                                                                        <?php endif; ?>    
                                                                </td>
                                                                <td>
                                                                	
																	<?php if($member_type_id == "TYPE_INTL"):  ?>
																	
																	<?php
																			$biz_give_invest = $BP_Company_Full->biz_give_investment;
																			
																			$biz_invest_amount = "";
																			$biz_give_invest_min = 	$biz_give_invest->min;
																			$biz_give_invest_max = 	$biz_give_invest->max;
																			if(($biz_give_invest_min == 0) && ($biz_give_invest_max == 1000000)){
																				$biz_invest_amount = "Up to 1,000,000 USD";
																			} else {
																				if(($biz_give_invest_min == 5000000) && ($biz_give_invest_max == 0)){
																					$biz_invest_amount = "Over 5,000,000 USD";
																				} else {
																					$biz_invest_amount = number_format($biz_give_invest_min) . " - " . number_format($biz_give_invest_max);
																				}
																			}
																			
																			$biz_invest_employee = "";
																			$biz_give_employee_min = $biz_give_invest->sme_employee_min;
																			$biz_give_employee_max = $biz_give_invest->sme_employee_max;
																			
																			if(($biz_give_employee_min == 0) && ($biz_give_employee_max == 0)){
																				$biz_invest_employee = "No Requirement";
																			} else {
																				if(($biz_give_employee_min == 200) && ($biz_give_employee_max == 0)){
																					$biz_invest_employee = "200+";
																				} else {
																					$biz_invest_employee = $biz_give_employee_min . " - " . $biz_give_employee_max;
																				}
																			}
																			
																			$biz_invest_turnover = "";
																			$biz_give_turnover_min = $biz_give_invest->turnover_min;
																			$biz_give_turnover_max = $biz_give_invest->turnover_max;
																			
																			if(($biz_give_turnover_min == 0) && ($biz_give_turnover_max == 1000000)){
																				$biz_invest_turnover = "Up to 1,000,000";
																			} else {
																				if(($biz_give_turnover_min == 5000000) && ($biz_give_turnover_max == 0)){
																					$biz_invest_turnover = "5,000,000+";
																				} else {
																					if(($biz_give_turnover_min == 0) && ($biz_give_turnover_max == 0)){
																						$biz_invest_turnover = "No Requirement";
																					} else {
																						$biz_invest_turnover = number_format($biz_give_turnover_min) . " - " . number_format($biz_give_turnover_max);
																					}
																				}
																			}
																			
																			
																			$biz_invest_years = "";
																			$biz_give_year_min = $biz_give_invest->years_in_biz_min;
																			$biz_give_year_max = $biz_give_invest->years_in_biz_max;
																			
																			if(($biz_give_year_min == 0) && ($biz_give_year_max == 0))
																				$biz_invest_years = "No Requirement";
																			else {
																				if(($biz_give_year_min == 0) && ($biz_give_year_max == 2))
																					$biz_invest_years = "0 - 2 Years"; 
																				else {
																					if(($biz_give_year_min == 10) && ($biz_give_year_max == 2))
																						$biz_invest_years = "10 Years +"; 
																					else {
																						$biz_invest_years = $biz_give_year_min . " - " . $biz_give_year_max;
																					}
																				}
																			}
																			
																	?>  
                                                                    
                                                                    <?php else:  //  Local Myanmar SME ?>
                                                                    	
                                                                    	<?php
																			$biz_need_invest = $BP_Company_Full->biz_need_investment;
																			
																			$biz_invest_amount = "";
																			$biz_need_invest_min = 	$biz_need_invest->min;
																			$biz_need_invest_max = 	$biz_need_invest->max;
																			if(($biz_need_invest_min == 0) && ($biz_need_invest_max == 1000000))
																				$biz_invest_amount = "Up to 1,000,000 USD";
																			else {
																				if(($biz_need_invest_min == 5000000) && ($biz_need_invest_max == 0))
																					$biz_invest_amount = "Over 5,000,000 USD";
																				else {
																					$biz_invest_amount = number_format($biz_need_invest_min) . " - " . number_format($biz_need_invest_max);
																				}
																			}
																			
																																						
																			$biz_invest_employee = "";
																			$biz_need_invest_employee_min = $biz_need_invest->sme_employee_min;
																			$biz_need_invest_employee_max = $biz_need_invest->sme_employee_max;
																			if(($biz_need_invest_employee_min == 0) && ($biz_need_invest_employee_max == 0))
																				$biz_invest_employee = "No Requirement";
																			else {
																				if(($biz_need_invest_employee_min == 200) && ($biz_need_invest_employee_max == 0))
																					$biz_invest_employee = "200+";
																				else {
																					$biz_invest_employee = number_format($biz_need_invest_employee_min) . " - " . number_format($biz_need_invest_employee_max);
																				}
																			}
																			
																			
																			$biz_invest_turnover = "";
																			$biz_need_invest_turnover_min = $biz_need_invest->turnover_min;
																			$biz_need_invest_turnover_max = $biz_need_invest->turnover_max;
																			if(($biz_need_invest_turnover_min == 0) && ($biz_need_invest_turnover_max == 1000000))
																				$biz_invest_turnover = "Up to 1,000,000 USD";
																			else {
																				if(($biz_need_invest_turnover_min == 5000000) && ($biz_need_invest_turnover_max == 0))
																					$biz_invest_turnover = "5,000,000+";
																				else {
																					if(($biz_need_invest_turnover_min == 0) && ($biz_need_invest_turnover_max == 0))
																						$biz_invest_turnover = "No Requirement";
																					else {
																					
																						$biz_invest_turnover = number_format($biz_need_invest_turnover_min) . " - " . number_format($biz_need_invest_turnover_max);
																					}
																				}
																			}
																			
																			
																			$biz_invest_years = "";
																			$biz_need_invest_years_min = $biz_need_invest->years_in_biz_min;
																			$biz_need_invest_years_max = $biz_need_invest->years_in_biz_max;
																			if(($biz_need_invest_years_min == 0) && ($biz_need_invest_years_max == 0))
																				$biz_invest_years = "No Requirement";
																			else {
																				if(($biz_need_invest_years_min == 0) && ($biz_need_invest_years_max == 2))
																					$biz_invest_years = "0 - 2 Years";
																				else {
																					if(($biz_need_invest_years_min == 10) && ($biz_need_invest_years_max == 0))
																						$biz_invest_years = "10 Years +";
																					else {
																															
																						$biz_invest_years = number_format($biz_need_invest_years_min) . " - " . number_format($biz_need_invest_years_max);
																					}
																				}
																			}
																			
																		
																		?>
                                                                    	
                                                                    
                                                                    <?php  endif;  ?>
                                                                    <div>
                                                                		<strong>Amount:</strong> 
                                                                        
                                                                        <p><?php echo $biz_invest_amount;  ?></p>
                                                                    </div>
                                                                    <div>
                                                                		<strong>Employee Size:</strong> <p><?php echo $biz_invest_employee;  ?></p>
                                                                    </div>
                                                                    <div>
                                                                		<strong>Industry:</strong> 
                                                                        <p>
																			<?php if($member_type_id == "TYPE_INTL"):  ?>
																			
																				<?php if(!empty($biz_give_invest->industries)){
                                                                                    foreach($biz_give_invest->industries as $key => $biz_give_industries){
                                                                                        echo $biz_give_industries->ind_name . "<br>";
                                                                                    }
                                                                                }?>
                                                                                
                                                                            <?php else:  ?> 
                                                                            
                                                                            	<?php if(!empty($biz_need_invest->industries)){
                                                                                    foreach($biz_need_invest->industries as $key => $biz_need_industries){
                                                                                        echo $biz_need_industries->ind_name . "<br>";
                                                                                    }
                                                                                }?>
                                                                            
                                                                            <?php endif; ?>   
                                                                        </p>
                                                                    </div>
                                                                    <div>
                                                                		<strong>Turnover:</strong> <p><?php echo $biz_invest_turnover;  ?></p>
                                                                    </div>
                                                                    <div>
                                                                		<strong>Years:</strong> <p><?php echo $biz_invest_years;  ?></p>
                                                                    </div>
                                                                    
                                                                
                                                                </td>
                                                                <?php if($member_type_id == "TYPE_INTL"):  ?>
                                                                <td>
                                                                	<?php
																		$biz_need_ngo = $BP_Company_Full->biz_need_ngo_supp_serv;
																		
																		$biz_need_ngo_funding = "";
																		$biz_need_ngo_funding_min = $biz_need_ngo->fund_min;
																		$biz_need_ngo_funding_max = $biz_need_ngo->fund_max;
																		
																		if(($biz_need_ngo_funding_min == 0) && ($biz_need_ngo_funding_max == 50000))
																			$biz_need_ngo_funding = "Up to USD $50,000";
																		else {
																			if(($biz_need_ngo_funding_min == 1000000) && ($biz_need_ngo_funding_max == 0))
																				$biz_need_ngo_funding = "Up to USD $50,000";
																			else {
																				$biz_need_ngo_funding = number_format($biz_need_ngo_funding_min) . " - " . number_format($biz_need_ngo_funding_max);
																			}
																		}
																	
																	?>
                                                                    
                                                                    <?php  if($biz_need_ngo->org_type_development_agency || $biz_need_ngo->org_type_chamber_of_commerce):  ?>
                                                                    <div>
                                                                    	<strong>Organization Type:</strong> 
                                                                        <p>
																			<?php if($biz_need_ngo->org_type_development_agency) echo "Development Agency";?>    
																			<?php if($biz_need_ngo->org_type_chamber_of_commerce) echo ", <br>Chamber of Commerce";  ?>
                                                                        </p>
                                                                	</div>
                                                                    <?php endif;  ?>
                                                                    <div>
                                                                    	<strong>Services:</strong> 
                                                                        <p>
                                                                        <?php   
																			if(!empty($biz_need_ngo->services_provided)){
																				foreach($biz_need_ngo->services_provided as $key => $biz_need_ngo_services){
																					echo $biz_need_ngo_services->service_name . "<br>";
																				}
																			}
																		?>
                                                                        
                                                                        </p>
                                                                	</div>
                                                                    <div>
                                                                    	<strong>If Funding Provided:</strong> <p><?php  echo $biz_need_ngo_funding; ?></p>
                                                                	</div>
                                                                
                                                                </td>
                                                                
                                                                <?php  endif; ?>
                                                            </tbody>
                                                        </table>   
                                                        
                                                       <!-- BEGIN TAB CONTENT -->
                                                        <div class="tab-content faq_content">
                                                        
                                                          	<?php
																	$biz_details_title;
																	
																	$biz_details_questions = $BP_Company_Full->biz_need_details;
																	
																	if(!empty($biz_details_questions)):
																	
															?>
                                                          <!-- START TAB 3 -->
                                                          <div id="tab_3" class="tab-pane active">
                                                             <div id="accordion3" class="panel-group">
                                                             	
                                                               <?php 
															   $c = 0;
															   foreach($biz_details_questions as $biz_details): 
															   		$c++;
															    ?>
                                                                <div class="panel">
                                                                   <div class="panel-heading">
                                                                      <h5 class="panel-title">
                                                                         <a class="profile_sub_title" data-toggle="collapse" data-parent="#accordion3" href="#accordion3_<?php  echo $c; ?>">
                                                                         		<?php  echo $biz_details_title[$biz_details->biz_need_type_id];  ?>
                                                                         </a>
                                                                      </h5>
                                                                   </div>
                                                                   <div id="accordion3_<?php  echo $c; ?>" class="panel-collapse collapse  <?php  echo ($c == 1) ? 'in' : ''; ?>">
                                                                      <div class="panel-body">
                                                                         <p>
                                                                            <?php  echo $biz_details->detail;  ?>
                                                                         </p>
                                                                        
                                                                      </div>
                                                                   </div>
                                                                </div>
                                                                
                                                                <?php endforeach;  ?>
                                                               
                                                               
                                                             </div>
                                                          </div>
                                                          <!-- END TAB 3 -->
                                                          
                                                          <?php endif;  ?>
                                                          
                                                        </div>
                                                        <!-- END TAB CONTENT -->
                                                                                                                                                 
                                                     </div>    <!-- portlet-body -->
                                            
                                            	</div> <!--portlet-->
                                            </div> <!--col-md-5-->
                                        </div> <!--end row-->
                                        
                                        
										<div class="tabbable tabbable-custom tabbable-custom-profile">
											<ul class="nav nav-tabs">
												<li class="active"><a href="#tab_1_11" data-toggle="tab"><i class="fa fa-inbox"></i> Latest Resources</a></li>
												<li ><a href="#tab_1_22" data-toggle="tab"><i class="fa fa-flag"></i> Latest Corporate Posts</a></li>
                                                <li ><a href="#tab_1_33" data-toggle="tab"><i class="fa fa-download"></i> Latest Corporate Documents </a></li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane active" id="tab_1_11">
													<div class="portlet-body">
														<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
														
														    <?php
														    $vm_nodes = biz_portal_node_get_list(BP_Node::NODE_TYPE_RESOURCE, 0, '', '', $BP_Company->id, 7); 
														    ?>
															<ul class="feeds">
																<?php foreach ($vm_nodes->nodes as $node) :?>
																<?php $link = site_url('dashboard/view-company') . '?id=' . $BP_Company->id . '&res_id=' . $node->id ?>
																<li>
                                                                	<a href="<?php echo $link; ?>">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                            	<div class="cont-col1">
                                                                            		 <div style="max-width:30px; max-height:30px; border-radius:5px; -webkit-border-radius:5px;-moz-border-radius:5px;-o-border-radius:5px;">
                                                                            		 <?php $i=0; foreach ($node->attachments as $file) :?>
                                                                            		    <?php if ($file->is_image) : ?>
                                                                                            <img src="<?php echo biz_portal_get_file_url($file->id, 1,0,1); ?>" class="img-responsive" alt="" />
                                                                                        <?php endif; ?>
                                                                                     <?php $i++; if ($i > 0) break;?>
                                                                                     <?php endforeach; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc">
                                                                                       <?php echo $node->title; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date">
                                                                                <?php echo human_time_diff(strtotime($node->created), current_time('timestamp')); ?>
                                                                            </div>
                                                                        </div>
                                                                    </a>
																</li>
																
																<?php endforeach; ?>
                                                             
															</ul>
                                                            <!--<div class="clearfix"></div>-->
                                                            
                                                        
														</div> 
                                                        <!-- scroller  -->
                                                        <div class="scroller-footer">
                                                            <div class="pull-left">
                                                                <a href="<?php echo site_url('dashboard/profile/resources') . '?type=' . strtolower(BP_Node::NODE_TYPE_RESOURCE) ?>">View All Resources <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;
                                                            </div>
                                                        </div>
														
                                                        
                                                        
													</div>
												</div>
                                               <!--tab-pane-->
                                                
                                               <div class="tab-pane" id="tab_1_22">
													<div class="portlet-body">
														<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
														    <?php
														    $vm_nodes = biz_portal_node_get_list(BP_Node::NODE_TYPE_POST, 0, '', '', $BP_Company->id, 3); 
														    ?>
															<ul class="feeds">
																<?php foreach ($vm_nodes->nodes as $node) :?>
																<?php $link = site_url('dashboard/view-company') . '?id=' . $BP_Company->id . '&res_id=' . $node->id ?>																
																<li>
                                                                	<a href="<?php echo $link; ?>">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                            	<div class="cont-col1">
                                                                            		 <div style="max-width:30px; max-height:30px; border-radius:5px; -webkit-border-radius:5px;-moz-border-radius:5px;-o-border-radius:5px;">
                                                                            		 <?php $i=0; foreach ($node->attachments as $file) :?>
                                                                            		    <?php if ($file->is_image) : ?>
                                                                                            <img src="<?php echo biz_portal_get_file_url($file->id, 1,0,1); ?>" class="img-responsive" alt="" />
                                                                                        <?php endif; ?>
                                                                                     <?php $i++; if ($i > 0) break;?>
                                                                                     <?php endforeach; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc">
                                                                                       <?php echo $node->title; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date">
                                                                                <?php echo human_time_diff(strtotime($node->created), current_time('timestamp')); ?>
                                                                            </div>
                                                                        </div>
                                                                    </a>
																</li>
																<?php endforeach; ?>
                                                                                                                                
                                                                
															</ul>
														</div> <!-- scroller  -->
														<?php /* ?>
                                                        <div class="scroller-footer">
                                                            <div class="pull-right">
                                                                <a href="<?php echo site_url('dashboard/profile/resources') . '?type=' . strtolower(BP_Node::NODE_TYPE_POST) ?>">See All Posts <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;
                                                            </div>
                                                        </div>
                                                        <?php */ ?>
													</div>
												</div> 
                                                
                                                
												<!--tab-pane-->
												<div class="tab-pane" id="tab_1_33">
													<div class="tab-pane active" id="tab_1_1_1">
														<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
															<?php
														    $vm_nodes = biz_portal_node_get_list(BP_Node::NODE_TYPE_DOWNLOAD, 0, '', '', $BP_Company->id, 3); 
														    ?>
															<ul class="feeds">
																<?php foreach ($vm_nodes->nodes as $node) :?>
																<?php $link = site_url('dashboard/view-company') . '?id=' . $BP_Company->id . '&res_id=' . $node->id ?>																
																<li>
                                                                	<a href="<?php echo $link; ?>">
                                                                        <div class="col1">
                                                                            <div class="cont">
                                                                            	<div class="cont-col1">
                                                                            		 <div style="max-width:30px; max-height:30px; border-radius:5px; -webkit-border-radius:5px;-moz-border-radius:5px;-o-border-radius:5px;">
                                                                            		 <?php $i=0; foreach ($node->attachments as $file) :?>
                                                                            		    <?php if ($file->is_image) : ?>
                                                                                            <img src="<?php echo biz_portal_get_file_url($file->id, 1,0,1); ?>" class="img-responsive" alt="" />
                                                                                        <?php endif; ?>
                                                                                     <?php $i++; if ($i > 0) break;?>
                                                                                     <?php endforeach; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="cont-col2">
                                                                                    <div class="desc">
                                                                                       <?php echo $node->title; ?>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col2">
                                                                            <div class="date">
                                                                                <?php echo human_time_diff(strtotime($node->created), current_time('timestamp')); ?>
                                                                            </div>
                                                                        </div>
                                                                    </a>
																</li>
																<?php endforeach; ?>
                                                                                                                                
                                                                
															</ul>
														</div>
                                                        <?php /* ?>
                                                        <div class="scroller-footer">
                                                            <div class="pull-right">
                                                                <a href="<?php echo site_url('dashboard/profile/resources') . '?type=' . strtolower(BP_Node::NODE_TYPE_DOWNLOAD) ?>">See All Downloads <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;
                                                            </div>
                                                        </div>
                                                        <?php */ ?>
													</div>
												</div>
												<!--tab-pane-->
											</div>
										</div>
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
    
	<?php get_footer(); ?>