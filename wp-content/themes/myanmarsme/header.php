<?php
date_default_timezone_set('Asia/Dubai'); 

global $wpdb;
$sql = "SELECT * FROM " . _biz_portal_get_table_name('node_category');
$node_categories = $wpdb->get_results($sql);

$is_user_logged_in = is_user_logged_in();

$submenu = SUBMENU_ITEM;

if(defined('PROFILE_PAGE') && PROFILE_PAGE) {    
    wp_enqueue_style('pages_profile', get_template_directory_uri() . '/assets/css/pages/profile.css');
}

if((defined('MESSAGES_PAGE') && MESSAGES_PAGE)) {
    wp_enqueue_style('pages_inbox', get_template_directory_uri() . '/assets/css/pages/inbox.css');
}

if(defined('SHOW_NEWS_TOPICS') && SHOW_NEWS_TOPICS) {
    wp_enqueue_style('default', get_template_directory_uri() . '/includes/default.css', array('bootstrap', 'style-responsive_css'));
    wp_enqueue_style('component', get_template_directory_uri() . '/includes/component.css', array('bootstrap', 'style-responsive_css'));
    wp_enqueue_script('modernizr', get_template_directory_uri() . '/includes/modernizr.js', array('jquery'));
}

if(defined('FORM_SME_WIZARD') && FORM_SME_WIZARD){
    wp_enqueue_style('select2_metro', get_template_directory_uri() . '/assets/plugins/select2/select2_metro.css');
    wp_enqueue_style('assets_css_plugins_css', get_template_directory_uri() . '/assets/css/plugins.css');   
	 
	
}

if(defined('PRIVATE_SUBMENU') && PRIVATE_SUBMENU) {    
    wp_enqueue_script('jquery.flot.js', get_template_directory_uri() . '/assets/plugins/flot/jquery.flot.js', array('jquery'));
    wp_enqueue_script('jquery.flot.resize.js', get_template_directory_uri() . '/assets/plugins/flot/jquery.flot.resize.js', array('jquery'));
    wp_enqueue_script('maps.google.com', 'http://maps.google.com/maps/api/js?sensor=false');
    wp_enqueue_script('maps-google.js', get_template_directory_uri() . '/assets/scripts/maps-google.js', array('maps.google.com'));
}

$main_image_results =get_option('dashboard_general_image');

