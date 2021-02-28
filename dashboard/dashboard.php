<?php
define('PRIVATE_SUBMENU', true, true);
define('PARENT', 'MYACCOUNT', true);

$BP_Repo_Companies = new BP_Repo_Companies($wpdb, biz_portal_get_table_prefix());

$vm_companies = $BP_Repo_Companies->search_companies(array('active' => 1), array('%d'), 20);
$countries = biz_portal_get_country_list();

?>

<?php get_header(); ?>

<!-- 
<?php wp_head(); ?>
-->
<style>
 .feeds a {color:black;}
 .page-body {margin-top:100px;} 
</style>

    <div class="page-container page-body dashboard-stats-i" style="background: #f9f9f9;">
		<!-- BEGIN CONTAINER -->   
		<div class="container">
		
    		<div class="item-size-1">
    		    <div class="dashboard-stat blue sme">
    				<div class="visual">
    					<i class="fa fa-shopping-cart"></i>
    				</div>
    				<div class="details">
    					<div class="number">
    						<?php echo biz_portal_count_company(BP_MemberType::TYPE_SME); ?>
    					</div>
    					<div class="desc">                           
    						SMEs
    					</div>
    				</div>
    				<a class="more" href="<?php echo site_url('dashboard/list/sme'); ?>">
    				View more <i class="m-icon-swapright m-icon-white"></i>
    				</a>                 
    			</div>
    		</div>
    		
    		<div class="item-size-1">
    		    <div class="dashboard-stat green">
        			<div class="visual">
    					<i class="fa fa-glass"></i>
    				</div>
    				<div class="details">
    					<div class="number"><?php echo biz_portal_count_company('', BP_BizNeedType::PARTNER); ?></div>
    					<div class="desc">Business Partners</div>
    				</div>
    				<a class="more" href="<?php echo site_url('dashboard/list/business-partners'); ?>">
    				View more <i class="m-icon-swapright m-icon-white"></i>
    				</a>                 
    			</div>
    		</div>
    		
    		<div class="item-size-1">
    		    <div class="dashboard-stat purple">
    				<div class="visual">
    					<i class="fa fa-folder-open"></i>
    				</div>
    				<div class="details">
    					<div class="number"><?php echo biz_portal_count_company('', BP_BizNeedType::PROVIDE_SERVICE); ?></div>
    					<div class="desc">Service Providers</div>
    				</div>
    				<a class="more" href="<?php echo site_url('dashboard/list/service-providers'); ?>">
    				View more <i class="m-icon-swapright m-icon-white"></i>
    				</a>                 
    			</div>
    		</div>
    		
    		<div class="item-size-1">
    		    <div class="dashboard-stat yellow investors">
    				<div class="visual">
    					<i class="fa fa-money"></i>
    				</div>
    				<div class="details">
    					<div class="number"><?php echo biz_portal_count_company('', BP_BizNeedType::PROVIDE_INVEST); ?></div>
    					<div class="desc">Investors</div>
    				</div>
    				<a class="more" href="<?php echo site_url('dashboard/list/investors'); ?>">
    				View more <i class="m-icon-swapright m-icon-white"></i>
    				</a>                 
    			</div>
    		</div>
    		
    		<div class="item-size-2">
    		    <div class="dashboard-stat pink">
    				<div class="visual">
    					<i class="fa fa-money"></i>
    				</div>
    				<div class="details">
    					<div class="number"><?php echo biz_portal_count_company(BP_MemberType::TYPE_NGO); ?></div>
    					<div class="desc">NonProfit Organizations</div>
    				</div>
    				<a class="more" href="<?php echo site_url('dashboard/list/nonprofit-organizations'); ?>">
    				View more <i class="m-icon-swapright m-icon-white"></i>
    				</a>                 
    			</div>
    		</div>
		
		</div>
	</div>
 <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body" style="margin-top:50px;">
	
       

		<!-- BEGIN CONTAINER -->   
		<div class="container min-hight margin-bottom-40">
			<div class="row margin-bottom-40">
				
				<div class="col-md-12">
                    <!-- BEGIN TAB CONTENT -->
                    <div class="tab-content">
                      
                                           
                      <!-- START TAB 2 -->
                      <div id="tab_2" class="tab-pane  active">
                         <div class="container">
                         		<div class="col-md-12 margin-bottom-30">
                         		<?php
							        if (BP_FlashMessage::HasMessages()) {
										biz_portal_get_messages();
									}
							        ?>
                                  <h3>DASHBOARD</h3>
                                  
							        
							        <?php 
                                    $edit_class = ''; $edit_location='';
                                    if (current_user_can('manage_sites')) {
                                        $edit_class = 'admin_udpate_spot';
                                        $edit_location = 'options';
                                    }
                                    ?>
                                  <p><span data-location="<?php echo $edit_location; ?>" data-id="content_page_dashboard_header_1" 
                        class="<?php echo $edit_class; ?>"><?php echo get_option('content_page_dashboard_header_1', 'content_page_dashboard_header_1')?></span>                                  
                                  </p>
                                </div>
                         
                         <?php /* ?>
                         <div class="row">
                         		<div class="col-md-6"> <!-- Number of Companies  -->
                                
                                	<!-- BEGIN PORTLET-->
                                    <div class="portlet solid bordered light-grey">
                                        <div class="portlet-title">
                                            <div class="caption"><i class="fa fa-bar-chart-o"></i> Number of Companies</div>
                                           
                                        </div>
                                        <div class="portlet-body">
                                            <div id="site_statistics_loading">
                                                <img src="assets/img/loading.gif" alt="loading"/>
                                            </div>
                                            <div id="site_statistics_content" class="display-none">
                                                <div id="site_statistics" class="chart"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END PORTLET-->
                                    
                                </div>	<!-- Number of Companies  -->
                                
                                <div class="col-md-6"><!-- Map (public / private traffic)  -->
                                		<!-- BEGIN MARKERS PORTLET-->
                                        <div class="portlet">
                                            <div class="portlet-title">
                                            <div class="caption"><i class="fa fa-bar-chart-o"></i> Public / Private Traffic</div>
                                           
                                        </div>
                                            <div class="portlet-body">
                                                <div id="gmap_marker" class="gmaps"></div>
                                            </div>
                                        </div>
                                        <!-- END MARKERS PORTLET-->
                                </div>	<!-- Map (public / private traffic)  -->
                          </div>
                          */ ?>
                         </div>
                      </div>
                      <!-- END TAB 2 -->
                      
                      
                    </div>
                    <!-- END TAB CONTENT -->
				</div>            
			</div> <!-- ROW -->
            
            <div class="clearfix"></div>
            
            <div class="row"> <!-- row  -->
            		<!-- Opportunity by Category  -->
                    
				
                    
                    <!-- Uploaded Resources  -->
                    
				<div class="col-md-6 col-sm-6">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-cloud-upload"></i> Resources</div>							
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
							<?php
							$vm_nodes = biz_portal_node_get_list(BP_Node::NODE_TYPE_RESOURCE, 0, '', '', 0, 20); 
							?>
								<ul class="feeds">
								<?php foreach ($vm_nodes->nodes as $node ) :?>
								<?php
								$link_resource = '#';
								if ($node->company_id == 1) {
								    $link_resource = site_url('resources') . '/#' . $node->id . ',1';
								} else if ($node->company_id > 1) {
								    $link_resource = site_url('dashboard/view-company') . '?id=' . $node->company_id . '&res_id=' . $node->id;
								}
								?>
									<li>
										<div class="col1">
											<div class="cont">
												<div class="cont-col1">
													<div class="label label-sm label-info">                        
														<i class="fa fa-bullhorn"></i>
													</div>
												</div>
												<div class="cont-col2">
													<div class="desc">
														<a href="<?php echo $link_resource ?>"><?php echo $node->title; ?></a>
													</div>
												</div>
											</div>
										</div>
										<div class="col2">
											<div class="date">
												<?php echo human_time_diff(strtotime($node->created), time()); ?>
											</div>
										</div>
									</li>
								<?php endforeach; ?>									
								</ul>
							</div>
							<div class="scroller-footer">
								<div class="pull-left">
									<a href="<?php echo site_url('resources') ?>">See All Resources <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="col-md-6 col-sm-6 dashboard_portlet">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption"><i class="fa  fa-flag"></i> Opportunities</div>
							
						</div>
						<div class="portlet-body">
							<div class="scroller" style="height: 300px;" data-always-visible="1" data-rail-visible="0">
								<ul class="feeds">
								<?php foreach ($vm_companies->companies as $company ) :?>
								<?php /** @var BP_Company $company */ ?>
									<li>
										<div class="col1">
											<div class="cont">
												<div class="cont-col1">
													<div class="label label-sm label-info">                        
														<i class="fa fa-check"></i>
													</div>
												</div>
												<div class="cont-col2">
													<div class="desc">
													    <?php $country = biz_portal_select_country($company->country_of_incorporate, $countries); ?>
														<a href="<?php echo site_url('dashboard/view-company') . '?id=' . $company->id; ?>"><?php echo $company->company_name; ?></a>
														 (<?php echo $country['country_name'] ?>)<br />
														<span class="label label-sm label-warning ">
														<?php
														switch ($company->member_type_id) {
														    case BP_MemberType::TYPE_SME:
														        echo 'SME';
														        break;
														    case BP_MemberType::TYPE_NGO:
														        echo 'NGO';
														        break;
														    case BP_MemberType::TYPE_INTL:
														        $vals = '';
														        if ($company->bool_biz_give_service == 1) $vals .= 'Service Provider, ';
														        if ($company->bool_biz_give_invest == 1) $vals .= 'Investor, ';
														        if ($company->bool_biz_need_partner_in == 1) $vals .= 'Business Partner, ';
														        $vals = substr($vals, 0, -2);
														        echo $vals;
														        break;
														} 
														?>
														<?php /*<i class="fa fa-share"></i>*/?>
														</span>
													</div>
												</div>
											</div>
										</div>
										<div class="col2">
											<div class="date">
												<?php echo human_time_diff(strtotime($company->last_update)) ?>
											</div>
										</div>
									</li>
								<?php endforeach; ?>
								</ul>
							</div>
							<div class="scroller-footer">
								<div class="pull-left">
									<!--a href="<?php echo site_url('dashboard/list/sme'); ?>">Goto list <i class="m-icon-swapright m-icon-gray"></i></a--> &nbsp;
								</div>
							</div>
						</div>
					</div>
				</div>
                    
            </div> <!-- row Opportunity and Uploaded -->
            
            <div class="clearfix"></div>
            
            
            
		</div>
		<!-- END CONTAINER -->

	</div>
	<div class="page-container page-body page-dashboard-grey" style="background: #f9f9f9;margin-top:60px;">
		<!-- BEGIN CONTAINER -->   
		<div class="container min-hight">
		
		    <div class="row margin-bottom-30"> <!-- row  -->
            	<div class="container">
                	<div class="col-md-12 margin-top-50">
                		<h3>Latest News</h3>
                    </div>
            	</div>
            </div> <!-- row  -->
            <div class="clearfix"></div>
            
			<div class="row margin-bottom-40">
            	<div class="col-md-6 col-sm-6">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-globe"></i> Company Posts</div>
						</div>
						<div class="portlet-body">
                        	<div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible="0">
                        	<?php  $vm_nodes = biz_portal_node_get_list(BP_Node::NODE_TYPE_POST, 0, '', '', 0, 20); ?>
											<ul class="feeds">                                           
											<?php foreach ($vm_nodes->nodes as $node ) :?>
											<?php
											$link = '#'; 
											if ($node->company_id > 1) {
											    $link = site_url('dashboard/view-company') . '?id=' . $node->company_id . '&pst_id=' . $node->id;
											}
											?>
                                                <li>
													<div class="col1">
														<div class="cont">
															<div class="cont-col1">
																<div class="label label-sm label-success">                        
																	<i class="fa fa-bell-o"></i>
																</div>
															</div>
															<div class="cont-col2">
																<div class="desc">
																	<a href="<?php echo $link; ?>"><?php echo $node->title; ?></a><br />
																	<span class="label label-warning">posted by <?php echo $node->company->company_name; ?></span>
																</div>
															</div>
														</div>
													</div>
													<div class="col2">
														<div class="date">			
															<?php echo human_time_diff(strtotime($node->created), strtotime(date("Y-m-d H:i:s"))); ?>
														</div>
													</div>
												</li>
                                               <?php endforeach; ?>                                               
											</ul>
										</div>
                                       <div class="scroller-footer">
                                            <div class="pull-left">
                                            <?php /* if (count($vm_nodes->nodes) > 0 ) :?>
                                                <a href="#">See All Company Posts <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;
                                            <?php endif;*/?>
                                            </div>
                                        </div> 
                        </div> <!-- portlet-body  -->
                    </div> <!-- portlet  -->
                </div>   <!-- col-md-6 col-sm-6  -->
                
                <div class="col-md-6 col-sm-6 dashboard_portlet">
					<div class="portlet">
						<div class="portlet-title">
							<div class="caption"><i class="fa fa-tags"></i> Newsroom Posts</div>
						</div>
						<div class="portlet-body">
                        
                        	<div class="scroller" style="height: 290px;" data-always-visible="1" data-rail-visible="0">
											<ul class="feeds">
                                            <?php  $scoop_news = scoop_it_get_nodes(0,50); //print_r($scoop_news); ?>
                                            
                                            <?php  
												if (!empty($scoop_news)):
													
													foreach($scoop_news as $news):  
                                                    	$image = "";
														
														if (!empty($news->node_imageUrl)) $image = $news->node_imageUrl;
														else if (!empty($news->node_mediumImageUrl)) $image = $news->node_mediumImageUrl;
														else if (!empty($news->node_largeImageUrl)) $image = $news->node_largeImageUrl;
														else $image = get_template_directory_uri() . "/images/sky.jpg";
														
											?>
												<li>
													<a href="<?php echo $news->node_scoopUrl; ?>" target="_blank">
														<div class="col1">
															<div class="cont">
																<div class="cont-col1">
																	<div class="label label-sm">                        
																		<img src="<?php echo $image;  ?>"  alt="<?php echo 'Image for - ' . $news->node_title;  ?>" class="dashboard_icon">
																	</div>
																</div>
																<div class="cont-col2">
																	<div class="desc">
																		<?php echo $news->node_title;   ?> 
																	</div>
																</div>
															</div>
														</div>
														<div class="col2">
															<div class="date">
																<?php  
																echo human_time_diff(strtotime($news->topic_updated), time());
																 ?>
															</div>
														</div>
													</a>
												</li>
                                                	<?php endforeach;  ?>  
                                                
                                              <?php endif;  ?>  
                                                                                               
											</ul>
										</div>
                                       <div class="scroller-footer">
                                            <div class="pull-left">
                                                <a href="<?php echo site_url('newsroom/') ?>">View All Newsroom Posts <i class="m-icon-swapright m-icon-gray"></i></a> &nbsp;
                                            </div>
                                        </div> 
                        
                        </div> <!-- portlet-body  -->
                    </div> <!-- portlet  -->
                </div>    <!-- col-md-6 col-sm-6  -->     
            
		    </div>
		    <div class="row margin-bottom-30 hidden">
            	<h3>Commulative Traffic on Platform (Google Analytics)</h3>
            </div>
				
		</div>
		
    </div>
    <!-- END PAGE CONTAINER -->  

<?php get_footer(); ?>