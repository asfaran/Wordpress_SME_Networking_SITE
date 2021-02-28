
<?php 
if (defined('DIRECTORY') && DIRECTORY === 'SME') {
    $company_industries = biz_portal_get_industries_list(true, 2); 
    $industries_other = biz_portal_get_industries_list();
    $company_industries = array_merge($industries_other, $company_industries);
}
else 
    $company_industries = biz_portal_get_industries_list();

?>

<!-- Modal (Advertise With Us) -->
<div class="modal fade"
	id="directory_window" tabindex="-1" role="dialog"
	aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content directory_body">
			<div class="modal-header" id="modal_header">
        		<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4><?php echo isset($dir_title) ? $dir_title : 'MYANMAR DIRECTORY'  ?></h4>
      		</div>
            
            
            <div class="row" >
				<div class="col-md-4">
					<div class="col-md-12" style="border-bottom:1px #efefef solid;height:35px;" id="modal_directory_desktop">
						<div class="margin-top-20 " style="padding-left: 10px;" class="" >
						    
						    <!--  -->
						    <ul class="nav navbar-nav">
						        <li>
						    <!--  -->
						    
        							<div class="dropdown-toggle" data-toggle="dropdown"
        								data-close-others="true" >
        								<span class="title">Industry</span>								
        							</div>
        							<div class="dropdown-menu directory"
        								style="padding: 0 0 10px 10px; margin-left: 20px;">
        								<div class="filter_industries">
        									<h4>Industry</h4>
        									<?php $columns = 4;?>
        									<?php $opened = false;?>
        									<?php $i = 1;?>
        									<?php foreach ($company_industries as $industry) :?>
        									<?php if (empty($industry['ind_name'])) continue; ?>
        									<?php if ($i%$columns == 1) :?>
        									        <div class="row">
        									     <?php $opened = true;?>
        									<?php endif; ?>
        									    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        									        <div class="form-group">
        									            <div class="checkbox-list">
        									                <label> <input type="checkbox" name="company_industries[]" value="<?php echo $industry['id']?>" 
        									                    class="chk_industries"/> <?php echo $industry['ind_name']?>
            												</label>
        									            </div>
        									        </div>
        									    </div>									
        									<?php if ($i%$columns == 0) :?>
        									    </div>
        									    <?php $opened = false;?>
        									<?php endif; ?>
        									<?php $i++;?>								
        									<?php endforeach; ?>
        									<?php if ($opened) :?>
        									    </div>
        									    <?php $opened = false;?>
        									<?php endif;?>
        									
        									<div class="form-actions">
        										<button type="button" class="btn yellow btn_filter_directory">
        											Apply Filters <i class="fa fa-angle-double-down"></i>
        										</button>
        									</div>
        
        								</div>  
							        </div>
							        
                            <!--  -->	
                                </li>
                                <li>
                                    <?php $alpha = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'); ?>
                                    <div class="dropdown-toggle" data-toggle="dropdown"
        								data-close-others="true" >
        								<span class="title">A-Z</span>								
        							</div>
        							<div class="dropdown-menu directory"
        								style="padding: 0 0 10px 10px; margin-left: 20px;">
        								<div class="alpha-box-wrapper">
        								    <?php 
        								        $column = 6;
        								        $opened = false;
        								        $i = 1;
        								        echo '<ul>';
        								        foreach ($alpha as $a) {
        								            echo '<li class="alpha-box"><a href="" rel="' . $a . '">';
        								            echo $a;
        								            echo '</a></li>';
        								            $i++;
        								        }
        								        echo '<ul>';
        								    ?>        								    
        								    <div class="clearfix"></div>
        								    <hr />
        								    <ul>
        								        <?php for ($i=1;$i<10; $i++) :?>
        								        <li class="alpha-box"><a href="" rel="<?php echo $i; ?>"><?php echo $i; ?></a></li>
        								        <?php endfor; ?>
        								    </ul>
        								</div>
        							</div>
                                </li>
                            </ul>						        
					        <!--  -->
					        <div class="clearfix"></div>
						</div>

					</div>
					<!-- col-md-12 -->

					<div class="col-md-12">
						<p class="text-small margin-top-20" style="padding-left: 10px;">
							Myanmar directory contains a large database of Myanmar companies spread through different industries types. You can narrow your search by using the filters above,once selected you can clear them by pressing below on Clear Search button.</p>
					</div>
					<div clas="col-md-12">
					        <button type="button" class="btn btn_filter_directory_clear pull-right hidden">
								Clear Search</i>
						    </button>
					</div>
					<!-- col-md-12 -->
                    
                     

				</div>
				<!-- col-md-4 -->
               
                
                

				<div class="col-md-8 directory-col-divider" style="">
                
                	<div class="row mobile_only" id="directory_menu_mobile"> <!-- row directory_menu_mobile   -->
               			<ul class="nav navbar-nav" >
						        <li class="directory_menu_mobile">
						    <!--  -->
						    
        							<div class="dropdown-toggle" data-toggle="dropdown"
        								data-close-others="true" >
        								<span class="title">Industry</span>								
        							</div>
        							<div class="dropdown-menu directory "
        								style="padding: 0 0 10px 10px; margin:0 -60px; width:300%">
        								<div class="filter_industries">
        									<h4>Industry</h4>
        									<?php $columns = 4;?>
        									<?php $opened = false;?>
        									<?php $i = 1;?>
        									<?php foreach ($company_industries as $industry) :?>
        									<?php if (empty($industry['ind_name'])) continue; ?>
        									<?php if ($i%$columns == 1) :?>
        									        <div class="row">
        									     <?php $opened = true;?>
        									<?php endif; ?>
        									    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
        									        <div class="form-group">
        									            <div class="checkbox-list">
        									                <label> <input type="checkbox" name="company_industries[]" value="<?php echo $industry['id']?>" 
        									                    class="chk_industries"/> <?php echo $industry['ind_name']?>
            												</label>
        									            </div>
        									        </div>
        									    </div>									
        									<?php if ($i%$columns == 0) :?>
        									    </div>
        									    <?php $opened = false;?>
        									<?php endif; ?>
        									<?php $i++;?>								
        									<?php endforeach; ?>
        									<?php if ($opened) :?>
        									    </div>
        									    <?php $opened = false;?>
        									<?php endif;?>
        									
        									<div class="form-actions">
        										<button type="button" class="btn yellow btn_filter_directory">
        											Apply Filters <i class="fa fa-angle-double-down"></i>
        										</button>
        									</div>
        
        								</div>  
							        </div>
							        
                            <!--  -->	
                                </li>
                                <li class="directory_menu_mobile">
                                    <?php $alpha = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z'); ?>
                                    <div class="dropdown-toggle " data-toggle="dropdown"
        								data-close-others="true" >
        								<span class="title">A-Z</span>								
        							</div>
        							<div class="dropdown-menu directory"
        								style="padding: 0 0 10px 10px;margin:0 -180px; width:700%">
        								<div class="alpha-box-wrapper">
        								    <?php 
        								        $column = 6;
        								        $opened = false;
        								        $i = 1;
        								        echo '<ul>';
        								        foreach ($alpha as $a) {
        								            echo '<li class="alpha-box"><a href="" rel="' . $a . '">';
        								            echo $a;
        								            echo '</a></li>';
        								            $i++;
        								        }
        								        echo '<ul>';
        								    ?>        								    
        								    <div class="clearfix"></div>
        								    <hr />
        								    <ul>
        								        <?php for ($i=1;$i<10; $i++) :?>
        								        <li class="alpha-box"><a href="" rel="<?php echo $i; ?>"><?php echo $i; ?></a></li>
        								        <?php endfor; ?>
        								    </ul>
        								</div>
        							</div>
                                </li>
                            </ul>						        
					        <!--  -->
					        <div class="clearfix"></div>
                	</div> <!-- row directory_menu_mobile   -->
                
					<div class="row">
						<div class="text-center margin-top-20 desktop_only" style="height: 35px;border-bottom: 1px #efefef solid; margin-right: 15px">
							<h3 class="header_dialog_i"><?php echo isset($dir_title) ? $dir_title : 'MYANMAR DIRECTORY'  ?></h3>							
						</div>

						<!-- uploaded resources  -->
						<div class="container">


							<!-- <div id="scroller_window" class="scroller" style="height: 400px;"
								data-always-visible="1" data-rail-visible="0">-->
							<div id="scroller_window" class="" style="height: 400px;overflow-x:hidden;overflow-y:auto;margin-right:10px;">
								<?php //include __DIR__ . "/filter_directory.php"; ?>
							</div>

						</div>
						<!-- uploaded resources  -->
					</div>
				</div>
                
			</div>  <!-- modal-content  -->
            <!--  desktop  -->
            
            
			<div class="modal-footer">
				<div class="col-md-6 modal_footer_logo">
					<img
						src="<?php echo get_template_directory_uri(); ?>/images/modal_logo.jpg"
						id="logoimg" alt="MyanmarSMELink" >
				</div>
				<div class="col-md-6 text-small">
					&copy;
					<?php echo date('Y'); ?>
					<span class="modal_footer_name"><?php echo MAIN_COMPANY_NAME; ?>.</span> All Rights Reserved
				</div>
			</div>

		</div>
	</div>

	<!-- Modal (Advertise With Us) -->