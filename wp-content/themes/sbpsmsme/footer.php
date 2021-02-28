</div>
<!-- END PAGE CONTAINER -->    
<!-- BEGIN FOOTER -->
<div class="footer">
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-column-one'))  ?>
            </div>

            <div class="col-md-3 col-sm-3">
                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-column-two'))  ?>
            </div>

            <div class="col-md-3 col-sm-3">
                <?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-column-three'))  ?>
            </div>

            <div class="col-md-3 col-sm-3">
                <!-- BEGIN TWITTER BLOCK -->
                <div style="display:block; vertical-align:middle; margin-top:70px;">
                    <a href="<?php echo site_url(); ?>">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/logo_bg.png" class="img-responsive" alt="">
                    </a>
                </div>
                <!-- END TWITTER BLOCK -->
            </div>
        </div>
    </div>
</div>
<!-- END FOOTER -->

<!-- BEGIN COPYRIGHT -->
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <p>
                    <span class="margin-right-10"><?php echo date('Y'); ?> &copy; Myanmar SME Link. ALL Rights Reserved.</span>

                </p>
            </div>
            <div class="col-md-4 col-sm-4">
                <ul class="social-footer">
                    <?php $social_fb_link = get_option('social_fb_link', ""); ?>
                    <?php if (!empty($social_fb_link)) : ?>
                        <li><a href="<?php echo $social_fb_link; ?>"><i class="fa fa-facebook"></i></a></li>
                    <?php endif; ?>
                    <?php $social_twitter_link = get_option('social_twitter_link', ""); ?>
                    <?php if (!empty($social_twitter_link)) : ?>
                        <li><a href="<?php echo $social_twitter_link; ?>"><i class="fa fa-twitter"></i></a></li>
                    <?php endif; ?>
                    <?php $social_google_link = get_option('social_google_link', "") ?>
                    <?php if (!empty($social_google_link)) : ?>
                        <li><a href="<?php echo $social_google_link; ?>"><i class="fa fa-google-plus"></i></a></li>
                    <?php endif; ?>
                    <?php $social_linkedin_link = get_option('social_linkedin_link', "") ?>
                    <?php if (!empty($social_linkedin_link)) : ?>
                        <li><a href="<?php echo $social_linkedin_link; ?>"><i class="fa fa-linkedin"></i></a></li>                    
                    <?php endif; ?>
                    <?php $social_rss_link = get_option('social_rss_link', "") ?>
                    <?php if (!empty($social_rss_link)) : ?>
                        <li><a href="<?php echo $social_rss_link; ?>"><i class="rss"></i></a></li>
                            <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- END COPYRIGHT -->
<!-- END COPYRIGHT -->

<!-- ================= -->
<?php wp_footer(); ?>
<!-- ================= -->

<!-- Load javascripts at bottom, this will reduce page load time -->
<!-- BEGIN CORE PLUGINS(REQUIRED FOR ALL PAGES) -->
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/assets/plugins/respond.min.js"></script>
<![endif]-->

<?php /* <link href="/boxslider/jquery.bxslider.css" rel="stylesheet" />
  <script src="/boxslider/jquery.bxslider.js"></script> */ ?>


<script type="text/javascript">
    var global_login_url = "<?php echo wp_login_url(); ?>";
    var global_smepage_url = "<?php echo get_permalink(266); ?>";
    jQuery(document).ready(function($) {
        App.init();
        App.initBxSlider();
        jQuery('.calendar-archives').archivesCW();

        $('.submenu a.logged-out').click(function(e) {
            e.preventDefault();
            var redirect_url = $(this).attr('href');

            //jQuery('.nav-login-form .search-box').fadeIn(300);
            //jQuery('.nav-login-form .search-btn').addClass('show-search-icon');
            //$("body").append('<div class="modalOverlay">');
            if (global_old_login_redirect_url.length == 0)
                global_old_login_redirect_url = $(".login-menu-linker form").attr('action');

            $(".login-menu-linker form").attr('action', global_login_url + '?redirect_to=' + redirect_url);
            global_enable_overlay = true;
            jQuery('.nav-login-form a.search-btn').trigger('click');
        });
    });
</script>
<link href="<?php echo get_template_directory_uri(); ?>/assets/css/custom_footer.css" rel="stylesheet" type="text/css"/>
<!-- END PAGE LEVEL JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>