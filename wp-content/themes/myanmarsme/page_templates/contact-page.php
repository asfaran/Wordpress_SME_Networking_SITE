<?php
/*
  Template Name: Contact Page
 */
define('CONTACT_PAGE', true, true);  
define('SUBMENU_ITEM','');

Theme_Vars::add_script('maps_api_js', 'http://maps.googleapis.com/maps/api/js?sensor=false');

get_header();

$contact_result=get_option('contact_page_content');
?>
    <!-- BEGIN PAGE CONTAINER -->  
    <div class="page-container page-body">
       
        <div id="contact">
       		<div class="row">
       			<div class="container">
                         <div class="col-md-5">
                              <div class="contact-box">                              
                              	<div class="form-group">
                                    <img src="<?php echo $contact_result['form_img']; ?>" class="img-responsive" >
                                    <div class="contact-email">E: <?php echo $contact_result['mail']; ?></div>
                                 </div>
                                <div id="contactform">
								<?php
								if (isset($_GET['sent']) && $_GET['sent'] === 'true')
								{
								    echo '<p style="font-size:12px;">'.nl2br($contact_result['thanks_text']).'</p>';
                                                                    
								}
								else {
									$contact = getPageContent(37);  
									echo $contact['content'];
								}
								?>    
                                </div>    
                              	
                              </div>
                            </div>
                
                </div>  <!-- row  -->	  
            </div>  <!-- container  -->
       		<div id=map></div>
       </div> <!-- contact  -->
       
    			<div class="clearfix"></div>
        		<!-- BEGIN CONTAINER -->   
     			
			<?php include __DIR__ . "/include_pages/join_communities_advertising.php";  ?>  
        		
			<!-- END CONTAINER -->
        
         		<div class="clearfix"></div>
         
         		<?php include __DIR__ . "/include_pages/faq_section.php";  ?>       
    </div>
    <!-- END PAGE CONTAINER -->
    
<?php

Theme_Vars::add_scriptlets('google.maps.event.addDomListener(window, "load", initialize_google_map);');
Theme_Vars::add_script_ready('MapsGoogle.init();');
Theme_Vars::add_script_ready('get_input_class();');
?>
	<script>
	function initialize_google_map() {
		var myLatlng = new google.maps.LatLng(24.0702251,61.2411702);

			var mapProp = {
				center: myLatlng, //new google.maps.LatLng(24.0702251,61.2411702), // <- Your LatLng
				zoom:3,
				scrollwheel: false,
				mapTypeId:google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById("map"),mapProp);
			
			var contentString = "<?php echo $contact_result['place_text']; ?>"
			var image = '<?php echo $contact_result['map_pointer']; ?>';
			
			var marker = new google.maps.Marker({
			  position: new google.maps.LatLng(<?php echo $contact_result['map_lat'].",".$contact_result['map_lng']; ?>),
			  map: map,
			  title: '<?php echo $contact_result['title']; ?>',
			  icon: image
		  	});
			
			
			
			var infowindow = new google.maps.InfoWindow({
				  content: contentString
			 });
			  
			 google.maps.event.addListener(marker, 'click', function() {
				infowindow.open(map,marker);
			 });
	}
	
	function get_input_class(){
		$('#fscf_name1').addClass('form-control');	
		$("#fscf_name1").attr("class", "form-control");
	}
	
	</script>
   
  <?php get_footer() ?>
  
  
      
  
  <!-- Modal (Advertise With Us) -->
    <div class="modal fade" id="advertise_window" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" id="logoimg" alt="" class="img-responsive"></h4>
          </div>
          
          <div class="modal-body">
            	<div class="row">
                <div class="col-md-4" style="border-right:#aaa 1px solid;">
                	<p style="text-align:justify" >
                        Etiam in hendrerit enim, lacinia sagittis tellus. In eu sem cursus, consequat mauris quis, imperdiet eros. 
                        </p>
                        <p style="text-align:justify" >
                        Etiam in hendrerit enim, lacinia sagittis tellus. In eu sem cursus, consequat mauris quis, imperdiet eros. 
                        </p>
                </div>
                
                <div class="col-md-8">
                	
                    <h4 class="text-center" id="dialog_header"></h4>
                    <div id="dialog_form"></div>
                    
                </div>
                </div>
          </div>
         
      </div>
    </div>
    
    <!-- Modal (Advertise With Us) -->