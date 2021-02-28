<?php
define('PRIVATE_SUBMENU', true, true);
define('PROFILE_PAGE', true, true);
define('PARENT', 'MYACCOUNT', true);


if(isset($_POST['btn_submit'])){
    $old_pass = $_POST['old_pass']; //filter_inpt(INPUT_POST, 'old_pass', FILTER_SANITIZE_STRING);
    $new_pass = $_POST['new_pass']; //filter_input(INPUT_POST, 'new_pass', FILTER_SANITIZE_STRING);
    $confirm_pass =$_POST['confirm_pass']; //filter_input(INPUT_POST, 'confirm_pass', FILTER_SANITIZE_STRING);
    
    global $current_user;
    get_currentuserinfo();
    if ( $current_user && wp_check_password( $old_pass, $current_user->data->user_pass, $current_user->ID) )
            if($new_pass==$confirm_pass && $new_pass != null && $new_pass !=''){
               wp_set_password( $new_pass, $current_user->ID );
               $msg= "Password changed successfully";
               BP_FlashMessage::Add($msg, BP_FlashMessage::SUCCESS);
               wp_redirect('dashboard/profile/accounts');
               exit();
                
            }else{
                $msg= "Plese, confirm new password";
                BP_FlashMessage::Add($msg, BP_FlashMessage::ERROR);
            }          
    else {
        $msg= "Current password is not correct";
        BP_FlashMessage::Add($msg, BP_FlashMessage::ERROR);
    }
}

wp_enqueue_script( 'password-strength-meter' );
?>

<?php get_header(); 
?>
<script>
    function checkPasswordStrength( $pass1,
                                $pass2,
                                $strengthResult,
                                $submitButton,
                                blacklistArray ) {
        var pass1 = $pass1.val();
    var pass2 = $pass2.val();
 
    // Reset the form & meter
    $submitButton.attr( 'disabled', 'disabled' );
        $strengthResult.removeClass( 'short bad good strong' );
 
    // Extend our blacklist array with those from the inputs & site data
    blacklistArray = blacklistArray.concat( wp.passwordStrength.userInputBlacklist() )
 
    // Get the password strength
    var strength = wp.passwordStrength.meter( pass1, blacklistArray, pass2 );
 
    // Add the strength meter results
    switch ( strength ) {
 
        case 2:
            $strengthResult.addClass( 'bad' ).html( "Password is " + pwsL10n.bad );
            break;
 
        case 3:
            $strengthResult.addClass( 'good' ).html( "Password is " +  pwsL10n.good );
            break;
 
        case 4:
            $strengthResult.addClass( 'strong' ).html( "Password is " +  pwsL10n.strong );
            break;
 
        case 5:
            $strengthResult.addClass( 'short' ).html(  "Password are " + pwsL10n.mismatch );
            break;
 
        default:
            $strengthResult.addClass( 'short' ).html(  "Password is " + pwsL10n.short );
 
    }
 
    // The meter function returns a result even if pass2 is empty,
    // enable only the submit button if the password is strong and
    // both passwords are filled up
    if ( 4 === strength && '' !== pass2.trim() ) {
        $submitButton.removeAttr( 'disabled' );
    }
 
    return strength;
}
 
jQuery( document ).ready( function( $ ) {
    // Binding to trigger checkPasswordStrength
    $( 'body' ).on( 'keyup', 'input[name=new_pass], input[name=confirm_pass]',
        function( event ) {
            checkPasswordStrength(
                $('input[name=new_pass]'),         // First password field
                $('input[name=confirm_pass]'), // Second password field
                $('#password-strength'),           // Strength meter
                $('input[type=submit]'),           // Submit button
                ['black', 'listed', 'word']        // Blacklisted words
            );
        }
    );
});
    </script>
    <style>
        #password-strength{
	background-color:#eee;border-color:#ddd!important;
}
#password-strength.bad{
	background-color:#ffb78c;
	border-color:#ff853c!important;
}
#password-strength.good{
	background-color:#ffec8b;
	border-color:#fc0!important;
}
#password-strength.short{
	background-color:#ffa0a0;
	border-color:#f04040!important;
}
#password-strength.strong{
	background-color:#c3ff88;border-color:#8dff1c!important;
}
        
    </style>
    
	<!-- END HEADER -->
<!--	<div class="clearfix"></div>-->
	<!-- BEGIN CONTAINER -->   
	<div class="page-container  page-body profile-inner">
		
		<!-- BEGIN PAGE -->
		<div class="container min-hight">
			
			           
			<!-- BEGIN PAGE HEADER-->
			<div class="row">
				<div class="col-md-12 margin-bottom-30">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
					<h3 class="page-title">
						Company Account	
					</h3>
					            <?php
						        if (BP_FlashMessage::HasMessages()) {
									biz_portal_get_messages();
								}
						        ?>
					
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
							<li><a href="/dashboard/profile">Overview</a></li>
							<li  class="active"><a href="/dashboard/profile/accounts" >Account</a></li>
							<li><a href="/dashboard/profile/resources?type=<?php echo urlencode(strtolower(BP_Node::NODE_TYPE_RESOURCE)) ?>" >Resources</a></li>
							<li><a href="/dashboard/profile/resources?type=<?php echo urlencode(strtolower(BP_Node::NODE_TYPE_POST)) ?>" >Posts</a></li>
							<li><a href="/dashboard/profile/resources?type=<?php echo urlencode(strtolower(BP_Node::NODE_TYPE_DOWNLOAD)) ?>" >Corporate Documents</a></li>
							
						</ul>
						<div class="tab-content">
						
							<!--tab_1_2-->
							<div class="tab-pane active" id="tab_1_3">
								<div class="row profile-account">
									<div class="col-md-3">
										<ul class="ver-inline-menu tabbable margin-bottom-10">
                                                                                    <li class="active"><a data-toggle="tab" href="#tab_1-1"><i class="fa fa-lock"></i> Change Password</a></li>
										</ul>
									</div>
									<div class="col-md-9">
										<div class="tab-content">
											<div id="tab_1-1" class="tab-pane active">
												<form action="/dashboard/profile/accounts" method="post">
													<div class="form-group">
														<label class="control-label">Current Password</label>
														<input type="password" name="old_pass" class="form-control" />
													</div>
													<div class="form-group">
														<label class="control-label">New Password</label>
														<input type="password" name="new_pass" class="form-control" />
													</div>
													<div class="form-group">
														<label class="control-label">Re-type New Password</label>
														<input type="password" name="confirm_pass" class="form-control" /><br/>
                                                          <span id="password-strength"> </span>
                                                          <p class="description indicator-hint"><?php _e( 'Hint: The password should be at least seven characters long. To make it stronger, use upper and lower case letters, numbers and symbols like ! " ? $ % ^ & ).', 'theme-my-login' ); ?></p>
													</div>
													<div class="margin-top-10">
														<input type="submit" name="btn_submit" id="btn_submit" class="btn green" value="Change Password">
														<a href="#" class="btn default">Cancel</a>
													</div>
												</form>
											</div>
											
										</div>
									</div>
									<!--end col-md-9-->                                   
								</div>
							</div>
							<!--end tab-pane-->
                            
                            
						
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