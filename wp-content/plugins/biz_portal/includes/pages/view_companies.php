<?php
$company_id = filter_input(INPUT_GET, 'company_id', FILTER_VALIDATE_INT);
$company_industries = biz_portal_get_industries_list();
$biz_type = biz_portal_get_business_types_list();
$biz_needs_partner_in = $biz_type;
$biz_needs_partner_in_ind = $company_industries;
$biz_needs_invest_in_ind = $company_industries;	
$service_provider = biz_poratal_get_biz_services_list();

$BP_Company = biz_portal_get_company($company_id);

$MODE = 'view';

if (isset($_POST['action']))
{
	$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
	if ($action === 'activate' || $action === 'deactivate' || $action === 'delete') {
		$MODE = 'confirm';
	}
	else if ($action === 'confirm_activate') {
		$company_id = filter_input(INPUT_POST, 'company_id', FILTER_VALIDATE_INT);
		if ($company_id) {
			$res = biz_portal_change_company_state($company_id, 1);
			if ($res) {
				try {
					biz_portal_trigger_company_activated($company_id);				
				}
				catch (Exception $ex) {
					echo $ex->getMessage();
				}
			}
		}
	}
	else if ($action === 'confirm_deactivate') {
		$company_id = filter_input(INPUT_POST, 'company_id', FILTER_VALIDATE_INT);
		if ($company_id) {
			$res = biz_portal_change_company_state($company_id, 0);	
		}
	}
	else if ($action === 'confirm_delete') {
		$company_id = filter_input(INPUT_POST, 'company_id', FILTER_VALIDATE_INT);
		if ($company_id) {
			$res = biz_portal_delete_company($company_id);
			if ($res) {				
				//header("location:" . $_SERVER['PHP_SELF'] . '?page=admin-list-companies');
				wp_redirect(admin_url('admin.php?page=admin-list-companies'));
				exit();
			}
		}
	}
}

$company_full = null;
if ($company_id) {
    $company = biz_portal_get_company($company_id);
    if ($company)
        $company_full = biz_portal_load_company_relations($company);
}


if(!empty($company_full->addresses)):

        if (is_array($company_full->addresses)) :
            foreach ($company_full->addresses as $key => $value) : 
                    if ($key > 0) : 
                            $address1 = $value->company_number;  
                            $address2 = $value->street;  
                            $city = $value->city; 
                            $postal = $value->postal_code;  
                            $state_region = $value->region;  	 
                    endif;
            endforeach;					 
        endif;	
endif;	

if(!empty($company_full->contacts)):	
    if (is_array($company_full->contacts)) :
        foreach ($company_full->contacts as $key => $value) : 
                if ($key > 0) : 
                        $person = $value->contact_person;  
                        $position = $value->position;  
                        $telephone = $value->telephone; 
                        $fax = $value->fax;  
                        $web = $value->web;  
                        $mobile = $value->mobile;  
                        $email = $value->email;  	  
                endif;
        endforeach;					 
    endif;		
endif;


        $member_type = $company_full->member_type->id;


	$biz_related_type =  (!empty($company_full->biz_types)) ? array_keys($company_full->biz_types) : "";	
	$biz_related_industry = (!empty($company_full->industries)) ? array_keys($company_full->industries) : "";
	$biz_need_partner_biz_types = (!empty($company_full->biz_need_partner_biz_types)) ? array_keys($company_full->biz_need_partner_biz_types) : "";
	$biz_need_partner_industries = (!empty($company_full->biz_need_partner_industries)) ? array_keys($company_full->biz_need_partner_industries) : "";
	$biz_need_invest_industries = (!empty($company_full->biz_need_investment->industries)) ? array_keys($company_full->biz_need_investment->industries) : "";
	$biz_need_services = (!empty($company_full->biz_need_services)) ? array_keys($company_full->biz_need_services) : "";
	$biz_need_details = (!empty($company_full->biz_need_details)) ? array_keys($company_full->biz_need_details) : "";
	
	$biz_give_invest_industries = (!empty($company_full->biz_give_investment->industries)) ? array_keys($company_full->biz_give_investment->industries) : "";
	$biz_give_invest_ind = $company_full->biz_give_investment->industries;
	
	$biz_give_services = (!empty($company_full->biz_give_services)) ? array_keys($company_full->biz_give_services) : "";
	
	$biz_need_ngo_services_provided =(!empty($company_full->biz_need_ngo_supp_serv->services_provided)) ? array_keys($company_full->biz_need_ngo_supp_serv->services_provided) : "";
        
        $Company_Filter = new BP_Company_Filter();
?>
<style>
    /* Contains the entire tabbed section */
.tabbed {
	}

/* List of tabs */.tabbed ul.tabs {
	float: left;
	display: inline;
	width: 100%;
	margin: 0;
	padding: 0;
	}
.tabbed ul.tabs li {
        list-style: none;
	float: left;
	margin: 0;
	padding: 0;
        box-shadow: 0 1px 0 rgba(120, 200, 230, 0.5) inset, 0 1px 0 rgba(0, 0, 0, 0.15);
	}
.tabbed ul.tabs li a {
	overflow: hidden;
	display: block;
	margin: 0 2px 0 0;
	padding: 10px 12px;
	}
.tabbed ul.tabs li a:hover {
    background: none repeat scroll 0 0 #1e8cbe;
    border-color: #0074a2;
    box-shadow: 0 1px 0 rgba(120, 200, 230, 0.6) inset;
    color: #fff;
	}

/* The current selected tab */
.tabbed ul.tabs li a.tab-current {
	}

/* The content shown when a tab is selected */
.tabbed div {
	float: left;
	display: block;
	width: 100%;
	}

/* Set the CSS to make sure the other tabs' content isn't shown other than the first */
.tabbed div.t2, .tabbed div.t3, .tabbed div.t4 {
	display: none;
	}

/* Content for inside your tabs' divs */
.tabbed div ul {
	}
.tabbed div p {
	}
.tabbed div div {
	}
    
</style>
<script>
    $=jQuery.noConflict();
$(document).ready(function() {
// setting the tabs in the sidebar hide and show, setting the current tab
	$('div.tabbed div').hide();
	$('div.t1').show();
        $('div.t1 div').show();
	$('div.tabbed ul.tabs li.t1 a').addClass('tab-current');

// SIDEBAR TABS
$('div.tabbed ul li').click(function(){
//    alert('asasas');
	var thisClass = this.className.slice(0,2);
        if(!thisClass){alert('aaaaa');}
	$('div.tabbed div').hide();
	$('div.' + thisClass ).show();
        $('div.' + thisClass +' div').show();
	$('div.tabbed ul.tabs li a').removeClass('tab-current');
	$(this).addClass('tab-current');
	});
});
</script>
<div class="wrap"><div id="icon-tools" ></div>

