<!-- BEGIN COPYRIGHT -->
    <?php include "footer_name.php";  ?>
    <!-- END COPYRIGHT -->
         
    <?php foreach (Theme_Vars::$scripts as $key => $script) :?>
    <script src="<?php echo $script;?>"></script>
    <?php endforeach;?>	
	<?php wp_footer(); ?>
	
	<script>
	function __init_scrolltop_buttons_i()
    {
    	var top_bar_height = is_user_logged_in ? 80 : 35;
    	jQuery(".button_scroll_top").click(function(e) {
        	e.preventDefault();
        	var scroll_length = $(this).offset().top;
        	if (scroll_length - top_bar_height > 0) {
        		jQuery('html,body').animate({"scrollTop": scroll_length - top_bar_height}, 1000);
        	}
    	});
    }
	</script>
	
	<script type="text/javascript">
	jQuery(function() {
        
  	  //for bootstrap 3 use 'shown.bs.tab' instead of 'shown' in the next line
  	  jQuery('a[data-toggle="tab"]').on('shown', function (e) {
  	    //save the latest tab; use cookies if you like 'em better:
  	    localStorage.setItem('lastTab', $(e.target).attr('id'));
  	  });

  	  //go to the latest tab, if it exists:
  	  var lastTab = localStorage.getItem('lastTab');
  	  if (lastTab) {
  	      jQuery('#'+lastTab).tab('show');
  	    }
  	});
  	
        jQuery(document).ready(function( $ ) {
            
			var id = "<?php echo (isset($company_id)) ? $company_id : 0; ?>";
				
			App.init();    
			
            App.initBxSlider();
            Index.initRevolutionSlider();
            FormFileUpload.init();
			
			<?php if(defined('PRIVATE_SUBMENU') && PRIVATE_SUBMENU) : ?>
				Index.initCharts(); // init index page's custom scripts		   		                 
			<?php endif; ?>			

			<?php foreach (Theme_Vars::$script_ready as $script) : ?>
		    <?php echo $script . "\n"; ?>
			<?php endforeach; ?>

			<?php if (current_user_can('edit_post')) : ?>
			AdminUpdate.init();
			<?php endif; ?>
			__init_scrolltop_buttons_i();

			if( $(window).width() < 767){

				<?php //if ((SUBMENU_ITEM === 'resources')) : 	?>

				$('#menu-item-485').find('a').append('<span class="pull-right mobile_only"><small><i class="fa fa-plus"></i></small></span>');

				$('#menu-item-485').hover(function(){
						
						var el = $(this);

						el.find('a').addClass('dropdown-toggle').attr('data-delay','0').attr('data-close-other','true').attr('data-toggle','dropdown').attr('data-hover','dropdown');
						el.find('small:last').remove();
						el.removeClass();
						el.addClass('open');
						el.find('span').append('<small><i class="fa fa-minus"></i></small>');
						el.append(resources_submenu);

					},

					function(){
						var el = $(this);
						el.removeClass('open');
						el.find('small:last').remove();
						el.find('span').append('<small><i class="fa fa-plus"></i></small>');
						el.find('ul.dropdown-menu:last').remove();
					}

				);

				$('#menu-item-485').click(function(){
					var el = $(this);
					if ((el.hasClass('fa-plus')) || (el.hasClass('open'))){
						el.find('ul.dropdown-menu:last').remove();
						el.find('small:last').remove();
						el.find('span').append('<small><i class="fa fa-plus"></i></small>');

					} else {
						el.find('small:last').remove();
						el.find('span').append('<small><i class="fa fa-minus"></i></small>');
						el.append(resources_submenu);
					}
				});

				

				<?php //endif; ?>

				// resources mobile

								

				// newsrrom mobile
				<?php //if ((SUBMENU_ITEM === 'newsroom')) : 	?>
				$('#menu-item-30,#menu-item-681').each(function(){
						$(this).find('a').append('<span class="pull-right mobile_only"><small><i class="fa fa-plus"></i></small></span>');
						$(this).hover(
							function(){
								$(this).find('a').addClass('dropdown-toggle').attr('data-delay','0').attr('data-close-other','true').attr('data-toggle','dropdown').attr('data-hover','dropdown');
								$(this).removeClass();
								$(this).find('small:last').remove();
								$(this).addClass('open');
								$(this).find('span').append('<small><i class="fa fa-minus"></i></small>');
								$(this).append(newsroom_menu);
							},
							function(){
								$(this).removeClass('open');
								$(this).find('small:last').remove();
								$(this).find('span').append('<small><i class="fa fa-plus"></i></small>');
								$(this).find('ul.dropdown-menu:last').remove();
							}	
						);
					}
				);


				$('#menu-item-30,#menu-item-681').each(function(){

						$(this).click(function(){

							var el = $(this);
								if ((el.hasClass('fa-plus')) || (el.hasClass('open'))){
								el.find('small:last').remove();
								el.find('span').append('<small><i class="fa fa-plus"></i></small>');
								el.find('ul.dropdown-menu:last').remove();
							} else {
								el.find('small:last').remove();
								el.find('span').append('<small><i class="fa fa-minus"></i></small>');
								el.append(newsroom_menu);
							}

						});
				});

				<?php //endif; ?>

				//  My Account

				$('#menu_my_account').hover(

					function(){

						$(this).find('small:last').remove();
						$(this).removeClass();
						$(this).addClass('open');
						$(this).find('span').append('<small><i class="fa fa-minus"></i></small>');

					},

					function(){

						$(this).removeClass('open');
						$(this).find('small:last').remove();
						$(this).find('span').append('<small><i class="fa fa-plus"></i></small>');

					}

				);

				$('#menu_my_account').click(function(){

					el = $(this);

					if ((el.hasClass('fa-plus')) || (el.hasClass('open'))){
						el.find('small:last').remove();
						el.find('span').append('<small><i class="fa fa-plus"></i></small>');
					} else {
						el.find('small:last').remove();
						el.find('span').append('<small><i class="fa fa-minus"></i></small>');
					}
				});

				//  Opportunities

				$('#menu_opportunities').hover(
					function(){
						var oppor_el = $(this);
						oppor_el.find('small:last').remove();
						oppor_el.removeClass();
						oppor_el.addClass('open');
						oppor_el.find('span').append('<small><i class="fa fa-minus"></i></small>'); 
					},

					function(){
						var oppor_el = $(this);
						oppor_el.removeClass('open');
						oppor_el.find('small:last').remove();
						oppor_el.find('span').append('<small><i class="fa fa-plus"></i></small>');
					}
				);

				$('#menu_opportunities').click(function(){
					var el = $(this);
					if ((el.hasClass('fa-plus')) || (el.hasClass('open'))){
						el.find('small:last').remove();
						el.find('span').append('<small><i class="fa fa-plus"></i></small>');
					} else {
						el.find('small:last').remove();
						el.find('span').append('<small><i class="fa fa-minus"></i></small>');
					}
				});
			}  // if mobile		
			
        });
    </script>
    <script>
    <?php foreach (Theme_Vars::$scriptlets as $scriptlet) : ?>
    <?php echo $scriptlet . " \n" ;?>
    <?php endforeach; ?>
    </script>    
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-56198914-1', 'auto');
      ga('send', 'pageview');
    
    </script>
</body>
<!-- END BODY -->
</html>