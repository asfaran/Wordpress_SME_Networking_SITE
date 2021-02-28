<?php
date_default_timezone_set('Asia/Dubai'); 
?>
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
   <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
   <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
   <!-- END GLOBAL MANDATORY STYLES -->
   
   <!-- BEGIN PAGE LEVEL PLUGIN STYLES --> 
   <link href="assets/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet" />              
   <link rel="stylesheet" href="assets/plugins/revolution_slider/css/rs-style.css" media="screen">
   <link rel="stylesheet" href="assets/plugins/revolution_slider/rs-plugin/css/settings.css" media="screen"> 
   <link href="assets/plugins/bxslider/jquery.bxslider.css" rel="stylesheet" />                
   <!-- END PAGE LEVEL PLUGIN STYLES -->

   <!-- BEGIN THEME STYLES --> 
   <link href="assets/css/style-metronic.css" rel="stylesheet" type="text/css"/>
   <link href="assets/css/style.css" rel="stylesheet" type="text/css"/>
   <link href="assets/css/themes/orange.css" rel="stylesheet" type="text/css" id="style_color"/>
   <link href="assets/css/style-responsive.css" rel="stylesheet" type="text/css"/>
   <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
   <!-- END THEME STYLES -->

   <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body>
	 

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
				<a class="navbar-brand logo-v1" href="index.php">
					<img src="images/logo.png" id="logoimg" alt="" class="img-responsive">
				</a>
				<!-- END LOGO -->
			</div>
		
			<!-- BEGIN TOP NAVIGATION MENU -->
			<?php include "menu.php";  ?>
			<!-- BEGIN TOP NAVIGATION MENU -->
		</div>
    </div>
    <!-- END HEADER -->

    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container">
       
    	
        <!-- BEGIN CONTAINER -->   
       <!-- BEGIN CONTAINER -->   
		<div class="container min-hight">
			<div class="row" style="padding:30px 0">
				<div class="col-md-7 col-sm-7" style="border-right:1px solid #ccc;">
                	<h2>Our Contacts</h2>
					<address>
						<strong>MYANMAR SME LINK</strong><br>
						Cyberport 1, Level 12<br>
						100 Cyberport Road,<br>
                        Hong Kong<br>
						<abbr title="Email">Email:</abbr> <a href="mailto:info@abc.com">info@abc.com</a>
					</address>
                
					<div style="margin-top:10px">&nbsp;</div>
                    <h2>Email Us</h2>
					
					<div class="space20"></div>
					<!-- BEGIN FORM-->
					<form action="#" class="horizontal-form margin-bottom-40" role="form">
						<div class="form-group">
							<label class="control-label">Name</label>
							<div class="col-lg-12">
								<input type="text" class="form-control" name="name" />
							</div>
						</div>
						<div class="form-group">
							<label class="control-label" >Email <span class="color-red">*</span></label>
							<div class="col-lg-12">
								<input type="email" class="form-control" name="email" >
							</div>
						</div>
                        <div class="form-group">
							<label class="control-label" >Subject <span class="color-red">*</span></label>
							<div class="col-lg-12">
								<input type="text" class="form-control" name="subject" >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label" >Message</label>
							<div class="col-lg-12">
								<textarea class="form-control" rows="6" name="message"></textarea>
							</div>
						</div>
                        
                         <div class="form-group">
                            <label class="control-label" >File Attachment</label>
                            <div class="col-lg-12">
                                <input type="file" id="file_attachment" name="file_attachment">
                            </div>
                        </div>
                        
						<button type="submit" class="btn btn-default theme-btn"><i class="icon-ok"></i> Send</button>
						<button type="button" class="btn btn-default">Cancel</button>
					</form>
					<!-- END FORM-->                  
				</div>

				<div class="col-md-5 col-sm-5">
					
                    <h2 style="text-align:center">JOIN THIS COMMUNITY</h2>
                    
                    <p style="text-align:justify; padding:20px;" >Join this community (for registered members only) is the place where our corporate community members shares a variety of information in different formats for the benefit of the entire value chain.</p>
                   
                    <div style="margin:10px; text-align:center;">
                    
                    	<a href="#">
                        <div style="width:155px; height:150px; float:left; margin:10px; background-color:#F90;padding:5px; color:#fff; text-align:justify;">
                        	Apply as
                            <ul>
                            	<li>Myanmar SME</li>
                            </ul>
                            <p style="bottom:4px; position:relative; color:#fff; text-align:center; width:155px; ">
                            	<i class="fa fa-angle-double-down"></i>
                            </p>
                        </div>
                        </a>
                        
                        <a href="#">
                        <div style="width:155px; height:150px; float:left; margin:10px; background-color:#F90;padding:5px; color:#fff; text-align:justify;">
                        	Apply as
                            <ul>
                            	<li>Business Partner</li>
                                <li>Service Provider</li>
                                <li>Investor</li>
                                <li>NonProfit Organization</li>
                            </ul>
                            <p style="bottom:4px; position:relative; color:#fff; text-align:center; width:155px;">
                            	<i class="fa fa-angle-double-down"></i>
                            </p>
                        </div>
                        </a>
                       
                    </div>
                   
                    

					<div class="clearfix margin-bottom-30" style="text-align:center;padding-left:20px;"><div style="border-bottom:1px solid #ccc; width:92%; ">&nbsp;</div></div>

					<h2 style="text-align:center">ADVERTISE WITH US</h2>
					<div style="padding:20px;">
                    
                        <p style="text-align:justify" >
                        Etiam in hendrerit enim, lacinia sagittis tellus. In eu sem cursus, consequat mauris quis, imperdiet eros. Mauris condimentum odio non ligula porta, sit amet porttitor urna ultrices.
                        </p>
                        <p style="text-align:justify" >
                        Etiam in hendrerit enim, lacinia sagittis tellus. In eu sem cursus, consequat mauris quis, imperdiet eros. Mauris condimentum odio non ligula porta, sit amet porttitor urna ultrices.
                        </p>
                        <div class="pull-left"><a href="#">Advertising information <i class="fa fa-angle-double-right"></i></a></div>
                    
                    </div>                                
				</div>            
			</div>
		</div>
		<!-- END CONTAINER -->
        <!-- END CONTAINER -->
    
        
    </div>
    <!-- END PAGE CONTAINER -->

    <!-- BEGIN FOOTER -->
    <div class="footer">
        <div class="container">
            <div class="row margin-bottom-30">
                <div class="col-md-12 col-sm-12">
                    <div style="text-align:center; width:100%; margin:40px; 0">
                        <h4>With special thanks to the following entities:</h4>
                    </div>  
                    <!--  Highest Paid  -->
                    <div class="col-md-12 col-sm-12 margin-bottom-20 text-center" style="margin:30px 0;">
                    	<div class="col-md-3 text-center ">
                        	<img src="images/logos/hp_p1.jpg" >
                        </div>
                        <div class="col-md-3 ">
                        	<img src="images/logos/hp_p2.jpg" >
                        </div>
                        <div class="col-md-3 ">
                        	<img src="images/logos/hp_p3.jpg" >
                        </div>
                        <div class="col-md-3 ">
                        	<img src="images/logos/hp_p4.jpg" >
                        </div>
                    </div>   
                    <!--  Highest Paid  --> 
                    <div class="clearfix"></div>
                    <!--  Low Paid  -->
                    <div class="col-md-12 col-sm-12 margin-bottom-20 text-center" style="margin:30px 0;">
                    	<div class="col-md-3 ">
                        	<img src="images/logos/lp_p1.jpg" >
                        </div>
                        <div class="col-md-3 ">
                        	<img src="images/logos/lp_p2.jpg" >
                        </div>
                        <div class="col-md-3 ">
                        	<img src="images/logos/lp_p3.jpg" >
                        </div>
                        <div class="col-md-3 ">
                        	<img src="images/logos/lp_p4.jpg" >
                        </div>
                    </div>   
                    <!--  Low Paid  --> 
                    <div class="clearfix"></div>
                    <!--  Primary Sponsor -->
                    <div class="col-md-9 col-md-offset-2 margin-bottom-40 text-center">
                    	<div class="col-md-4 ">
                        	<img src="images/logos/ps_p1.jpg" >
                        </div>
                        <div class="col-md-4 ">
                        	<img src="images/logos/ps_p2.jpg" >
                        </div>
                        <div class="col-md-4 ">
                        	<img src="images/logos/ps_p3.jpg" >
                        </div>
                    </div>   
                    <!--  Primary Sponsor -->
                </div>

            </div>
        </div>
    </div>
    <!-- END FOOTER -->

    <!-- BEGIN COPYRIGHT -->
   <?php include "footer.php";  ?>
    <!-- END COPYRIGHT -->

    <!-- Load javascripts at bottom, this will reduce page load time -->
    <!-- BEGIN CORE PLUGINS(REQUIRED FOR ALL PAGES) -->
    <!--[if lt IE 9]>
    <script src="assets/plugins/respond.min.js"></script>  
    <![endif]-->  
    <script src="assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>      
    <script type="text/javascript" src="assets/plugins/hover-dropdown.js"></script>
    <script type="text/javascript" src="assets/plugins/back-to-top.js"></script>    
    <!-- END CORE PLUGINS -->

    <!-- BEGIN PAGE LEVEL JAVASCRIPTS(REQUIRED ONLY FOR CURRENT PAGE) -->
    <script type="text/javascript" src="assets/plugins/fancybox/source/jquery.fancybox.pack.js"></script>  
    <script type="text/javascript" src="assets/plugins/revolution_slider/rs-plugin/js/jquery.themepunch.plugins.min.js"></script>
    <script type="text/javascript" src="assets/plugins/revolution_slider/rs-plugin/js/jquery.themepunch.revolution.min.js"></script> 
    <script type="text/javascript" src="assets/plugins/bxslider/jquery.bxslider.min.js"></script>
    <script src="assets/scripts/app.js"></script>
    <script src="assets/scripts/index.js"></script>    
    <script type="text/javascript">
        jQuery(document).ready(function() {
            App.init();    
            App.initBxSlider();
            Index.initRevolutionSlider();                    
        });
    </script>
    <!-- END PAGE LEVEL JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>