<?php // IF COMPANY AVAILABLE ?>
<?php if ($company_full->id && $MODE === 'confirm') : ?>
	<div><h2>Confirmation</h2></div>
	<form method="POST">
	<?php if ($action === 'activate') : ?>
		<div><h2>Are you sure you want to activate <strong><?php echo $company_full->company_name; ?></strong>?</h2></div>
		<div>&nbsp;</div>
		<input type="hidden" name="action" id="action" value="confirm_activate" />
		<input type="hidden" name="company_id" id="company_id" value="<?php echo $company_full->id; ?>" />
		<input type="submit" name="btn_do_activate" id="btn_do_activate" value="Activate" class="button button-primary">		
	<?php elseif ($action === 'deactivate') : ?>
		<div><h2>Are you sure you want to de-activate <strong><?php echo $company_full->company_name; ?></strong>?</h2></div>
		<div>&nbsp;</div>
		<input type="hidden" name="action" id="action" value="confirm_deactivate" />
		<input type="hidden" name="company_id" id="company_id" value="<?php echo $company_full->id; ?>" />
		<input type="submit" name="btn_do_deactivate" id="btn_do_deactivate" value="De-Activate" class="button button-primary">		
	<?php elseif ($action === 'delete') : ?>
		<div><h2>Are you sure you want to delete <strong><?php echo $company_full->company_name; ?></strong>?</h2></div>
		<div>&nbsp;</div>
		<p><strong style="color:red;">Warning !</strong> This action is permanent and can not be undone!</p>
		<p>The user account associated with this company also will be deleted.</p>
		<input type="hidden" name="action" id="action" value="confirm_delete" />
		<input type="hidden" name="company_id" id="company_id" value="<?php echo $company_full->id; ?>" />
		<input type="submit" name="btn_do_delete" id="btn_do_delete" value="Delete"  class="button button-primary">		
	<?php endif; ?>
	<input type="button" name="btn_cancel" id="btn_cancel" value="Cancel" onclick="window.location.href=''" class="button button-primary" />
	</form>
        
        
