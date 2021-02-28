<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8" />
        <title>Myanmar SME Link</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />

        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="<?php echo get_template_directory_uri(); ?>/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo get_template_directory_uri(); ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!-- END GLOBAL MANDATORY STYLES -->

        <!--  ==============  -->
        <?php wp_head(); ?>
        <!--  ==============  -->

        <!-- BEGIN PAGE LEVEL PLUGIN STYLES -->
        <link href="<?php echo get_template_directory_uri(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/plugins/revolution_slider/css/rs-style.css" media="screen">
        <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/plugins/revolution_slider/rs-plugin/css/settings.css" media="screen">
        <link href="<?php echo get_template_directory_uri(); ?>/assets/plugins/bxslider/jquery.bxslider.css" rel="stylesheet" />
        <!-- END PAGE LEVEL PLUGIN STYLES -->

        <!-- BEGIN THEME STYLES -->
        <link href="<?php echo get_template_directory_uri(); ?>/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>        
        <link href="<?php echo get_template_directory_uri(); ?>/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo get_template_directory_uri(); ?>/assets/css/themes/orange.css" rel="stylesheet" type="text/css" id="style_color"/>
        <link href="<?php echo get_template_directory_uri(); ?>/assets/css/custom.css" rel="stylesheet" type="text/css"/>
        <!-- END THEME STYLES -->

        <link rel="shortcut icon" href="favicon.ico" />
        <script type="text/javascript">
            var global_enable_overlay = false;
            var global_old_login_redirect_url = '';
        </script>
    </head>
    <!-- END HEAD -->

    <!-- BEGIN BODY -->
    <body <?php body_class(); ?>>


        <!-- BEGIN HEADER -->
        <div class="header navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                    <button class="navbar-toggle btn navbar-btn" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- END RESPONSIVE MENU TOGGLER -->
                    <!-- BEGIN LOGO (you can use logo image instead of text)-->
                    <a class="navbar-brand logo-v1" href="<?php echo home_url() ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/logo.jpg" id="logoimg" alt="">
                    </a>
                    <!-- END LOGO -->
                </div>

                <!-- BEGIN TOP NAVIGATION MENU -->                        
                <div class="navbar-collapse collapse">                            
                    <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav navbar-nav')); ?>
                </div>
                <!-- BEGIN TOP NAVIGATION MENU -->
            </div>
        </div>
        <!-- END HEADER -->
        <!-- BEGIN PAGE CONTAINER -->
        <div class="page-container">
            <?php
            //$bussiness_types = get_categories(array('taxonomy' => 'sme-post-type', 'hide_empty' => 0, 'order' => 'DESC'));
            //$bussiness_types = get_terms('sme-post-type', array('hide_empty' => 0, 'order' => 'DESC'));
            $bussiness_types = array(
                array('slug' => 'sme', 'name' => 'SME'),
                array('slug' => 'investment', 'name' => 'Investment'),
                array('slug' => 'partnership', 'name' => 'Partnership'),
                array('slug' => 'sp', 'name' => 'Service Provider'),
            );
            ?>

            <!-- Submenu -->
            <?php if (is_user_logged_in()) : ?>
                <?php $sme_page_link = get_permalink(266); ?>
                
                    <div class="container">
                        <div class="col-md-12 col-sm-12">
                            <div class="submenu">
                                <ul class="nav navbar-nav ">
                                    <?php foreach ($bussiness_types as $term) : ?>
                                        <?php $class = ""; ?>
                                        <?php if ($term['slug'] == $_GET['sme-type']) $class = 'active'; ?>
                                        <li class="<?php echo $class; ?>">
                                            <?php $login_class = is_user_logged_in() ? 'logged-in' : 'logged-out'; ?>
                                            <a class="<?php echo $login_class; ?>" href="<?php echo $sme_page_link . '?sme-type=' . $term['slug']; ?>"><?php echo $term['name'] ?></a>
                                        </li>    
                                    <?php endforeach; ?>
                                </ul>
                            </div> 
                        </div>
                    </div>
               
            <?php endif; ?>
            <?php
            $args = array(
                'echo' => false,
                'redirect' => site_url($_SERVER['REQUEST_URI']),
                'form_id' => 'loginform',
                'label_username' => __('Username'),
                'label_password' => __('Password'),
                'label_remember' => __('Remember Me'),
                'label_log_in' => __('Log In'),
                'id_username' => 'user_login',
                'id_password' => 'user_pass',
                'id_remember' => 'rememberme',
                'id_submit' => 'wp-submit',
                'remember' => true,
                'value_username' => NULL,
                'value_remember' => false
            );

            $loginoutlink = '<div class="login-menu-linker"><div class="search-box">
                         <div class="pull-right"><a id="btn-close" href="#"><i class="fa fa-times"></i> </a></div>
                         <h3>Login Form</h3>                         
                         <p>
                         Please fill up the form to login to control panel.
                         </p>' . wp_login_form($args) . '</div></div>';

            echo $loginoutlink;
            ?>
            <!-- Submenu -->