?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <title><?php wp_title( '|', true, 'right' ); bloginfo('name') ?></title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="<?php bloginfo('description'); ?>" name="description" />
    <meta name="p:domain_verify" content="7c40ba9059337de56f9202115602d3bd"/>
    <meta content="" name="author" />
    
   
   
   <script>
   		var template_directory_uri = '<?php echo get_template_directory_uri(); ?>';
   		var is_user_logged_in = <?php echo $is_user_logged_in ? 'true' : 'false'; ?>;
   		var site_url = "<?php echo site_url(); ?>";
   		var directory = "<?php echo $var = defined('DIRECTORY') ? DIRECTORY : ''; ?>";
   </script>
      
    <!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/plugins/respond.min.js"></script>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/plugins/excanvas.min.js"></script> 
	<![endif]-->
    <?php wp_head(); ?>
    <?php if ($is_user_logged_in) : ?>
    <style>
        .page-body {
            margin-top: 118px;
        }
    </style>
    <?php  endif; ?>
    <script>
    var $ = jQuery;
    </script>

   <link rel="shortcut icon" href="<?php echo $main_image_results['img_favicon']; ?>" />
    
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="<?php echo $val = $is_user_logged_in ? 'member' : 'public'; ?>">
	 

    <!-- BEGIN HEADER -->
     <div class="header navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
                <?php //if (!($is_user_logged_in) && !(SUBMENU_ITEM == 'newsroom')) : ?>

                <button class="navbar-toggle btn navbar-btn" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
                </button>

                <?php ///endif; ?>
				<!-- END RESPONSIVE MENU TOGGLER -->

				<!-- BEGIN LOGO (you can use logo image instead of text)-->

				<a class="logo-v1 mobile_only" href="<?php echo home_url() ?>">
					<img src="<?php echo $main_image_results['img_logo']; ?>" id="logoimg"  alt="<?php echo $main_image_results['logo_title']; ?>" >
				</a>

				<!-- END LOGO -->
			</div>


			<!-- BEGIN TOP NAVIGATION MENU -->

			<div class="navbar-collapse collapse " >
				<div class="nav-container">
				<a class="logo-v1 desktop_only" href="<?php echo home_url() ?>">
					<img src="<?php echo $main_image_results['img_logo']; ?>" id="logoimg"  alt="<?php echo $main_image_results['logo_title']; ?>" >
				</a>


				<?php if ($is_user_logged_in) : ?>
                 		<?php wp_nav_menu(array('menu' => 'Menu 1', 'menu_class' => 'nav navbar-nav ')); ?>
                <?php else : ?>
                    	<?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav navbar-nav ')); ?>
                <?php endif; ?> 


            <div class="collapse_buttons">  <!----  collapse button   ----->
            	<ul class="nav navbar-nav ">

					<?php if ($is_user_logged_in) : ?>

                        <li id="menu_opportunities">
                        	<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-other="false">
                            	Opportunities <span class="pull-right mobile_only"><small><i class="fa fa-plus"></i></small></span>
                            </a>

                            <ul class="dropdown-menu">

                                <li <?php echo ($submenu == 'sme') ? "class='active'":""; ?>><a href="/dashboard/list/sme">SMEs</a></li>
                                <li <?php echo ($submenu == 'business_partners') ? "class='active'":""; ?>><a href="/dashboard/list/business-partners">BUSINESS PARTNERS</a></li>
                                <li <?php echo ($submenu == 'service_providers') ? "class='active'":""; ?>><a href="/dashboard/list/service-providers">SERVICE PROVIDERS</a></li>
                                <li <?php echo ($submenu == 'investors') ? "class='active'":""; ?>><a href="/dashboard/list/investors">INVESTORS</a></li>
                                <li <?php echo ($submenu == 'nonprofit') ? "class='active'":""; ?>><a href="/dashboard/list/nonprofit-organizations">NONPROFIT ORGANIZATIONS</a></li>
                            </ul>
                        </li>

                   <?php endif;  ?>


				   <?php if (($is_user_logged_in)) :   ?>

                    	<?php $category = filter_input(INPUT_GET,'c',FILTER_VALIDATE_INT);  ?>

                   <?php

				   	    global $resources_submenu;
				   		$resources_submenu = "<ul class=\"dropdown-menu\">";
						$x = 1;
						$resources_submenu .= "<li><a href=\"". site_url() ."/resources/\">All</a></li>";
						foreach ($node_categories as $cat) :
							$active = ((isset($category)) && ($category == $x)) ? " class=\"active\" ":"";
							$resources_submenu .= "<li {$active}><a href=\"". site_url() . "/resources/" ."?c=". $cat->id ."\"> ". $cat->category_name ." </a></li>";
							$x++;
						endforeach;

						$resources_submenu .= "</ul>";

						//echo $resources_submenu;

				   ?>
                   <?php endif;  ?>
            	</ul>  

            <script>
				resources_submenu = '<?php echo $resources_submenu; ?>';
				newsroom_menu = '<?php echo get_newsroom_menu($category); ?>';
			</script>

            </div> <!--  <div class="collapse_buttons" >  -->
			</div>   <!--  <div class="nav-container" >  -->
		</div> <!--  <div class="navbar-collapse collapse" >  -->

			<!-- BEGIN TOP NAVIGATION MENU -->
       </div> <!--  container  -->
            
           <?php if ($is_user_logged_in) : ?>
            	 <!-- BEGIN BREADCRUMBS -->  
                <div class="row " >
                    <div class="breadcrumbs "> 
                        <div class="col-md-12 col-sm-12 ">
                       
                            <div class="submenu ">
                               <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                                <!--
                                <button class="navbar-toggle btn navbar-btn" data-toggle="collapse" data-target="#submenu" onClick="$('#submenu').toggle();">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                -->
                                <ul class="submenu_list" id="submenu">
                                    <li <?php echo ($submenu == 'sme') ? "class='active'":""; ?>><a href="/dashboard/list/sme">SMEs</a></li>
                                    <li <?php echo ($submenu == 'business_partners') ? "class='active'":""; ?>><a href="/dashboard/list/business-partners">BUSINESS PARTNERS</a></li>
                                    <li <?php echo ($submenu == 'service_providers') ? "class='active'":""; ?>><a href="/dashboard/list/service-providers">SERVICE PROVIDERS</a></li>
                                    <li <?php echo ($submenu == 'investors') ? "class='active'":""; ?>><a href="/dashboard/list/investors">INVESTORS</a></li>
                                    <li <?php echo ($submenu == 'nonprofit') ? "class='active'":""; ?>><a href="/dashboard/list/nonprofit-organizations">NONPROFIT ORGANIZATIONS</a></li>
                                </ul>
                            </div>  
                        </div>
                    </div>
                </div>
            <!-- END BREADCRUMBS -->
           <?php endif; ?> 
           
          
		
    </div>
    <!-- END HEADER -->