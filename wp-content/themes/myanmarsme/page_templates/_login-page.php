<?php
/*
  Template Name: Login_Full Page
 */

// Redirect to https login if forced to use SSL
if ( force_ssl_admin() && ! is_ssl() ) {
    if ( 0 === strpos($_SERVER['REQUEST_URI'], 'http') ) {
        wp_redirect( set_url_scheme( $_SERVER['REQUEST_URI'], 'https' ) );
        exit();
    } else {
        wp_redirect( 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
        exit();
    }
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'login';
$errors = new WP_Error();

if ( isset($_GET['key']) )
    $action = 'resetpass';

// validate action so as to default to the login screen
if ( !in_array( $action, array( 'postpass', 'logout', 'lostpassword', 'retrievepassword', 'resetpass', 'rp', 'register', 'login' ), true ) && false === has_filter( 'login_form_' . $action ) )
    $action = 'login';


nocache_headers();


if (is_user_logged_in() && $action != 'logout') {
    wp_redirect(site_url(get_option('member_login_page')));
    exit();
}

if ($action == 'logout') {
    check_admin_referer('log-out');
    wp_logout();
    
    $redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?loggedout=true';
    wp_safe_redirect( $redirect_to );
    exit();
}


$image_res=biz_portal_get_advertisement(BP_Advertisement::ADS_TYPE_LOGIN);
$img_id=$image_res->image_id;
$img_url=biz_portal_get_file_url($img_id); 

$args = array(
        'echo'           => true,
        'redirect'       => site_url( $_SERVER['REQUEST_URI'] ), 
        'form_id'        => 'loginform',
        'label_username' => __( '' ),
        'label_password' => __( '' ),
        'label_remember' => __( 'Remember Me' ),
        'label_log_in'   => __( 'Sign In' ),
        'id_username'    => 'user_login',
        'id_password'    => 'user_pass',
        'id_remember'    => 'rememberme',
        'id_submit'      => 'wp-submit',
        'remember'       => false,
        'value_username' => NULL,
        'value_remember' => false
);

?>
<?php  ?> 

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
   
   <!-- BEGIN PAGE LEVEL PLUGIN STYLES --> 
   <link href="<?php echo get_template_directory_uri(); ?>/assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" /> 
   <link href="<?php echo get_template_directory_uri(); ?>/assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>   
   <!-- END PAGE LEVEL PLUGIN STYLES -->

   <!-- BEGIN THEME STYLES --> 
   <link href="<?php echo get_template_directory_uri(); ?>/assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo get_template_directory_uri(); ?>/style.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo get_template_directory_uri(); ?>/assets/css/pages/page404.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo get_template_directory_uri(); ?>/assets/css/themes/orange.css" rel="stylesheet" type="text/css" id="style_color"/>
   <link href="<?php echo get_template_directory_uri(); ?>/assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
   <link href="<?php echo get_template_directory_uri(); ?>/assets/css/custom.css" rel="stylesheet" type="text/css"/>
   <!-- END THEME STYLES -->

   <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" />
   <style>
   	.bg_full{
		min-height: 100%;
                background-color: #ccc;
		/*background-image: url(<?php echo $img_url; ?>);*/
		background-repeat: no-repeat;
		background-position: center center;
		background-attachment: fixed;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;	
	}
   </style>
   <script>
   var template_directory_uri = '<?php echo get_template_directory_uri(); ?>';
   </script>
   
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="bg_full" >
 
    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container">
  
      

        <!-- BEGIN CONTAINER -->   
        <div class="col-md-12">
         
            <div class="col-md-4  login-signup-page">
            
            	<div style="text-align:center; width:100%; background-color:#fff; height:50px; vertical-align:middle; line-height:50px;">
                	<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png">
                </div>
                    
                <div style="padding:0 ; background-color:#f3f3f3;" >
                    <p style="margin:0 20px 30px; padding-top:20px;">
                    	<span style="font-size:24px;">Login</span><br>
                    	<small>Fill out the form below to login</small>
                    </p>
                    
                    <div style="padding:0 20px;">
						<?php wp_login_form( $args ); ?> 
            		</div>
                                
                    <div style="background-color:#d5dddf; height:100px; width:100%; clear:both; vertical-align:middle; margin-top:-10px; z-index:1; position:relative">
                           
                            <p style="text-align:center; padding-top:60px; font-size:11px;color:#444; z-index:100;"><a href="<?php echo site_url('wp-login.php') . '?action=lostpassword' ?>" style="color:#444; text-decoration:none">Forgot Password</a> | <a href="#" style="color:#444; text-decoration:none" onclick="$('#login_register_box').toggle();">Register</a></p>                      
                       
                        
                    </div>
                    
					<div style="height:50px; line-height:50px; vertical-align:middle; text-align:center; width:100%; background-color:#5c6b6e;clear:both">
                    	<a href="<?php echo home_url() ?>" style="color:#fff"><i class="fa  fa-angle-double-left"></i>  Back to Public Area of website</a>
                    </div>
                    
                </div>    
                
                
            </div>  <!--  login-signup-page   -->
            
            <div class="col-md-8 login-register-box" id="login_register_box">
            
            	<div style="text-align:center;">
                
                		<div class="transparent_box"> </div>
                    
                    	<div class="register_padding">
                        
                             <div style="float:left">
                                <?php if ( !is_user_logged_in() ) { ?> 
                                    <a href="/form-signup/?mt=<?php echo urlencode(base64_encode("TYPE_SME")); ?>">
                                <?php  } ?>
                                    <div class="box_orange">
                                        <p class="box_title">Apply as Myanmar SME/Company</p>
                                        <p class="arrow_down">
                                            <i class="fa fa-angle-double-down"></i>
                                        </p>
                                    </div>
                                <?php if ( !is_user_logged_in() ) { ?>
                                    </a>
                                 <?php  } ?>
                            </div>
                        
                            <div style="float:left">
                                <?php if ( !is_user_logged_in() ) { ?> 
                                <a href="/form-signup/?mt=<?php echo urlencode(base64_encode("TYPE_INTL")); ?>">
                                 <?php  } ?>
                                    <div class="box_orange">
                                        <p class="box_title">Apply as International Company</p>
                                        <p class="arrow_down">
                                            <i class="fa fa-angle-double-down"></i>
                                        </p>
                                    </div>
                                <?php if ( !is_user_logged_in() ) { ?> 
                                </a>
                                 <?php  } ?>
                            </div>
                        
                            <div style="float:left">
                                <?php if ( !is_user_logged_in() ) { ?> 
                                <a href="/form-signup/?mt=<?php echo urlencode(base64_encode("TYPE_NGO")); ?>">
                                 <?php  } ?>
                                    <div class="box_orange">
                                        <p class="box_title">Apply as NonProfit Organization</p>
                                        <p class="arrow_down">
                                            <i class="fa fa-angle-double-down"></i>
                                        </p>
                                    </div>
                                <?php if ( !is_user_logged_in() ) { ?> 
                                </a>
                                 <?php  } ?>
                            </div>                                
                        </div> <!-- register padding  -->
                        
                       
                    </div>
                    
            	
            </div>
            
            
            
          
        </div>
        <!-- END CONTAINER -->

  </div>
    <!-- END PAGE CONTAINER -->  
    
 

  

    
    <!-- Load javascripts at bottom, this will reduce page load time -->
    <!-- BEGIN CORE PLUGINS(REQUIRED FOR ALL PAGES) -->
    <!--[if lt IE 9]>
    <script src="assets/plugins/respond.min.js"></script>  
    <![endif]-->  
    <script src="<?php echo get_template_directory_uri(); ?>/assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>      
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/plugins/hover-dropdown.js"></script>
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/plugins/back-to-top.js"></script>    
	<script src="<?php echo get_template_directory_uri(); ?>/assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript" ></script>
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL JAVASCRIPTS(REQUIRED ONLY FOR CURRENT PAGE) -->
    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>

    <script src="<?php echo get_template_directory_uri(); ?>/assets/scripts/app.js"></script>  
    <script type="text/javascript">
        jQuery(document).ready(function() {    
           App.init();
		   App.initUniform();  
		   $('#loginform').css('width','100%');
		   $('#user_login').addClass('form-control');
		   $('#user_pass').addClass('form-control');
		   //$('.login-username').addClass('input-group margin-bottom-20');
		  // $('.login-password').addClass('input-group margin-bottom-40');
		   
		   //$( ".login-username" ).prepend( "<span class='input-group-addon'><i class='fa fa-user'></i></span>" );
		   //$('.login-password').prepend( "<span class='input-group-addon'><i class='fa fa-lock'></i></span>" );
		   $("#user_login").attr("placeholder", "Email");
		   $("#user_pass").attr("placeholder", "Password");
		   
		   
		   
		   $('#wp-submit').css('z-index','100');
		   $('#wp-submit').css('position','absolute');
		   $('#wp-submit').addClass('btn theme-btn btn-block');
		   $('#wp-submit').css('width','170px'); 
		   $('#wp-submit').css('margin','10px 0 0 40px'); 

		   var image = new Image();
		   image.src = '<?php echo $img_url; ?>';
   	       $('.bg_full').css('background-image', 'url(' + image.src + ')');
		  
        });
        
    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>