<?php elseif ($company_full->id && $MODE === 'view') : ?>
	<?php $contact_keys = array_keys($company_full->contacts); ?>
    <h2><?php echo $company_full->company_name; ?></h2>
    <p><?php echo $company_full->contacts[$contact_keys[0]]->email; ?></p>
    <div>


      
        <div class="tabbed">
	<!-- The tabs -->
	<ul class="tabs">
	<li class="t1"><a class="t1 tab" title="<?php _e('Tab 1'); ?>">General Information</a></li>
	<li class="t2"><a class="t2 tab" title="<?php _e('Tab 2'); ?>">Business Related</a></li>
	<li class="t3"><a class="t3 tab" title="<?php _e('Tab 3'); ?>">Business Needs</a></li>
        <li class="t4"><a class="t4 tab" title="<?php _e('Tab 4'); ?>">Other Questions</a></li>
	</ul>

	<!-- tab 1 -->
	<div class="t1">
	<!-- Put what you want in here.  For the sake of this tutorial, we'll make a list.  -->
        <table class="wp-list-table widefat">
            <tr>
                <td colspan="4"><h3>Account Details</h3><td></tr>
            <tr>
                <td><label  class="col-md-5 control-label">Company name:</label></td>
                <td><input readonly="readonly" type="text" name="company_name" value="<?php echo isset($company_full->company_name) ? $company_full->company_name : ""; ?>"  ></td>
                <td><label  class="col-md-5 control-label">Email:</label></td>
                <td> <input readonly="readonly" type="text" id="contact_email" name="contact_email"  value="<?php echo isset($email) ? $email:""; ?>" <?php echo isset($email) ? "readonly='readonly'":""; ?> ></td>
            </tr>
            <tr>
                <td><label  class="col-md-5 control-label">Country of incorporation:</label></td>
                <td>
                    <?php
                    if (function_exists('biz_portal_get_country_list'))
                        {
                        $countries = biz_portal_get_country_list();
                        
                        }?><?php 
                        if($mtype == "TYPE_INTL"){  ?>
                    <select id="country_of_incorporate" name="country_of_incorporate" >
                        <?php
                        foreach($countries as $country){
                            echo "<option value='".$country['id'] ."'  ";
                            echo (($company_full->country_of_incorporate == $country['id'])) ? "selected":"";
                            echo " >". $country['country_name'] ."</option>";
                            
                        }
                        ?>
                    </select>
                        <?php } else {  ?>
                    <input readonly="readonly" type="text" value="Myanmar" disabled="disabled" />
                    <input readonly="readonly" type="hidden" id="country_of_incorporate" name="country_of_incorporate" value="<?php echo get_option('sme_default_country'); ?>" />
                       <?php  } ?>
                </td>
                <td><label  class="col-md-5 control-label">Location of head office:</label></td>
                <td><input readonly="readonly" type="text" name="location_head_office"  value="<?php echo isset($company_full->location_head_office) ? $company_full->location_head_office : ""; ?>"></td>
            </tr>
            <tr>
                <td><label  class="col-md-5 control-label">Year of incorporation:</label></td>
                <td><input readonly="readonly" type="text" name="year_of_incorporate" value="<?php echo isset($company_full->year_of_incorporate) ? $company_full->year_of_incorporate : ""; ?>" maxlength="4"  ></td>
                <td><label  class="col-md-5 control-label">CEO / Managing Director:</label></td>
                <td><input readonly="readonly" type="text" name="ceo_md"  value="<?php echo isset($company_full->ceo_md) ? $company_full->ceo_md : ""; ?>"></td>
            </tr>
            <tr>
                <td><label  class="col-md-5 control-label">Business Registration:</label></td>
                <td><input readonly="readonly" type="text"  name="reg_number" id="business_registration" readonly="readonly" value="<?php echo isset($company_full->reg_number) ? $company_full->reg_number : ""; ?>"  ></td>
                <td><label  class="col-md-5 control-label">Other Branches:</label></td>
                <td><input readonly="readonly" type="text" name="other_branch"  value="<?php echo isset($company_full->other_branch) ? $company_full->other_branch : ""; ?>"></td>
            </tr>
            <tr>
                <td colspan="4"><h3>Mailing Address</h3></td>
            </tr>
            <tr>
                <td><label  class="col-md-5 control-label" for="address_number">Address 1:</label></td>
                <td><input readonly="readonly" type="text" name="address_number"  value="<?php echo isset($address1) ? $address1 : ""; ?>"></td>
                <td><label  class="col-md-5 control-label" for="address_street">Address 2:</label></td>
                <td><input readonly="readonly" type="text" name="address_street" value="<?php echo isset($address2) ? $address2 : ""; ?>"></td>
            </tr>
            <tr>
                <td><label  class="col-md-5 control-label">Town/City</label></td>
                <td><input readonly="readonly" type="text" name="address_city" value="<?php echo isset($city) ? $city : ""; ?>"></td>
                <td><label  class="col-md-5 control-label">Postal Code: </label></td>
                <td><input readonly="readonly" type="text" name="address_postal_code"  value="<?php echo isset($postal) ? $postal : ""; ?>"></td>
            </tr>
            <tr>
                <td><label  class="col-md-5 control-label">State/Region</label></td>
                <td><input readonly="readonly" type="text" name="address_region" value="<?php echo isset($state_region) ? $state_region : ""; ?>"></td>
                <td><label  class="col-md-5 control-label">Country:</label></td>
                <td><?php
                if (function_exists('biz_portal_get_country_list'))
                    {
                    $countries = biz_portal_get_country_list();
                    }
                    ?>
                    <select id="address_country" name="address_country" >
                        <?php
                            foreach($countries as $country){
                                    echo "<option value='".$country['id'] ."'  ";
                                    echo ($company_full->country_of_incorporate == $country['id']) ? "selected":"";
                                    echo " >". $country['country_name'] ."</option>";
                            }
                            ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="4"><h3>Contact Details</h3></td>
            </tr>
            <tr>
                <td><label  class="col-md-5 control-label">Contact person:</label></td>
                <td><input readonly="readonly" type="text" name="contact_person" value="<?php echo isset($person) ? $person:""; ?>"  ></td>
                <td><label  class="col-md-5 control-label">Position title:</label></td>
                <td><input readonly="readonly" type="text"  name="contact_position"  value="<?php echo isset($position) ? $position:""; ?>"></td>
            </tr>
            <tr>
                <td><label  class="col-md-5 control-label">Office telephone:</label></td>
                <td><input readonly="readonly" type="text" name="contact_telephone" value="<?php echo isset($telephone) ? $telephone:""; ?>" ></td>
                <td><label  class="col-md-5 control-label">Mobile: </label></td>
                <td><input readonly="readonly" type="text"  name="contact_mobile" value="<?php echo isset($mobile) ? $mobile:""; ?>" ></td>
            </tr>
            <tr>
                <td><label  class="col-md-5 control-label">Fax:</label></td>
                <td><input readonly="readonly" type="text" name="contact_fax"  value="<?php echo isset($fax) ? $fax:""; ?>"></td>
                <td><label  class="col-md-5 control-label">Website:</label></td>
                <td><input readonly="readonly" type="text"   name="contact_web" value="<?php echo isset($web) ? $web:""; ?>"></td>
            </tr>
            
        </table>

	</div>

	<!-- tab 2 -->
	<div class="t2">
            <table class="wp-list-table widefat">
                <tr><td colspan="3"><h2>Business Related Information</h2></td></tr>
                <tr>
                    <td ><h4>Type of business</h4></td>
                    <td colspan="2"><h4>Industry where company operates</h4></td>
                </tr>
                <tr>
                    <td class="checkbox-list"><?php foreach($biz_type as $biz):  ?>
                        <p><label>
                            <input type="checkbox" name="company_biz_types[]" value="<?php echo $biz['id']; ?>" data-title="<?php echo $biz['type_text']; ?>" <?php  if (!is_null($biz_related_type)) echo (in_array($biz['id'], $biz_related_type)) ? "checked='checked'" : "";  ?>> <?php echo $biz['type_text']; ?>
                        </label></p>
                    <?php endforeach;  ?>
                     <?php
                     if ((!is_null($biz_related_type))){
                         $biz_related_type_other = "";
                            foreach($company_full->biz_types as $biz):
                                if(($biz->is_user_value == 1)){
                                    $biz_related_type_other = $biz->type_text;
                                    break;
                                    }
                                    endforeach;	

                           } else {
                                   $biz_related_type_other = "";
                           }
                          ?><br/>
                        Other, Please specify: 
                        <input readonly="readonly" type="text" name="company_biz_types_other"  value="<?php echo $biz_related_type_other; ?>" >
                    </td>
                    <td> <?php
                            $company_industries_total = count($company_industries);
                            $company_industries_left = ceil($company_industries_total / 2);

                            for($i = 0; $i < $company_industries_left; $i++):

                      ?><p><label><input disabled="disabled" type="checkbox" name="company_industries[]" value="<?php echo $company_industries[$i]['id']; ?>" 
                                    data-title="<?php echo $company_industries[$i]['ind_name']; ?>" <?php if (!is_null($biz_related_industry)) echo (in_array($company_industries[$i]['id'],$biz_related_industry)) ? "checked='checked'":"";  ?>  > <?php echo $company_industries[$i]['ind_name']; ?></label></p>
                                        <?php  endfor;  ?>
                    </td>
                    <td>
                        <?php for($i = $company_industries_left; $i < $company_industries_total; $i++): ?>
                            <p><label><input disabled="disabled" type="checkbox" name="company_industries[]" value="<?php echo $company_industries[$i]['id']; ?>" 
                                             data-title="<?php echo $company_industries[$i]['ind_name']; ?>" <?php if (!is_null($biz_related_industry)) echo (in_array($company_industries[$i]['id'],$biz_related_industry)) ? "checked='checked'":"";  ?>  > <?php echo $company_industries[$i]['ind_name']; ?></label></p>
                         <?php endfor;  ?>
                    </td>
                </tr>
                <tr>
                    <td ><h4>Annual turnover or revenue(USD:</h4></td>
                    <td colspan="2"><h4>Number of employees:</h4></td>
                </tr>
                <tr>
                    <td ><?php $turnover = $company_full->turnover_min . ',' . $company_full->turnover_max;  

                              $turnovers = array();
                              if ($member_type == BP_MemberType::TYPE_INTL){
                                  $turnovers = $Company_Filter->turnover_values_intl;
                              }
                              else if ($member_type == BP_MemberType::TYPE_SME) {
                                  $turnovers = $Company_Filter->turnover_values;
                              }

                              foreach ($turnovers as $turnover) :?>
                              <?php $checked_value = ($company_full->turnover_min == $turnover['value_min'] && $company_full->turnover_max == $turnover['value_max']) ? "checked='checked'" : ""; ?>
                                  <p><label>
                                    <input disabled="disabled" type="radio" name="turnover" value="<?php echo $turnover['value_min'] . ',', $turnover['value_max'] ?>" data-title="<?php echo $turnover['text'] ?>" <?php echo $checked_value;  ?>> <?php echo $turnover['text'] ?>
                                 </label></p>
                              <?php endforeach; ?>
                    </td>
                    <td colspan="2">
                        <?php $employees = $company_full->num_employee_min . ',' . $company_full->num_employee_max;  ?>
                             <?php
                              $num_emps = array();
                              if ($member_type == BP_MemberType::TYPE_INTL) {
                                  $num_emps = $Company_Filter->number_of_employees_intl;
                              }
                              else {
                                  $num_emps = $Company_Filter->number_of_employees;
                              }
                              ?>
                              <?php foreach ($num_emps as $num_emp) :?>
                              <?php $checked_value = ($BP_Company->num_employee_min == $num_emp['value_min'] && $BP_Company->num_employee_max == $num_emp['value_max']) ? "checked='checked'" : ""; ?>
                                  <p><label>
                                    <input disabled="disabled" type="radio" name="num_employee" value="<?php echo $num_emp['value_min'] . ',' . $num_emp['value_max'] ?>" data-title="<?php echo $num_emp['text'] ?>"  <?php echo $checked_value;  ?> > <?php echo $num_emp['text'] ?>
                                 </label></p>
                      <?php endforeach; ?>
                    </td>
                </tr>
                <tr><td colspan="3"><h4>Summary of company’s background and business activities</h4></td></tr>
                <tr>
                    <td colspan="3">
                        <textarea readonly="readonly" rows="3" cols="100" name="summary"><?php echo isset($company_full->summary) ? $company_full->summary : "" ;  ?></textarea>
                    </td>
                </tr>
             </table>
	</div>

	<!-- tab 3 -->
	<div class="t3">
            <table class="wp-list-table widefat">
                <tr style="background-color: #d9edf7;">
                    <td><h4><input disabled="disabled" type="checkbox" name="biz_need_partner" value="1" data-title="Partner in"  <?php echo (isset($company_full->bool_biz_need_partner_in)) ? "checked='checked'":""; ?> > Partner(s) in </h4></td>
                    <td><h4><?php if($mtype == "TYPE_INTL"){ ?>
                            <input  disabled="disabled" type="checkbox" name="biz_give_invest" value="1" data-title="Investors" <?php echo (isset($BP_Company_Full->bool_biz_give_invest)) ? "checked='checked'":""; ?>> Investors
                    <?php }else{?>
                            <input type="checkbox" name="biz_need_invest" value="1" data-title="Investors" <?php echo (isset($company_full->bool_biz_need_invest)) ? "checked='checked'":""; ?>> Investors 
                    <?php }?></h4>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?php	foreach($biz_needs_partner_in as $biz_need_partner):	?>
                        <p><label >
                            <input disabled="disabled" type="checkbox" name="biz_needs_partner_in[]"  value="<?php echo $biz_need_partner['id'];  ?>" 
                                   data-title="<?php echo $biz_need_partner['type_text'];  ?>"  <?php
                                                                                                   if(!empty($biz_need_partner_biz_types)){
                                                                                                       if(in_array($biz_need_partner['id'],$biz_need_partner_biz_types)){
                                                                                                           echo "checked='checked'";    
                                                                                                       } else {echo "";	}
                                                                                                       } else { echo "";} ?> >
                        </label>
                        <label  style="margin-right:20px; text-align:left">
                            <?php echo $biz_need_partner['type_text'];  ?>
                        </label></p>
                            <?php endforeach;  ?>
                                <?php if ((!empty($biz_need_partner_biz_types))){
                                    $biz_need_partner_biz_type_other = "";
                                    foreach($company_full->biz_need_partner_biz_types as $biz_partner):
                                        if(($biz_partner->is_user_value == 1)){
                                            $biz_need_partner_biz_type_other = $biz_partner->type_text;
                                            break;
                                            }
                                            endforeach;	} else {$biz_need_partner_biz_type_other = "";}
                                    ?>


                              
                           <label   style="text-align:left">Other, Please Specify </label><br>
                           <input type="text" name="biz_needs_partner_other" value="<?php echo $biz_need_partner_biz_type_other; ?>" >
                           <br/>
                           <h4>Industry</h4>

                               <?php foreach($biz_needs_partner_in_ind as $biz_needs_partner_ind):	?>
                                   <p><label >
                                       <input disabled="disabled" type="checkbox" name="biz_needs_partner_in_ind[]"  value="<?php echo $biz_needs_partner_ind['id'];  ?>" 
                                              data-title="<?php echo $biz_needs_partner_ind['ind_name'];  ?>" <?php 
                                                                                                                 if(!empty($biz_need_partner_industries)){
                                                                                                                         if(in_array($biz_needs_partner_ind['id'],$biz_need_partner_industries)){
                                                                                                                                 echo "checked='checked'";
                                                                                                                         } else {
                                                                                                                                 echo "";
                                                                                                                         }
                                                                                                                 } else {
                                                                                                                         echo "";
                                                                                                                 }

                                                                                                                 ?>  >
                                    </label>
                                    <label   style="margin-right:20px; text-align:left">
                                       <?php echo $biz_needs_partner_ind['ind_name'];  ?>
                                   </label>
                                   </p>
                                <?php endforeach;  ?>

                                 <?php if ((!empty($biz_need_partner_industries))){

                                                    $biz_need_partner_ind_other = "";
                                                    foreach($company_full->biz_need_partner_industries as $biz_partner):
                                                            if(($biz_partner->is_user_value == 1)){
                                                                    $biz_need_partner_ind_other = $biz_partner->ind_name;
                                                                    break;
                                                            }
                                                    endforeach;	

                                       } else {
                                               $biz_need_partner_ind_other = "";
                                       }
                                      ?>
                                    <label   style="text-align:left">Other, Please Specify </label><br>
                                           <input type="text" name="biz_needs_partner_in_ind_other"  value="<?php echo  $biz_need_partner_ind_other; ?>">
                    </td>
                    <td>
                        <?php if($mtype == "TYPE_INTL"){ ?>
                         <?php $biz_give_invest_default =  $company_full->biz_give_investment->min . ',' . $company_full->biz_give_investment->max; ?>
                        <p><label ><input type="radio" name="biz_give_invest_amount"  value="0,1000000" data-title="Up to 1,000,000 USD"  
                                                            <?php echo ($biz_give_invest_default == '0,1000000') ? "checked='checked'":"";  ?>>
                            </label>
                            <label  style="margin-right:20px; text-align:left">a.	Up to 1,000,000 USD</label></p>
                        <p><label ><input type="radio" name="biz_give_invest_amount"  value="1000001,2000000" data-title="1,000,001 – 2,000,000 USD" 
                                                            <?php echo ($biz_give_invest_default == '1000001,2000000') ? "checked='checked'":"";  ?>>
                            </label>
                            <label  style="margin-right:20px; text-align:left">b.	1,000,001 – 2,000,000 USD</label></p>
                        <p><label >input type="radio" name="biz_give_invest_amount"  value="2000001,5000000" data-title="2,000,001 – 5,000,000 USD" 
                                                            <?php echo ($biz_give_invest_default == '2000001,5000000') ? "checked='checked'":"";  ?>>
                            </label>
                            <label  style="margin-right:20px; text-align:left">c.	2,000,001 – 5,000,000 USD</label></p>
                        <p><label ><input type="radio" name="biz_give_invest_amount"  value="5000000,0" data-title="Over 5,000,000 USD" 
                                                              <?php echo ($biz_give_invest_default == '5000000,0') ? "checked='checked'":"";  ?>>
                            </label>
                            <label  style="margin-right:20px; text-align:left">d.	Over 5,000,000 USD</label></p>
                        
                        
                        <p><label  style="margin-right:20px; text-align:left"> e. SME employee size to invest in</label></p>
        
       <?php $biz_give_invest_employee =  $company_full->biz_give_investment->sme_employee_min . ',' . $company_full->biz_give_investment->sme_employee_max; ?>
       
       <p><label >
       <input type="radio" name="biz_give_invest_emp_size"  value="1,50" data-title="1 - 50" <?php echo ($biz_give_invest_employee == '1,50') ? "checked='checked'":"";  ?>>
       </label>
       <label   style="margin-right:20px; text-align:left">1 - 50</label></p>
       
       <p><label ><?php echo ($biz_give_invest_employee == '51,100') ? "checked='checked'":"";  ?>></label>
       <label   style="margin-right:20px; text-align:left">51 - 100</label></p>
       
       <p><label >
       <input type="radio"  name="biz_give_invest_emp_size"  value="101,200" data-title="101 - 200" <?php echo ($biz_give_invest_employee == '101,200') ? "checked='checked'":"";  ?>>
       </label>
       <label   style="margin-right:20px; text-align:left">101 - 200</label></p>
       
       <p><label >
       <input type="radio" name="biz_give_invest_emp_size"  value="200,0" data-title="200+" <?php echo ($biz_give_invest_employee == '200,0') ? "checked='checked'":"";  ?>>
       </label>
       <label   style="margin-right:20px; text-align:left">200+</label></p>
       
       <p><label >
       <input type="radio" name="biz_give_invest_emp_size"  value="0,0" data-title="No Requirement" <?php echo ($biz_give_invest_employee == '0,0') ? "checked='checked'":"";  ?>>
       </label>
       <label   style="margin-right:20px; text-align:left">No Requirement</label><p>
       
  <!-- Industry to invest  -->      
  <p><label  style="margin-right:20px; text-align:left">f. Industry to invest in</label></p>
	  <?php	foreach($company_industries as $company_ind):	?>
      <p style="margin-left:30px"><label >
      <input type="checkbox" name="biz_give_invest_ind[]"  value="<?php echo $company_ind['id']; ?>" 
                            data-title="<?php echo $company_ind['ind_name']; ?>"  
                            <?php if(!empty($biz_give_invest_industries)){
                                    if(in_array($company_ind['id'],$biz_give_invest_industries)){
                                                        echo "checked='checked'";
                                                        } else {echo "";}
                                                        } else {echo "";}?>  >
      </label>
      <label  style="margin-right:20px;text-align:left"><?php echo $company_ind['ind_name']; ?></label></p>
      <?php endforeach;  ?>
      <?php
            $biz_give_invest_ind_other = "";
            if(!empty($biz_give_invest_industries)){

                    foreach($company_full->biz_give_investment->industries as $biz_give_invest){
                            if($biz_give_invest->is_user_value == 1){
                                    $biz_give_invest_ind_other = $biz_give_invest->ind_name;
                                    break;
                            }
                    }

            } else {
                    $biz_give_invest_ind_other = "";
            }
            ?>                                                                         
     <label style="text-align:left">Other, Please Specify </label><br>
     <input type="text" name="biz_give_invest_ind_other"  value="<?php echo $biz_give_invest_ind_other;  ?>">
     
     
      <!-- Turnover requirement   -->
      <p><label style="text-align:left">g.	Turnover requirement</label></p>
      <?php $biz_give_invest_turnover =  $company_full->biz_give_investment->turnover_min . ',' . $company_full->biz_give_investment->turnover_max; ?>
       
       <p style="margin-left:30px"><label >
       <input type="radio" name="biz_give_invest_turnover"  value="0,1000000" data-title="Up to 1,000,000" <?php echo ($biz_give_invest_turnover == '0,1000000') ? "checked='checked'":"";  ?>>
       </label>
            <label style="margin-right:40px;text-align:left">Up to 1,000,000 </label></p>
       <p style="margin-left:30px"><label >
            <input type="radio" name="biz_give_invest_turnover"  value="1000001,2000000" data-title="1,000,001-2,000,000" <?php echo ($biz_give_invest_turnover == '1000001,2000000') ? "checked='checked'":"";  ?>>
       </label>
            <label style="margin-right:40px;text-align:left">1,000,001-2,000,000 </label></p>
       <p style="margin-left:30px"><label ><input type="radio" name="biz_give_invest_turnover"  value="2000001,5000000" data-title="2,000,001-5,000,000" <?php echo ($biz_give_invest_turnover == '2000001,5000000') ? "checked='checked'":"";  ?>></label>
             <label style="margin-right:40px;text-align:left">2,000,001-5,000,000 </label></p>
       <p style="margin-left:30px"><label ><input type="radio" name="biz_give_invest_turnover"  value="5000000,0" data-title="5,000,000+" <?php echo ($biz_give_invest_turnover == '5000000,0') ? "checked='checked'":"";  ?>></label> 
            <label  style="margin-right:40px;text-align:left">5,000,000+</label></p>
       <p style="margin-left:30px"><label > 	<input type="radio" name="biz_give_invest_turnover"  value="0,0" data-title="No Requirement" <?php echo ($biz_give_invest_turnover == '0,0') ? "checked='checked'":"";  ?>></label>
            <label  style="margin-right:40px;text-align:left">No Requirement</label></p>
        <!-- Turnover requirement  -->
        
        <!-- Years in business   -->
        <p><label  style="margin-right:40px;text-align:left"> h. Years in Business Requirements</label></p>
        <?php $biz_give_invest_year =  $company_full->biz_give_investment->years_in_biz_min . ',' . $company_full->biz_give_investment->years_in_biz_max; ?>
       
        <p style="margin-left:30px"><label  ><input type="radio" name="biz_give_invest_yrs"  value="0,2" data-title="0 - 2 Years" <?php echo ($biz_give_invest_year == '0,2') ? "checked='checked'":"";  ?>></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">0 - 2 Years</label></p>
        <p style="margin-left:30px"><label  ><input type="radio" name="biz_give_invest_yrs"  value="2,5" data-title="2 - 5 Years" <?php echo ($biz_give_invest_year == '2,5') ? "checked='checked'":"";  ?>></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">2 - 5 Years </label></p>
        <p style="margin-left:30px"><label  ><input type="radio" name="biz_give_invest_yrs"  value="5,10" data-title="5 - 10 Years" <?php echo ($biz_give_invest_year == '5,10') ? "checked='checked'":"";  ?>></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">5 - 10 Years </label></p>
        <p style="margin-left:30px"><label  ><input type="radio" name="biz_give_invest_yrs"  value="10,0" data-title="10 Years +" <?php echo ($biz_give_invest_year == '10,0') ? "checked='checked'":"";  ?>></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">10 Years +</label>></p>
        <p style="margin-left:30px"><label  > <input type="radio" name="biz_give_invest_yrs"  value="0,0" data-title="No Requirement" <?php echo ($biz_give_invest_year == '0,0') ? "checked='checked'":"";  ?>> </label>
       <label  style="margin-right:40px; text-align:left">No Requirement</label></p>
       <!-- Years in business  -->
      
           <?php } else {  ?>
            <!--------------------  Local Myanmar SME Need Investors  ---------------------->
                <?php $biz_need_invest_default =  $company_full->biz_need_investment->min . ',' . $company_full->biz_need_investment->max; ?>
            <p><label >
                <input type="radio" name="biz_need_invest_amount"  value="0,1000000" data-title="Up to 1,000,000 USD" <?php echo ($biz_need_invest_default == "0,1000000") ? "checked='checked'":""; ?> >
            </label>
            <label  style="margin-right:20px; text-align:left">a.	Up to 1,000,000 USD</label></p>
            <p><label >
                <input type="radio" name="biz_need_invest_amount"  value="1000001,2000000" data-title="1,000,001 – 2,000,000 USD" <?php echo ($biz_need_invest_default == "1000001,2000000") ? "checked='checked'":""; ?>>
            </label>
            <label  style="margin-right:20px; text-align:left">b.	1,000,001 – 2,000,000 USD</label></p>
            <p><label >
                <input type="radio" name="biz_need_invest_amount"  value="2000001,5000000" data-title="2,000,001 – 5,000,000 USD" <?php echo ($biz_need_invest_default == "2000001,5000000") ? "checked='checked'":""; ?>>
            </label>
            <label  style="margin-right:20px; text-align:left">c.	2,000,001 – 5,000,000 USD</label></p>
            <p><label >
                <input type="radio" name="biz_need_invest_amount"  value="5000000,0" data-title="Over 5,000,000 USD"  <?php echo ($biz_need_invest_default == "5000000,0") ? "checked='checked'":""; ?> >
            </label>
            <label  style="margin-right:20px; text-align:left">d.	Over 5,000,000 USD</label></p>
            
            
            <p><label  style="margin-right:20px; text-align:left">e. SME employee size to invest in</label></p>
                <?php $biz_need_invest_employee =  $company_full->biz_need_investment->sme_employee_min . ',' . $company_full->biz_need_investment->sme_employee_max; ?>             


            <p style="margin-left:30px"><label >
            <input type="radio" name="biz_need_invest_emp_size"  value="1,50" data-title="1 - 50"  <?php echo ($biz_need_invest_employee == "1,50") ? "checked='checked'":"";  ?> >
            </label>
            <label   style="margin-right:20px; text-align:left">1 - 50</label></p>
            
            <p style="margin-left:30px"><label >
            <input type="radio" name="biz_need_invest_emp_size"  value="51,100" data-title="51 - 100" <?php echo ($biz_need_invest_employee == "51,100") ? "checked='checked'":"";  ?> >
            </label>
            <label   style="margin-right:20px; text-align:left">51 - 100</label></p>
            
            <p style="margin-left:30px"><label >
            <input type="radio"  name="biz_need_invest_emp_size"  value="101,200" data-title="101 - 200" <?php echo ($biz_need_invest_employee == "101,200") ? "checked='checked'":"";  ?> >
            </label>
            <label   style="margin-right:20px; text-align:left">101 - 200</label></p>
            
            <p style="margin-left:30px"><label >
            <input type="radio" name="biz_need_invest_emp_size"  value="200,0" data-title="200+" <?php echo ($biz_need_invest_employee == "200,0") ? "checked='checked'":"";  ?>>
            </label>
            <label   style="margin-right:20px; text-align:left">200+</label></p>
    
            <p style="margin-left:30px"><label >
            <input type="radio" name="biz_need_invest_emp_size"  value="0,0" data-title="No Requirement" <?php echo ($biz_need_invest_employee == "0,0") ? "checked='checked'":"";  ?>>
            </label>
            <label   style="margin-right:20px; text-align:left">No Requirement</label></p>
            


            <!-- Industry to invest  -->
            <p><label  style="margin-right:20px; text-align:left">f. Industry to invest in</label></p>
                <?php	foreach($biz_needs_invest_in_ind as $biz_needs_invest_ind):	?> 

                    <p style="margin-left:30px"><label >
                    <input type="checkbox" name="biz_need_invest_ind[]"  value="<?php echo $biz_needs_invest_ind['id'];  ?>" 
                           data-title="<?php echo $biz_needs_invest_ind['ind_name'];  ?>"
                               <?php 
                                        if(!empty($biz_need_invest_industries)){
                                                if(in_array($biz_needs_invest_ind['id'],$biz_need_invest_industries)){
                                                        echo " checked='checked' ";
                                                } else {
                                                        echo "";	
                                                }
                                        } else {
                                                echo "";	
                                        }
                                        ?> >
                    </label>
                    <label  style="margin-right:20px;text-align:left"><?php echo $biz_needs_invest_ind['ind_name'];  ?> </label><p>
                <?php endforeach;  ?>



            <?php
                if(!empty($biz_need_invest_industries)){
                        $biz_need_invest_ind_other = "";
                        foreach($company_full->biz_need_investment->industries as $biz_need_invest){
                                if($biz_need_invest->is_user_value == 1){
                                        $biz_need_invest_ind_other = $biz_need_invest->ind_name;
                                }
                        }

                } else {
                        $biz_need_invest_ind_other = "";
                }
                ?>
            <label   style="text-align:left">Other, Please Specify </label><br>
            <input type="text" name="biz_need_invest_ind_other"  value="<?php  echo $biz_need_invest_ind_other; ?>">  <!-- form-group  -->


            <!-- Turnover requirement   -->
            <p><label  style="margin-right:20px; text-align:left">g.	Turnover requirement</label></p>
            <?php $biz_need_invest_turnover = $company_full->biz_need_investment->turnover_min . ',' . $company_full->biz_need_investment->turnover_max;  ?>
            
            <p style="margin-left:30px"><label  ><input type="radio" name="biz_need_invest_turnover"  value="0,1000000" data-title="Up to 1,000,000" <?php echo ($biz_need_invest_turnover == "0,1000000") ? "checked='checked'":""; ?> ></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">Up to 1,000,000 </label></p>
            <p style="margin-left:30px"><label  ><input type="radio" name="biz_need_invest_turnover"  value="1000001,2000000" data-title="1,000,001-2,000,000" <?php echo ($biz_need_invest_turnover == "1000001,2000000") ? "checked='checked'":""; ?> ></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">1,000,001-2,000,000 </label></p>
            <p style="margin-left:30px"><label  ><input type="radio" name="biz_need_invest_turnover"  value="2000001,5000000" data-title="2,000,001-5,000,000" <?php echo ($biz_need_invest_turnover == "2000001,5000000") ? "checked='checked'":""; ?> ></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">2,000,001-5,000,000 </label></p>
            <p style="margin-left:30px"><label  ><input type="radio" name="biz_need_invest_turnover"  value="5000000,0" data-title="5,000,000+" <?php echo ($biz_need_invest_turnover == "5000000,0") ? "checked='checked'":""; ?> ></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">5,000,000+</label></p>
            <p style="margin-left:30px"><label  ><input type="radio" name="biz_need_invest_turnover"  value="0,0" data-title="No Requirement" <?php echo ($biz_need_invest_turnover == "0,0") ? "checked='checked'":""; ?>></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">No Requirement</label></p>
            <!-- Turnover requirement  -->

            <!-- Years in business   -->
            <p><label  style="margin-right:20px; text-align:left">h. Years in Business Requirements</label></p>
            <?php $biz_need_invest_years = $company_full->biz_need_investment->years_in_biz_min . ',' . $company_full->biz_need_investment->years_in_biz_max;  ?>
            
            <p style="margin-left:30px"><label  ><input type="radio" name="biz_need_invest_yrs"  value="0,2" data-title="0 - 2 Years" <?php echo ($biz_need_invest_years == "0,2") ? "checked='checked'":""; ?>></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">0 - 2 Years</label></p>
            <p style="margin-left:30px"><label  ><input type="radio" name="biz_need_invest_yrs"  value="2,5" data-title="2 - 5 Years" <?php echo ($biz_need_invest_years == "2,5") ? "checked='checked'":""; ?>></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">2 - 5 Years </label></p>
            <p style="margin-left:30px"><label  ><input type="radio" name="biz_need_invest_yrs"  value="5,10" data-title="5 - 10 Years" <?php echo ($biz_need_invest_years == "5,10") ? "checked='checked'":""; ?>></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">5 - 10 Years </label></p>
            <p style="margin-left:30px"><label  ><input type="radio" name="biz_need_invest_yrs"  value="10,0" data-title="10 Years +" <?php echo ($biz_need_invest_years == "10,0") ? "checked='checked'":""; ?>></label>
            <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">10 Years +</label></p>
            <p style="margin-left:30px"><label  > <input type="radio" name="biz_need_invest_yrs"  value="0,0" data-title="No Requirement" <?php echo ($biz_need_invest_years == "0,0") ? "checked='checked'":""; ?>> </label>
            <label  class="col-md-6 control-label" style="margin-right:40px; text-align:left">No Requirement</label></p>
            

            <?php  } ?>
                    </td>
                </tr>
                <tr style="background-color: #d9edf7;">
                    <td><h4><?php if($mtype == "TYPE_INTL"){ ?>
                        <input type="checkbox" name="biz_give_service_provide_bool" value="1" data-title="Service Provider" <?php echo (isset($BP_Company_Full->bool_biz_give_service)) ? "checked='checked'":""; ?>  > Service Provider 
                    <?php }else{?>
                        <input type="checkbox" name="biz_needs_service_provide_bool" value="1" data-title="Service Provider" <?php echo (isset($BP_Company_Full->bool_biz_need_service)) ? "checked='checked'":""; ?> > Service Provider
                    <?php }?>
                        </h4></td>
                    <td><h4><?php if($mtype == "TYPE_INTL"){ ?>
                        <input type="checkbox" name="biz_need_ngo_supp_serv" value="1" data-title="Non-Profit Organization" <?php echo (isset($BP_Company_Full->bool_biz_need_ngo_supp_serv)) ? "checked='checked'":""; ?>  > Provide Support/Services as Non-Profit Organization
                     <?php }?>
                        </h4></td>
                </tr>
                <tr>
                    <td>
                        <!--------------------  Service Provider  ---------------------->
                 <?php if($mtype == "TYPE_INTL"){ ?>
                 <?php foreach($service_provider as $service):  ?>
                        <p><label >
                            <input type="checkbox" name="biz_give_service_provide[]"  value="<?php echo $service['id']; ?>" data-title="<?php echo $service['service_name']; ?>"  
                                                                                <?php  if(!empty($biz_give_services)){
                                                                                             if(in_array($service['id'],$biz_give_services)){
                                                                                                     echo "checked='checked'"; 
                                                                                             } else {
                                                                                                    echo "";  
                                                                                             }
                                                                                     } else {
                                                                                            echo ""; 
                                                                                     } 


                                                                                     ?>>
                         </label>
                        <label   style="margin-right:20px; text-align:left"><?php echo $service['service_name']; ?> </label></p>

                 <?php endforeach;  ?>

                 <?php  $biz_give_service_other = "";
                         if(!empty($biz_give_services)){
                             foreach($BP_Company_Full->biz_give_services as $biz_services){
                                        if($biz_services->is_user_value == 1){
                                                $biz_give_service_other = $biz_services->service_name;
                                                break;
                                        }
                                }

                        } else {
                                $biz_give_service_other = "";	
                        }
                        ?>


              <label   style="text-align:left">g. Other, Please Specify </label><br>
               <input type="text" name="biz_give_service_provide_other"  value="<?php echo $biz_give_service_other; ?>">





     <?php  } else {  ?>

     <!-------------------  Local Myanmar Needs Service Provider   ---------------------->
         <?php foreach($service_provider as $service):  ?>  
         <p><label ><input type="checkbox" name="biz_needs_service_provide[]"  value="<?php echo $service['id']; ?>" data-title="<?php echo $service['service_name']; ?>"  
                                                                             <?php /*echo (in_array($service['id'],$biz_need_services)) ? "checked='checked'":"";*/
                                                                             if(!empty($biz_need_services)){
                                                                                     if(in_array($service['id'],$biz_need_services)){
                                                                                             echo "checked='checked'"; 
                                                                                     } else {
                                                                                            echo "";  
                                                                                     }
                                                                             } else {
                                                                                    echo ""; 
                                                                             }
                                                                             ?>>
          </label> 
         <label   style="margin-right:20px; text-align:left"><?php echo $service['service_name']; ?> </label></p>
         <?php endforeach;  ?>
         <?php  
                if(!empty($biz_need_services)){

                        $biz_need_service_other = "";
                        foreach($BP_Company_Full->biz_need_services as $biz_services){
                                if($biz_services->is_user_value == 1){
                                        $biz_need_service_other = $biz_services->service_name;
                                }
                        }

                } else {
                        $biz_need_service_other = "";	
                }

         ?>
         <label   style="text-align:left">g. Other, Please Specify </label><br>
         <input type="text" name="biz_needs_service_provide_other"  value="<?php echo $biz_need_service_other; ?>">
     <?php }  ?>
     <!--------------------  Service Provider  ----------------------> 
     
                        
                    </td>
                    <td><?php if($mtype == "TYPE_INTL"){ ?>	
     <!--------------------  Provide Support/Services as Non-Profit Organization  ----------------------> 

     <?php $biz_need_ngo_supp_serv = $BP_Company_Full->biz_need_ngo_supp_serv;  ?>
     <!-- Organization Type   -->
     <p><label >a.	Organization Type</label></p>
     <p style="margin-left:30px"><label >
         <input type="checkbox" name="biz_need_ngo_supp_serv_org_type_1"  value="1" data-title="Yes" <?php echo (($biz_need_ngo_supp_serv->org_type_development_agency == 1)) ? " checked='checked' ":"";  ?> >
     </label>
     <label   style="margin-right:20px; text-align:left">Development Agency</label></p>
     <p style="margin-left:30px"><label >
         <input type="checkbox" name="biz_need_ngo_supp_serv_org_type_2"  value="1" data-title="Yes" <?php echo (($biz_need_ngo_supp_serv->org_type_chamber_of_commerce == 1)) ? " checked='checked' ":"";  ?> >
     </label>  
     <label   style="margin-right:20px; text-align:left">Chamber of Commerce</label></p>
     <!-- Organization Type  -->
     
     
     <!-- Services Provided   -->
     <p><label >b.	Services Provided</label></p>
     <?php foreach($service_provider as $services):  ?>
     <p style="margin-left:30px"><label >
         <input type="checkbox" name="biz_need_ngo_supp_serv_type[]"  value="<?php echo $services['id']; ?>" 
                data-title="<?php echo $services['service_name']; ?>"  
                       <?php if(!empty($biz_need_ngo_services_provided)){
                                         if(in_array($services['id'],$biz_need_ngo_services_provided)){
                                                 echo "checked='checked'";
                                         } else {
                                                 echo "";
                                         }
                                 } else {
                                         echo "";
                                 }

                                 ?>>
        </label>
        <label   style="margin-right:20px; text-align:left"><?php echo $services['service_name']; ?></label></p>
       <?php endforeach;  ?>

                         <?php
                                $ngo_services_other = "";
                                if(!empty($biz_need_ngo_services_provided)):
                                        foreach($biz_need_ngo_services_provided as $ngo_services):
                                                if($ngo_services['is_user_value'] == 1 ){
                                                        $ngo_services_other = $ngo_services['service_name'];
                                                        break;
                                                }
                                        endforeach;
                                endif;																			 
                         ?>
     <label   style="text-align:left">Other, Please Specify </label><br>
     <input type="text" name="biz_need_ngo_supp_serv_type_other" value="<?php echo $ngo_services_other; ?>">
     
     <!-- Services Provided  -->
     
     
     <!-- If Funding is Provided   -->
     <p><label >c.	If Funding is Provided</label></p>
     <?php $biz_need_ngo_funding = $BP_Company_Full->biz_need_ngo_supp_serv->fund_min . ',' . $BP_Company_Full->biz_need_ngo_supp_serv->fund_max;  ?>
     <p style="margin-left:30px"><label >
         <input type="radio" name="biz_need_ngo_ss_fund"  value="0,50000" data-title="Up to USD $50,000" <?php echo ($biz_need_ngo_funding == '0,50000') ? "checked='checked'":"";  ?>>
     </label>
     <label   style="margin-right:20px; text-align:left">Up to USD $50,000</label></p>
     
     <p style="margin-left:30px"><label >
         <input type="radio" name="biz_need_ngo_ss_fund"  value="51000,100000" data-title="USD $51,000 – 100,000" <?php echo ($biz_need_ngo_funding == '51000,100000') ? "checked='checked'":"";  ?>>
     </label>
     <label   style="margin-right:20px; text-align:left">USD $51,000 – 100,000</label></p>
     
     <p style="margin-left:30px"><label >
         <input type="radio" name="biz_need_ngo_ss_fund"  value="101000,500000" data-title="USD $101,000 – 500,000" <?php echo ($biz_need_ngo_funding == '101000,500000') ? "checked='checked'":"";  ?>>
     </label>
     <label   style="margin-right:20px; text-align:left">USD $101,000 – 500,000</label></p>
     
     <p style="margin-left:30px"><label >
         <input type="radio" name="biz_need_ngo_ss_fund"  value="501000,1000000" data-title="USD $501,000 – 1,000,000" <?php echo ($biz_need_ngo_funding == '501000,1000000') ? "checked='checked'":"";  ?>>
     </label>
     <label   style="margin-right:20px; text-align:left">USD $501,000 – 1,000,000</label></p>
     
     <p style="margin-left:30px"><label >
         <input type="radio" name="biz_need_ngo_ss_fund"  value="1000000,0" data-title="Over USD $1,000,000" <?php echo ($biz_need_ngo_funding == '1000000,0') ? "checked='checked'":"";  ?>>
     </label> 
     <label   style="margin-right:20px; text-align:left">Over USD $1,000,000</label></p>
     
     <!-- If Funding is Provided  -->
     <!--------------------  Provide Support/Services as Non-Profit Organization  ----------------------> 
     <?php }  ?></td>
                </tr>
            </table>
	</div>

	<!-- tab 4 -->
	<div class="t4">
            <table class="wp-list-table widefat">
                <tr><td><h4>Other Questions</h4></td><tr>
                 <?php if($mtype == "TYPE_INTL"){ ?>
                                                
        <?php
            $partner = "";
            $give_invest = "";
            $give_ngo = "";
            $provide_service = "";
            
            if(!empty($BP_Company_Full->biz_need_details)):
                
                foreach($BP_Company_Full->biz_need_details as $detail_id):
                    switch($detail_id->biz_need_type_id){
                                                    case 'PARTNER':
                                                        $partner = $detail_id->detail;
                                                        break;
                                                    case 'NGO_SUPPORT_SERVICE':
                                                        $give_ngo = $detail_id->detail;
                                                        break;
                                                    case 'PROVIDE_INVEST':
                                                        $give_invest = $detail_id->detail;
                                                        break;	
                                                    case 'PROVIDE_SERVICE':
                                                        $provide_service = $detail_id->detail;
                                                        break;
                                                    default:
                                                        $partner = "";
                                                        $give_invest = "";
                                                        $give_ngo = "";	
                                                        $provide_service = "";									
                                            }

                            endforeach;	

                    endif;	
                    ?>

                <tr><td><label>what type of partners you are looking for.</label><br>
                        <textarea rows="3" name="biz_need_detail_partner"><?php echo $partner; ?></textarea></td></tr>
                <tr><td><label>For those interested in investing in Myanmar</label><br>
                        <textarea rows="3" name="biz_give_detail_invest"><?php echo $give_invest; ?></textarea></td></tr>
                <tr><td></td><label>Looking for service providers or to provide services</label><br>
                        <textarea rows="3" name="biz_give_detail_sp"><?php echo $provide_service; ?></textarea></td></tr>
                <tr><td><label>Provide Support/Services as NonProfit Organization</label><br>
                        <textarea rows="3" name="biz_need_detail_ngo"><?php echo $give_ngo; ?></textarea></td></tr>
        <?php  } else { ?>

        <!-----------------     Myanmar SME Other Questions      ------------------->

        <?php
            $partner = "";
            $need_service = "";
            $need_invest = "";

                    if(!empty($BP_Company_Full->biz_need_details)):

                            $partner = "";
                            $need_service = "";
                            $need_invest = "";
                            foreach($BP_Company_Full->biz_need_details as $detail_id):

                                            switch($detail_id->biz_need_type_id){
                                                    case 'PARTNER':
                                                            $partner = $detail_id->detail;
                                                            break;
                                                    case 'NEED_SERVICE':
                                                                $need_service = $detail_id->detail;
                                                                break;
                                                    case 'NEED_INVEST':
                                                                $need_invest = $detail_id->detail;
                                                                break;	
                                                    default:
                                                                $partner = "";
                                                                $need_service = "";
                                                                $need_invest = "";										
                                            }

                            endforeach;	

                    endif;	
                    ?>

        <tr><td><label>Type of partners you are looking for.</label><br>
        <textarea rows="3" name="biz_need_detail_partner"><?php echo $partner;  ?></textarea></td></tr>
        <tr><td><label>Looking for foreign investors</label><br>
        <textarea rows="3" name="biz_need_detail_invest"><?php echo $need_service;  ?></textarea></td></tr>
        <tr><td><label>Looking for service providers or to provide services</label><br>
        <textarea rows="3" name="biz_need_detail_sp"><?php echo $need_invest;  ?></textarea></td></tr>

        <?php }  ?>
            </table>
	</div>

</div><!-- tabbed -->
</div>

    <div>
    <form method="POST" action="">
    	<input type="hidden" name="action" id="action" value="" />
    	<?php if (!$company_full->active) : ?>
    		<input type="button" name="btn_activate" id="btn_activate" value="Activate" class="button button-primary" />
    		<input type="button" name="btn_delete" id="btn_delete" value="Delete" class="button button-primary" />
    	<?php else: ?>
    		<input type="button" name="btn_deactivate" id="btn_deactivate" value="De-Activate"  class="button button-primary" />
    		<input type="button" name="" id="" value="Delete" disabled="disabled"  class="button button-primary" />
    	<?php endif; ?>    	
    	<input type="button" name="cancel" onclick="window.location.href='?page=admin-list-companies'" value="Go Back" class="button button-primary" />
    
    </form>
    </div>
 </div>



 <script>
jQuery(document).ready(function() {
	//alert('ok');
	BizPortal_Admin.init({rootUrl:'<?php echo site_url(); ?>'});
});
 </script>

<?php else : ?>
<h2>Company not found.</h2>
<?php endif; ?>