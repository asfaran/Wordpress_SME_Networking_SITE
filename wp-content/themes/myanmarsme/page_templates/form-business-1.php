<?php
/*
  Template Name: Form Sign Up
 */
$member_arr = array("TYPE_SME","TYPE_INTL","TYPE_NGO");
$member_type = (isset($_GET['mt'])) ? urldecode(base64_decode($_GET['mt'])) : "" ;  
$mtype = (in_array($member_type, $member_arr)) ? $member_type : "";
 
define('FORM_SME_WIZARD', true, true); 

$company_industries = biz_portal_get_industries_list();


$biz_type = biz_portal_get_business_types_list();
$biz_needs_partner_in = $biz_type;
$biz_needs_partner_in_ind = $company_industries;
$biz_needs_invest_in_ind = $company_industries;	
$service_provider = biz_poratal_get_biz_services_list();
$ngo_biz_type = biz_portal_form_get_ngo_biz_types();
$ngo_biz_services = biz_portal_form_get_ngo_services();

$company_id = biz_portal_get_current_company_id();
$current_profile = null;

$biz_needs = array(
	'biz_need_detail_partner' => '',
	'biz_need_detail_invest' => '',
	'biz_need_detail_sp' => '',
	'biz_give_detail_invest' => '',
	'biz_give_detail_sp' => '',
	'biz_need_detail_ngo' => ''
);
	
if ($company_id > 0)
{
	$BP_Company = biz_portal_get_company($company_id);
	$BP_Company_Full = biz_portal_load_company_relations($BP_Company);	
	
	//print_r($BP_Company_Full);
	
	if(!empty($BP_Company_Full->addresses)):
	
		if (is_array($BP_Company_Full->addresses)) :
				foreach ($BP_Company_Full->addresses as $key => $value) : 
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
	
	if(!empty($BP_Company_Full->contacts)):	
		if (is_array($BP_Company_Full->contacts)) :
				foreach ($BP_Company_Full->contacts as $key => $value) : 
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
	
	$biz_related_type =  (!empty($BP_Company_Full->biz_types)) ? array_keys($BP_Company_Full->biz_types) : "";	
	$biz_related_industry = (!empty($BP_Company_Full->industries)) ? array_keys($BP_Company_Full->industries) : "";
	$biz_need_partner_biz_types = (!empty($BP_Company_Full->biz_need_partner_biz_types)) ? array_keys($BP_Company_Full->biz_need_partner_biz_types) : "";
	$biz_need_partner_industries = (!empty($BP_Company_Full->biz_need_partner_industries)) ? array_keys($BP_Company_Full->biz_need_partner_industries) : "";
	$biz_need_invest_industries = (!empty($BP_Company_Full->biz_need_investment->industries)) ? array_keys($BP_Company_Full->biz_need_investment->industries) : "";
	$biz_need_services = (!empty($BP_Company_Full->biz_need_services)) ? array_keys($BP_Company_Full->biz_need_services) : "";
	$biz_need_details = (!empty($BP_Company_Full->biz_need_details)) ? array_keys($BP_Company_Full->biz_need_details) : "";
	
	$biz_give_invest_industries = (!empty($BP_Company_Full->biz_give_investment->industries)) ? array_keys($BP_Company_Full->biz_give_investment->industries) : "";
	$biz_give_invest_ind = $BP_Company_Full->biz_give_investment->industries;
	
	$biz_give_services = (!empty($BP_Company_Full->biz_give_services)) ? array_keys($BP_Company_Full->biz_give_services) : "";
	
	$biz_need_ngo_services_provided = (!empty($BP_Company_Full->biz_need_ngo_supp_serv->services_provided)) ? array_keys($BP_Company_Full->biz_need_ngo_supp_serv->services_provided) : "";
	
	//print_r($biz_need_invest_industries);

	if(!empty($BP_Company_Full->biz_need_details)):

		foreach($BP_Company_Full->biz_need_details as $detail)
		{
			switch ($detail->biz_need_type_id) {
				case BP_BizNeedType::NEED_INVEST:
					$biz_needs['biz_need_detail_invest'] = $detail->detail;
					break;
				case BP_BizNeedType::PARTNER:
					$biz_needs['biz_need_detail_partner'] = $detail->detail;
					break;
				case BP_BizNeedType::NEED_SERVICE:
					$biz_needs['biz_need_detail_sp'] = $detail->detail;
					break;
				case BP_BizNeedType::PROVIDE_INVEST:
					$biz_needs['biz_give_detail_invest'] = $detail->detail;
					break;
				case BP_BizNeedType::PROVIDE_SERVICE:
					$biz_needs['biz_give_detail_sp'] = $detail->detail;
					break;
				case BP_BizNeedType::NGO_SUPPORT_SERVICE:
					$biz_needs['biz_need_detail_ngo'] = $detail->detail;
					break;				
			}
		}
	
	endif;


}

$BP_Company_Filter = new BP_Company_Filter();

//print_r($service_provider);

get_header();


?>

	
	<!-- BEGIN CONTAINER -->
	<div class="page-container page-body">
    
    	<div class="banner_header">
			<?php if(($mtype == "TYPE_INTL")){ ?>
                <img src="<?php echo get_template_directory_uri(); ?>/images/banner_international.jpg" class="img-responsive max_width" >
            <?php } elseif($mtype == "TYPE_NGO") { ?>
                <img src="<?php echo get_template_directory_uri(); ?>/images/banner_ngo.jpg" class="img-responsive max_width" >
            <?php } else { ?>
                <img src="<?php echo get_template_directory_uri(); ?>/images/banner_sme.jpg" class="img-responsive max_width" >
            <?php  } ?>
        </div>        
		<!-- BEGIN PAGE -->  
		<div class="container margin-bottom-40">
			
			            
			<!-- BEGIN PAGE HEADER-->   
			<div class="row">
				<div class="col-md-12">
					<!-- BEGIN PAGE TITLE & BREADCRUMB-->			
					<h3 class="page-title">&nbsp;</h3>
					<?php //print_r($biz_give_invest_ind); ?>
					<!-- END PAGE TITLE & BREADCRUMB-->
				</div>
			</div>
			<!-- END PAGE HEADER-->
			<!-- BEGIN PAGE CONTENT-->
			<div class="row">
				<div class="col-md-12">
					<div class="portlet" id="form_wizard_1">
						<div class="portlet-title">
							 <div class="caption pull-right">
								<small><span class="step-title"><?php echo ($mtype == "TYPE_SME") ? "Step 1 of 5":"Step 1 of 4"; ?></span></small>
							</div>	
							
						</div>
						<div class="portlet-body form">
							<form action="" class="form-horizontal" id="submit_form" method="post">
								<div class="form-wizard">
									<div class="form-body margin-bottom-40">
										<ul class="nav nav-pills nav-justified steps">
											<li>
												<a href="#tab1" data-toggle="tab" class="step">
												<span class="number">1</span><br />
												<span class="desc"><i class="fa fa-check"></i> General Information</span>   
												</a>
											</li>
											<?php if($mtype == "TYPE_SME"): ?>
                                            <li>
												<a href="#tab2" data-toggle="tab" class="step">
												<span class="number">2</span><br />
												<span class="desc"><i class="fa fa-check"></i> Looking For </span>   
												</a>
											</li>
                                            <?php endif; ?>
											<li>
												<a href="#tab3" data-toggle="tab" class="step">
												<span class="number"><?php echo ($mtype == "TYPE_SME") ? "3":"2";  ?></span><br />
												<span class="desc"><i class="fa fa-check"></i> 
                                                
                                                <?php echo ($mtype == "TYPE_NGO") ? "Services Offered": "Looking To "; ?>
                                                
                                                </span>   
												</a>
											</li>
											<li>
												<a href="#tab4" data-toggle="tab" class="step">
												<span class="number"><?php echo ($mtype == "TYPE_SME") ? "4":"3";  ?></span><br />
												<span class="desc"><i class="fa fa-check"></i> Other Questions</span>   
												</a> 
											</li>
                                            <li>
												<a href="#tab5" data-toggle="tab" class="step">
												<span class="number"><?php echo ($mtype == "TYPE_SME") ? "5":"4";  ?></span><br />
												<span class="desc"><i class="fa fa-check"></i> Detailed Summary </span>   
												</a> 
											</li>
										</ul>
										<div id="bar" class="progress progress-striped" role="progressbar">
											<div class="progress-bar progress-bar-warning"></div>
										</div>
                                        
                                        <!--  Tab Content  -->
                                        
										<div class="tab-content">
											<div class="alert alert-danger hidden">
												<button class="close" data-dismiss="alert"></button>
												You have some form errors. Please check below.
											</div>
                                            										
                                            
											<!--------------------------- tab1  ------------------------------------>
                                                                                        
                                            <div class="tab-pane active" id="tab1">
												<h4 class="well well-sm">
                                                	Provide your account details
                                                    <span class="pull-right">
                                                        <span style="font-size:12px"><span class="label_required">*</span> Required fields.</span>
                                                    </span>
                                                </h4>
												<!-- row  -->
                                                
                                            <div class="col-md-12">
                                            	<div class="col-md-6">
                                                   <div class="form-group">
                                                      <label  class="col-md-5 control-label"><?php echo ($mtype == "TYPE_NGO") ? "Organization name: <span class='label_required'>*</span>" : "Company name: <span class='label_required'>*</span>" ; ?></label>
                                                      <div class="col-md-7">
                                                      	 <span><?php wp_nonce_field('portal_signup','signup_verf'); ?></span>
                                                         <input type="hidden" name="id" value="<?php echo $company_id;  ?>"  />
                                                         <input type="hidden" name="mode" value="SIGNUP_FORM_SUBMIT"  />
                                                         <input type="hidden" name="member_type" value="<?php echo $mtype; ?>"  />
                                                         <input type="text" class="form-control" name="company_name" value="<?php echo isset($BP_Company_Full->company_name) ? $BP_Company_Full->company_name : ""; ?>"  >
                                                         
                                                      </div>
                                                   </div>
                                               
                                                   <div class="form-group">
                                                      <label  class="col-md-5 control-label">Country of incorporation: <span class="label_required">*</span></label>
                                                      <div class="col-md-7">
                                                       <?php
                                                                    if (function_exists('biz_portal_get_country_list'))
                                                                    {
                                                                        $countries = biz_portal_get_country_list();
																		
                                                                    }
															?>
                                                         
                                                         
                                                         	<select id="country_of_incorporate" name="country_of_incorporate" class="form-control">
                                                           		<?php
																	foreach($countries as $country){
																		echo "<option value='".$country['id'] ."'  ";
																		
																		if($company_id > 0):
																			echo (($BP_Company_Full->country_of_incorporate == $country['id'])) ? "selected":"";
																		else:
																			echo (($country['id'] == 149)) ? "selected":"";
																		endif;
																		
																		echo " >". $country['country_name'] ."</option>";
																	}
																
																?>
                                                            </select>
                                                            
    
                                                      </div>
                                                   </div>
                                                   <div class="form-group">
                                                      <label  class="col-md-5 control-label">Year of incorporation:</label>
                                                      <div class="col-md-7">
                                                         <input type="text" class="form-control" name="year_of_incorporate" value="<?php echo isset($BP_Company_Full->year_of_incorporate) ? $BP_Company_Full->year_of_incorporate : ""; ?>" maxlength="4"  >
                                                      </div>
                                                   </div>
                                                   
                                                   <div class="form-group">
                                                      <label  class="col-md-5 control-label">Business Registration:</label>
                                                      <div class="col-md-7">
                                                         <input type="text" class="form-control" name="reg_number" id="business_registration" value="<?php echo isset($BP_Company_Full->reg_number) ? $BP_Company_Full->reg_number : ""; ?>"  >
                                                      </div>
                                                   </div>
                                               </div> <!-- col-md-6  -->    
                                               
                                               <div class="col-md-6">    
                                               	
                                                	<div class="form-group">
                                                              <label  class="col-md-5 control-label">Email: <span class="label_required">*</span></label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control <?php echo (empty($email)) ? 'company_email_verify' : '' ?>" id="contact_email" name="contact_email"  value="<?php echo isset($email) ? $email:""; ?>" <?php echo isset($email) ? "readonly='readonly'":""; ?> >
                                                              </div>
                                                    </div>
                                                    
                    
                                                   <div class="form-group">
                                                      <label  class="col-md-5 control-label">Location of head office: <span class="label_required">*</span></label>
                                                      <div class="col-md-7">
                                                         <input type="text" class="form-control" name="location_head_office"  value="<?php echo isset($BP_Company_Full->location_head_office) ? $BP_Company_Full->location_head_office : ""; ?>">
                                                      </div>
                                                   </div>
                                               
                                                   <div class="form-group">
                                                      <label  class="col-md-5 control-label"><?php echo ($mtype == "TYPE_NGO") ? "Person in Charge:" : "CEO / Managing Director:";  ?></label>
                                                      <div class="col-md-7">
                                                         <input type="text" class="form-control" name="ceo_md"  value="<?php echo isset($BP_Company_Full->ceo_md) ? $BP_Company_Full->ceo_md : ""; ?>">
                                                      </div>
                                                   </div>
                                               
                                                   <div class="form-group">
                                                      <label  class="col-md-5 control-label">Other Branches:</label>
                                                      <div class="col-md-7">
                                                         <input type="text" class="form-control" name="other_branch"  value="<?php echo isset($BP_Company_Full->other_branch) ? $BP_Company_Full->other_branch : ""; ?>">
                                                      </div>
                                                   </div>
                                                   
                                               </div> <!-- col-md-6  -->    
                                               
                                           </div> <!-- col-md-12  -->    
                                           
                                           
                                           
                                           <div class="clearfix"></div>
                                           
                                           		<h4 class="well well-sm" >Mailing Address</h4>  
                                               <div class="col-md-12">  
                                                 	<div class="col-md-6">  <!-- col-md-6  -->
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label" for="address_number" >Address 1: <span class="label_required">*</span></label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control" id="address_number" name="address_number"  value="<?php echo isset($address1) ? $address1 : ""; ?>">
                                                              </div>
                                                        </div>
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Town/City: <span class="label_required">*</span></label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  name="address_city" value="<?php echo isset($city) ? $city : ""; ?>">
                                                              </div>
                                                        </div>
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">State/Region</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  name="address_region" value="<?php echo isset($state_region) ? $state_region : ""; ?>">
                                                              </div>
                                                         </div>
                                            		</div> <!-- col-md-6  -->
                                                    
                                                    
                                                    <div class="col-md-6"> <!-- col-md-6  -->
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label" for="address_street">Address 2:</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  name="address_street" value="<?php echo isset($address2) ? $address2 : ""; ?>">
                                                              </div>
                                                         </div>
                                                       
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Postal Code: </label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control" name="address_postal_code"  value="<?php echo isset($postal) ? $postal : ""; ?>">
                                                              </div>
                                                         </div>
                                                        
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Country: <span class="label_required">*</span></label>
                                                              <div class="col-md-7">
                                                                 <?php
                                                                    if (function_exists('biz_portal_get_country_list'))
                                                                    {
                                                                        $countries = biz_portal_get_country_list();
																		
                                                                    }
																?>
                                                                 
                                                                 <select id="address_country" name="address_country" class="form-control">
                                                                   <?php
																	foreach($countries as $country){
																		echo "<option value='".$country['id'] ."'  ";
																		
																		if($company_id > 0):
																			echo (($BP_Company_Full->country->id == $country['id'])) ? "selected":"";
																		else:
																			echo (($country['id'] == 149)) ? "selected":"";
																		endif;
																		echo " >". $country['country_name'] ."</option>";
																	}
																
																?>
                                                                    </select>
                                                              </div>
                                                         </div>
                                                       
                                            		</div> <!-- col-md-6  -->
                                                </div>    
                                           <!-- row  -->
                                           <div class="clearfix"></div>
                                           <div class="row">
                                           		 <h4 class=" well well-sm">Contact Details</h4> 
                                               	<div class="col-md-12">  
                                                
                                                 	<div class="col-md-6">  <!-- col-md-6  -->
                                                       
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Contact person: <span class="label_required">*</span></label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control" name="contact_person" value="<?php echo isset($person) ? $person:""; ?>"  >
                                                              </div>
                                                        </div>
                                                       
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Office telephone: <span class="label_required">*</span></label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control" name="contact_telephone" value="<?php echo isset($telephone) ? $telephone:""; ?>" >
                                                              </div>
                                                        </div>
                                                       
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Fax:</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control" name="contact_fax"  value="<?php echo isset($fax) ? $fax:""; ?>">
                                                              </div>
                                                         </div>
                                                         
                                                        
                                                        
                                                       
                                                        
                                                        
                                            		</div> <!-- col-md-6  -->
                                                    
                                                    
                                                    <div class="col-md-6"> <!-- col-md-6  -->
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Position title: <span class="label_required">*</span></label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control" name="contact_position"  value="<?php echo isset($position) ? $position:""; ?>">
                                                              </div>
                                                         </div>
                                                       
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Mobile: </label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control" name="contact_mobile" value="<?php echo isset($mobile) ? $mobile:""; ?>" >
                                                              </div>
                                                         </div>
                                                        
                                                         <div class="form-group">
                                                              <label  class="col-md-5 control-label">Website:</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  name="contact_web" value="<?php echo isset($web) ? $web:""; ?>">
                                                              </div>
                                                         </div>
                                                        
                                                        
                                            		</div> <!-- col-md-6  -->
                                                 </div>   
                                                    
                                           </div> <!-- row  -->
                                                
                                           <?php if(($mtype == "TYPE_SME") || ($mtype == "TYPE_INTL")):  ?>     
                                           <div class="clearfix"></div>
                                           <div class="row">
                                          		 <h4 class=" well well-sm">Business Related Information</h4> 
                                                 <!-- business related  -->
												<div class="col-md-12">
                                                	<div class="col-md-6">  <!-- col-md-6  -->
                                                    	<h5>Type of business (check one or more)</h5>
                                                      	<div class="form-group">
                                                         	<label  class="control-label">&nbsp;</label>
                                                          	<div class="checkbox-list">
                                                          	<?php 	foreach($biz_type as $biz):  ?>
                                                          		<?php if(!in_array($biz['id'],$ngo_biz_type)):  ?>
                                                                
                                                                    <label for="company_biz_types_<?php echo $biz['id']; ?>">
                                                                        <input type="checkbox" id="company_biz_types_<?php echo $biz['id']; ?>" name="company_biz_types[]" value="<?php echo $biz['id']; ?>" data-title="<?php echo $biz['type_text']; ?>" <?php  if (!empty($biz_related_type)) echo (in_array($biz['id'], $biz_related_type)) ? "checked='checked'" : "";  ?>> <?php echo $biz['type_text']; ?>
                                                                     </label>
                                                                     
                                                          		<?php endif; ?>   
                                                          <?php endforeach;  ?>
                                                          
                                                          <?php  
														  if ((!is_null($biz_related_type))){
															  
															  	$biz_related_type_other = "";
																foreach($BP_Company_Full->biz_types as $biz):
																	if(($biz->is_user_value == 1)){
																		$biz_related_type_other = $biz->type_text;
																		break;
																	}
															   	endforeach;	
																
														   } else {
															   $biz_related_type_other = "";
														   }
														  ?>
                                                             
                                                             <div class="col-md-8">
                                                             	Other, Please specify: <input type="text" name="company_biz_types_other" class="form-control" value="<?php echo $biz_related_type_other; ?>" >
                                                             </div>   
                                                            
                                                          </div>
                                                       </div>
                                                    
                                                    </div><!-- col-md-6  (Type of business) -->
                                                    
                                                    <div class="col-md-6">  <!-- col-md-6  -->
                                                    	<h5>Industry where company operates (check one or more)</h5>
                                                        
                                                        <div class="row">
                                                        	<div class="col-md-12">
                                                                <div class="col-md-6">
                                                            
                                                                   <div class="form-group">
                                                                     <label  class="control-label">&nbsp;</label>
                                                                      <div class="checkbox-list">
                                                                        <?php
																	  	$company_industries_total = count($company_industries);
																		$company_industries_left = ceil($company_industries_total / 2);
																		
																		for($i = 0; $i < $company_industries_left; $i++):
																		
																	  ?>
                                                                       <label>
                                                                          <input type="checkbox" name="company_industries[]" value="<?php echo $company_industries[$i]['id']; ?>" data-title="<?php echo $company_industries[$i]['ind_name']; ?>" <?php if (!empty($biz_related_industry)) echo (in_array($company_industries[$i]['id'],$biz_related_industry)) ? "checked='checked'":"";  ?>  > <?php echo $company_industries[$i]['ind_name']; ?></label>
                                                                         <?php  endfor;  ?>
                                                                      </div>
                                                                   </div>
                                                                 
                                                                 </div> <!-- col-md-6  -->
                                                                 
                                                                 <div class="col-md-6">
                                                            
                                                                    <div class="form-group">
                                                                     <label  class="control-label">&nbsp;</label>
                                                                      <div class="checkbox-list">
                                                                          <?php for($i = $company_industries_left; $i < $company_industries_total; $i++): ?>
                                                                        		<label>
                                                                          <input type="checkbox" name="company_industries[]" value="<?php echo $company_industries[$i]['id']; ?>" data-title="<?php echo $company_industries[$i]['ind_name']; ?>" <?php if (!empty($biz_related_industry)) echo (in_array($company_industries[$i]['id'],$biz_related_industry)) ? "checked='checked'":"";  ?>  > <?php echo $company_industries[$i]['ind_name']; ?></label>
                                                                        <?php endfor;  ?>
                                                                      </div>
                                                                   </div>
                                                                 
                                                                 </div> <!-- col-md-6  -->
                                                                 
                                                             </div>  <!-- col-md-12  -->
                                                       
                                                        </div><!-- row  -->
                                                    
                                                    </div><!-- col-md-6  -->
                                                    
                                                </div>    <!-- col-md-12  -->
                                                 
                                           
                                           </div>     <!------  row    (Business Related Information)   ------->
                                           
                                           <div class="clearfix"></div>
                                            <div class="row">
                                                	
                                                            <div class="col-md-12">
                                                                <div class="col-md-6">  <!-- col-md-6  -->
                                                                   <h5>Annual turnover or revenue (USD): (Check one)</h5>
                                                                 	<?php $turnover = $BP_Company_Full->turnover_min . ',' . $BP_Company_Full->turnover_max;  ?>
                                                                     <label  class="control-label">&nbsp;</label>
                                                                      <div class="checkbox-list">
                                                                      <?php 
                                                                      $turnovers = array();
                                                                      if ($member_type == BP_MemberType::TYPE_INTL){
                                                                          $turnovers = $BP_Company_Filter->turnover_values_intl;
                                                                      }
                                                                      else if ($member_type == BP_MemberType::TYPE_SME) {
                                                                          $turnovers = $BP_Company_Filter->turnover_values;
                                                                      }
                                                                      ?>
                                                                      <?php foreach ($turnovers as $turnover) :?>
                                                                      <?php $checked_value = ($BP_Company_Full->turnover_min == $turnover['value_min'] && $BP_Company_Full->turnover_max == $turnover['value_max']) ? "checked='checked'" : ""; ?>
                                                                          <label>
                                                                            <input type="radio" name="turnover" value="<?php echo $turnover['value_min'] . ',', $turnover['value_max'] ?>" data-title="<?php echo $turnover['text'] ?>" <?php echo $checked_value;  ?>> <?php echo $turnover['text'] ?>
                                                                         </label>
                                                                      <?php endforeach; ?>
                                                                      </div>
                                                                   
                                                                </div> <!-- col-md-6  -->
                                                                
                                                                <div class="col-md-6">  <!-- col-md-6  -->
                                                                   <h5>Number of employees: (Check one)</h5>
                                                                 	<?php $employees = $BP_Company_Full->num_employee_min . ',' . $BP_Company_Full->num_employee_max;  ?>
                                                                     <label  class="control-label">&nbsp;</label>
                                                                      <div class="checkbox-list">
                                                                      <?php
                                                                      $num_emps = array();
                                                                      if ($member_type == BP_MemberType::TYPE_INTL) {
                                                                          $num_emps = $BP_Company_Filter->number_of_employees_intl;
                                                                      }
                                                                      else {
                                                                          $num_emps = $BP_Company_Filter->number_of_employees;
                                                                      }
                                                                      ?>
                                                                      <?php foreach ($num_emps as $num_emp) :?>
                                                                      <?php $checked_value = ($BP_Company->num_employee_min == $num_emp['value_min'] && $BP_Company->num_employee_max == $num_emp['value_max']) ? "checked='checked'" : ""; ?>
                                                                          <label>
                                                                            <input type="radio" name="num_employee" value="<?php echo $num_emp['value_min'] . ',' . $num_emp['value_max'] ?>" data-title="<?php echo $num_emp['text'] ?>"  <?php echo $checked_value;  ?> > <?php echo $num_emp['text'] ?>
                                                                         </label>
                                                                      <?php endforeach; ?>
                                                                      </div>
                                                                </div> <!-- col-md-6  -->
                                                            
                                                            </div> <!-- col-md-12  -->
                                                	          
                                                </div> <!-- ROW  -->
                                                
                                                <div class="col-md-12" style="margin:20px; 0">
                                                	<h5>Summary of company’s background and business activities (maximum 360 characters)</h5>
                                                    	 <div class="form-group">
                                                              <div class="col-md-11" style="margin-left:15px;">
                                                                <textarea class="form-control" rows="3" name="summary"><?php echo isset($BP_Company_Full->summary) ? $BP_Company_Full->summary : "" ;  ?></textarea>
                                                              </div>
                                                         </div>
                                                </div> <!-- col-md-12  (Summary of company Background)-->
                                           
                                           <?php endif;  ?>
                                           
                                           
                                           <?php if($mtype == "TYPE_NGO"):  ?>
                                                	<h4 class="well well-sm">Organizational Type</h4>
                                                    <div class="row">
                                                    	<div class="col-md-6"  > <!-- col-md-6  -->
                                                    		<div class="panel panel-info">
                                                                <div class="panel-heading">
                                                                	<h3 class="panel-title">
                                                                    	Type of Organizations (check one or more)
                                                                    </h3>
                                                                </div>
                                                                <div class="panel-body" >
                                                                	
                                                                          <div style="padding:10px 0 0 20px;">  
                                                                            
																			<?php foreach($biz_type as $biz):  ?>
                                                                                <?php if(in_array($biz['id'],$ngo_biz_type)):  ?>
                                                                                <div class="form-group">
                                                                        			<div class="col-md-12">
                                                                                        <div class="box_form_subcategory">
                                                                                    
                                                                                            <label>
                                                                                                <input type="checkbox" name="company_biz_types[]" value="<?php echo $biz['id']; ?>" data-title="<?php echo $biz['type_text']; ?>" <?php if (!is_null($biz_related_type)) echo (in_array($biz['id'], $biz_related_type)) ? "checked='checked'" : "";  ?> /> <?php echo $biz['type_text']; ?>
                                                                                            </label>
                                                                                        </div>
                                                                    			</div>   
                                                                                </div>
                                                                                    
                                                                                 <?php endif; ?>   
                                                                            <?php endforeach; ?>
                                                                            
                                                                            <?php  
                                                                              if ((!empty($biz_related_type))){
                                                                                  
                                                                                    $biz_related_type_other = "";
                                                                                    foreach($BP_Company_Full->biz_types as $biz):
                                                                                        if(($biz->is_user_value == 1)){
                                                                                            $biz_related_type_other = $biz->type_text;
                                                                                            break;
                                                                                        }
                                                                                    endforeach;	
                                                                                    
                                                                               } else {
                                                                                   $biz_related_type_other = "";
                                                                               }
                                                                              ?>
                                                                                   <div class="form-group">  
                                                                                     <div class="col-md-10" style="padding-left:20px;">
                                                                                        Other, Please specify: <input type="text" name="company_biz_types_other" class="form-control" value="<?php echo $biz_related_type_other; ?>" >
                                                                                     </div> 
                                                                                  </div>
                                                                                  
                                                                            </div> 
                                                                         
                                                                </div>
                                                                
                                                   			</div>
                                                    
                                                          </div>                                         
                                                
                                                		
                                                    
                                                    </div>  <!--  row  -->
                                                    
                                                    
                                                    
                                                    
                                                    <div class="row" style="margin:20px; 0">
                                                	<h5>Summary of company’s background and business activities (maximum 360 characters)</h5>
                                                    	 <div class="form-group">
                                                              <div class="col-md-11" style="margin-left:15px;">
                                                                <textarea class="form-control" rows="3" name="summary"><?php echo isset($BP_Company_Full->summary) ? $BP_Company_Full->summary : "" ;  ?></textarea>
                                                              </div>
                                                         </div>
                                                </div> <!-- row  (Summary of company Background)-->  
                                                    
                                                    
                                                	<?php endif;  ?> <!----  (NGO) Type of Organization  -->
                                                
													<?php include __DIR__ . "/include_pages/form_additional.php"; ?>				
                                                
                                                </div>
                                        
                                            
                                            <!------------------------------------------- tab1  -------------------------------------->
                                            
                                            
                                            
                                            <!-------------------------------------------- tab2  ------------------------------------->
											<div class="tab-pane" id="tab2">
                                            
												<?php if($mtype == "TYPE_SME"):  ?>
                                                <h4 class="well well-sm">I am looking for </h4>
                                                <div class="row">
                                                	
                                                
                                                <!---------------  Investors  --------------->
                                                <div class="col-md-4">
                                                         	<div class="panel panel-info">
                                                                <div class="panel-heading">
                                                                	<h3 class="panel-title">
                                                                    	<input type="checkbox" name="biz_need_invest" value="1" data-title="Investors" <?php echo ($BP_Company_Full->bool_biz_need_invest) ? "checked='checked'":""; ?>> Investment 
                                                                    </h3>
                                                                </div>
                                                                <div class="panel-body">
                                                         			
                                                         		<div class="form-body"  style="padding-left:20px;" >
                                                             		
																	
																	<?php $biz_need_invest_default =  $BP_Company_Full->biz_need_investment->min . ',' . $BP_Company_Full->biz_need_investment->max; ?>
                                                                    		
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                        	a. Amount of Investment Needed
                                                                        	
                                                                              <div class="col-md-12 ">
                                                                              	<label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">Up to 1,000,000 USD</label>
                                                                              	<div class="col-md-1">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="radio" name="biz_need_invest_amount"  value="0,1000000" data-title="Up to 1,000,000 USD" <?php echo ($biz_need_invest_default == "0,1000000") ? "checked='checked'":""; ?> >
                                                                                     </label>
                                                                             	</div>
                                                                             </div>
                                                                             
                                                                             <div class="col-md-12">
                                                                             	<label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">1,000,001 – 2,000,000 USD</label>
                                                                                <div class="col-md-1">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="radio" name="biz_need_invest_amount"  value="1000001,2000000" data-title="1,000,001 – 2,000,000 USD" <?php echo ($biz_need_invest_default == "1000001,2000000") ? "checked='checked'":""; ?>>
                                                                                     </label>
                                                                             	</div>
                                                                             </div>
                                                                             
                                                                             <div class="col-md-12">
                                                                             	<label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">2,000,001 – 5,000,000 USD</label>
                                                                                <div class="col-md-1">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="radio" name="biz_need_invest_amount"  value="2000001,5000000" data-title="2,000,001 – 5,000,000 USD" <?php echo ($biz_need_invest_default == "2000001,5000000") ? "checked='checked'":""; ?>>
                                                                                     </label>
                                                                             	</div>
                                                                             </div>
                                                                             
                                                                             <div class="col-md-12">
                                                                             	<label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">Over 5,000,000 USD</label>
                                                                                <div class="col-md-1">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="radio" name="biz_need_invest_amount"  value="5000000,0" data-title="Over 5,000,000 USD"  <?php echo ($biz_need_invest_default == "5000000,0") ? "checked='checked'":""; ?> >
                                                                                     </label>
                                                                             	</div>
                                                                             </div>
                                                                             
                                                                             
                                                                         </div>  <!-- col-md-12  -->
                                                                     </div>  <!-- form-group  -->
                                                                     
                                                                    
                                                            	</div> <!-- form-body  -->
                                                                
                                                                </div>
                                                                
                                                                </div>
                                                                
                                                         </div> <!-- col-md-4  -->
                                                <!---------------  Investors  --------------->
                                                
                                                
                                                <!---------------  Partner in --------------->
                                                
                                                <div class="col-md-4">
                                                        
                                                        <div class="panel panel-info">
                                                                <div class="panel-heading"><h3 class="panel-title"><input type="checkbox" name="biz_need_partner" value="1" data-title="Partner in"  <?php echo ($BP_Company_Full->bool_biz_need_partner_in) ? "checked='checked'":""; ?> > Partners - Myanmar/International Companies</h3></div>
                                                                <div class="panel-body">
                                                        
                                                        
                                                         	<div class="form-body" style="padding-left:20px;">
                                                            
                                                                    <?php	foreach($biz_needs_partner_in as $biz_need_partner):	?> 
                                                                    	<?php if(!in_array($biz_need_partner['id'],$ngo_biz_type)):  ?>
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                        	                                                                        
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left"><?php echo $biz_need_partner['type_text'];  ?></label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline" for="biz_needs_partner_in_<?php echo $biz_need_partner['id'];  ?>">
                                                                                     <input type="checkbox" id="biz_needs_partner_in_<?php echo $biz_need_partner['id'];  ?>" name="biz_needs_partner_in[]"  value="<?php echo $biz_need_partner['id'];  ?>" data-title="<?php echo $biz_need_partner['type_text'];  ?>"  <?php 
																					
																					 if(!empty($biz_need_partner_biz_types)){
																						 if(in_array($biz_need_partner['id'],$biz_need_partner_biz_types)){
																							 echo "checked='checked'";	
																						 } else {
																							 echo "";	
																						 }
																					 } else {
																						echo "";	 
																					 }
																					 
																					 ?> >
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div> 
                                                                     	<?php endif;  ?>
																	 <?php endforeach;  ?>
                                                                     
                                                                     <?php  
																	  if ((!empty($biz_need_partner_biz_types))){
																		  
																			$biz_need_partner_biz_type_other = "";
																			foreach($BP_Company_Full->biz_need_partner_biz_types as $biz_partner):
																				if(($biz_partner->is_user_value == 1)){
																					$biz_need_partner_biz_type_other = $biz_partner->type_text;
																					break;
																				}
																			endforeach;	
																			
																	   } else {
																		   $biz_need_partner_biz_type_other = "";
																	   }
																	  ?>
                                                                     
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-11">
                                                                              <label  class=" control-label" style="text-align:left">Other, Please Specify </label><br>
                                                                               <input type="text" name="biz_needs_partner_other" class="form-control" value="<?php echo $biz_need_partner_biz_type_other; ?>" >
                                                                              
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     
                                                                     <h4>Industry</h4>
                                                                     
                                                                      <?php	foreach($biz_needs_partner_in_ind as $biz_needs_partner_ind):	?> 
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                        	                                                                        
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left"><?php echo $biz_needs_partner_ind['ind_name'];  ?></label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline" for="biz_needs_partner_in_ind_<?php echo $biz_needs_partner_ind['id'];  ?>">
                                                                                     <input type="checkbox" name="biz_needs_partner_in_ind[]" id="biz_needs_partner_in_ind_<?php echo $biz_needs_partner_ind['id'];  ?>"  value="<?php echo $biz_needs_partner_ind['id'];  ?>" data-title="<?php echo $biz_needs_partner_ind['ind_name'];  ?>" <?php 
																					 
																					 
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
                                                                             </div>
                                                                         </div> 
                                                                     </div> 
                                                                     
																	 <?php endforeach;  ?>
                                                                     
                                                                     <?php  
																	  if ((!empty($biz_need_partner_industries))){
																		  
																			$biz_need_partner_ind_other = "";
																			foreach($BP_Company_Full->biz_need_partner_industries as $biz_partner):
																				if(($biz_partner->is_user_value == 1)){
																					$biz_need_partner_ind_other = $biz_partner->ind_name;
																					break;
																				}
																			endforeach;	
																			
																	   } else {
																		   $biz_need_partner_ind_other = "";
																	   }
																	  ?>
                                                                     
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-11">
                                                                              <label  class=" control-label" style="text-align:left">Other, Please Specify </label><br>
                                                                               <input type="text" name="biz_needs_partner_in_ind_other" class="form-control" value="<?php echo  $biz_need_partner_ind_other; ?>">
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                 </div>    
                                                              </div>
                                                              
                                                              </div>   
                                                         </div> <!-- col-md-6   -->
                                                
                                                <!--------------- end of  Partner in  --------------->
                                                
                                                
                                                
                                                
                                                
                                                
                                                <!---------------  Service Providers  --------------->
                                                <div class="col-md-4" >
                                                         	
															<div class="panel panel-info">
                                                                <div class="panel-heading"><h3 class="panel-title"><input type="checkbox" name="biz_needs_service_provide_bool" value="1" data-title="Service Provider" <?php echo ($BP_Company_Full->bool_biz_need_service) ? "checked='checked'":""; ?> > Service Providers </h3></div>
                                                                <div class="panel-body">                                                            	
                                                                
                                                                <div class="form-body"  style="padding-left:20px;">
                                                             		
                                                                    <?php foreach($service_provider as $service):  ?>
                                                                    	<?php if(!in_array($service['id'],$ngo_biz_services)):  ?>                                                                   
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left"><?php echo $service['service_name']; ?> </label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="biz_needs_service_provide[]"  value="<?php echo $service['id']; ?>" data-title="<?php echo $service['service_name']; ?>"  
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
                                                                             </div>
                                                                         </div> 
                                                                     </div> 
                                                                     	<?php endif;  ?>
                                                                     
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
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-11">
                                                                              <label  class=" control-label" style="text-align:left">g. Other, Please Specify </label><br>
                                                                               <input type="text" name="biz_needs_service_provide_other" class="form-control" value="<?php echo $biz_need_service_other; ?>">
                                                                              
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     
                                                            	</div> <!-- form-body  -->
                                                                
                                                             </div>
                                                             
                                                             </div>   
                                                            
                                                         </div> <!-- col-md-4  -->
                                                <!---------------  Service Providers  --------------->
                                                </div>
                                                
                                                
                                                <?php endif;  ?> <!----  (SME) I am looking for  -->
                                                
                                                
                                                
											</div>
                                            <!------------------------------ tab2  ------------------------------>
                                            
                                            
                                            
               <!--------------------------------------  Business Needs  ------------------------------------->
                                            
                <!------------------------------------------ tab3  --------------------------------->
											<div class="tab-pane" id="tab3">
													<?php if($mtype == "TYPE_SME"):  ?>
                                                    <h4 class="well well-sm">I am looking to </h4>
                                                    <div class="row">
                                               			
                                                        <div class="col-md-6">
                                                         	<div class="panel panel-info">
                                                                <div class="panel-heading">
                                                                	<h3 class="panel-title">
                                                                    	<input type="checkbox" name="biz_give_invest" value="1" data-title="Investors" <?php echo ($BP_Company_Full->bool_biz_give_invest) ? "checked='checked'":""; ?>> Invest
                                                                    </h3>
                                                                </div>
                                                                <div class="panel-body">
                                                         
                                                         		<div class="form-body"  style="padding-left:20px;" >
                                                             		
                                                                     <?php $biz_give_invest_default =  $BP_Company_Full->biz_give_investment->min . ',' . $BP_Company_Full->biz_give_investment->max; ?>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">a.	Up to 1,000,000 USD</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="radio" name="biz_give_invest_amount"  value="0,1000000" data-title="Up to 1,000,000 USD"  <?php echo ($biz_give_invest_default == '0,1000000') ? "checked='checked'":"";  ?>>
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div> 
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">b.	1,000,001 – 2,000,000 USD</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="radio" name="biz_give_invest_amount"  value="1000001,2000000" data-title="1,000,001 – 2,000,000 USD" <?php echo ($biz_give_invest_default == '1000001,2000000') ? "checked='checked'":"";  ?>>
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">c.	2,000,001 – 5,000,000 USD</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="radio" name="biz_give_invest_amount"  value="2000001,5000000" data-title="2,000,001 – 5,000,000 USD" <?php echo ($biz_give_invest_default == '2000001,5000000') ? "checked='checked'":"";  ?>>
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">d.	Over 5,000,000 USD</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="radio" name="biz_give_invest_amount"  value="5000000,0" data-title="Over 5,000,000 USD" <?php echo ($biz_give_invest_default == '5000000,0') ? "checked='checked'":"";  ?>>
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              e. SME employee size to invest in 
                                                                              
                                                                               <?php $biz_give_invest_employee =  $BP_Company_Full->biz_give_investment->sme_employee_min . ',' . $BP_Company_Full->biz_give_investment->sme_employee_max; ?>
                                                                              
                                                                              <div class="col-md-10 col-md-offset-1">
                                                                                  <label  class="col-md-8 control-label" style="margin-right:20px; text-align:left">1 - 50</label>
                                                                                  <div class="col-md-2">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="radio" name="biz_give_invest_emp_size"  value="1,50" data-title="1 - 50" <?php echo ($biz_give_invest_employee == '1,50') ? "checked='checked'":"";  ?>>
                                                                                         </label>
                                                                                 </div>
                                                                             </div>
                                                                             
                                                                             <div class="col-md-10 col-md-offset-1">
                                                                                  <label  class="col-md-8 control-label" style="margin-right:20px; text-align:left">51 - 100</label>
                                                                                  <div class="col-md-2">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="radio" name="biz_give_invest_emp_size"  value="51,100" data-title="51 - 100" <?php echo ($biz_give_invest_employee == '51,100') ? "checked='checked'":"";  ?>>
                                                                                         </label>
                                                                                 </div>
                                                                             </div>
                                                                             
                                                                             <div class="col-md-10 col-md-offset-1">
                                                                                  <label  class="col-md-8 control-label" style="margin-right:20px; text-align:left">101 - 200</label>
                                                                                  <div class="col-md-2">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="radio"  name="biz_give_invest_emp_size"  value="101,200" data-title="101 - 200" <?php echo ($biz_give_invest_employee == '101,200') ? "checked='checked'":"";  ?>>
                                                                                         </label>
                                                                                 </div>
                                                                             </div>
                                                                             
                                                                             <div class="col-md-10 col-md-offset-1">
                                                                                  <label  class="col-md-8 control-label" style="margin-right:20px; text-align:left">200+</label>
                                                                                  <div class="col-md-2">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="radio" name="biz_give_invest_emp_size"  value="200,0" data-title="200+" <?php echo ($biz_give_invest_employee == '200,0') ? "checked='checked'":"";  ?>>
                                                                                         </label>
                                                                                 </div>
                                                                             </div>
                                                                             
                                                                             <div class="col-md-10 col-md-offset-1">
                                                                                  <label  class="col-md-8 control-label" style="margin-right:20px; text-align:left">No Requirement</label>
                                                                                  <div class="col-md-2">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="radio" name="biz_give_invest_emp_size"  value="0,0" data-title="No Requirement" <?php echo ($biz_give_invest_employee == '0,0') ? "checked='checked'":"";  ?>>
                                                                                         </label>
                                                                                 </div>
                                                                             </div>
                                                                             
                                                                             
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     
                                                                     <div class="form-group"> <!-- Industry to invest  -->
                                                                     	<div class="col-md-12">
                                                                              f. Industry to invest in 
                                                                              
                                                                              <?php	foreach($company_industries as $company_ind):	?> 
                                                                              
                                                                              <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-9 control-label" style="margin-right:20px;text-align:left">
																						<?php echo $company_ind['ind_name']; ?> 
                                                                                    </label>
                                                                              		<div class="col-md-2">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="checkbox" name="biz_give_invest_ind[]"  value="<?php echo $company_ind['id']; ?>" data-title="<?php echo $company_ind['ind_name']; ?>"  <?php
																						
																								if(!empty($biz_give_invest_industries)){
																									if(in_array($company_ind['id'],$biz_give_invest_industries)){
																										echo "checked='checked'";	
																									} else {
																										echo "";	
																									}
																								} else {
																									echo "";	
																								}
																						 
																						 ?>  >
                                                                                         </label>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             <?php endforeach;  ?>
                                                                             
                                                                             <?php
																			 	$biz_give_invest_ind_other = "";
																			 	if(!empty($biz_give_invest_industries)){
																					
																					foreach($BP_Company_Full->biz_give_investment->industries as $biz_give_invest){
																						if($biz_give_invest->is_user_value == 1){
																							$biz_give_invest_ind_other = $biz_give_invest->ind_name;
																							break;
																						}
																					}
																					
																				} else {
																					$biz_give_invest_ind_other = "";
																				}
																			 
																			
																			 
																			 ?>
                                                                             
                                                                                <div class="box_form_subcategory">
                                                                                      <label  class=" control-label" style="text-align:left">Other, Please Specify </label><br>
                                                                                       <input type="text" name="biz_give_invest_ind_other" class="form-control" value="<?php echo $biz_give_invest_ind_other;  ?>">
                                                                                      
                                                                                 </div> 
                                                                            
                                                                                
                                                                             
                                                                         </div> 
                                                                     </div>  <!-- form-group  -->
                                                                     
                                                                     
                                                                     <div class="form-group"> <!-- Turnover requirement   -->
                                                                     	<div class="col-md-12">
                                                                              g.	Turnover requirement
                                                                              
                                                                              <?php $biz_give_invest_turnover =  $BP_Company_Full->biz_give_investment->turnover_min . ',' . $BP_Company_Full->biz_give_investment->turnover_max; ?>
                                                                              
                                                                              <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">Up to 1,000,000 </label>
                                                                              		<div class="col-md-4">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_turnover"  value="0,1000000" data-title="Up to 1,000,000" <?php echo ($biz_give_invest_turnover == '0,1000000') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                           
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">1,000,001-2,000,000 </label>
                                                                              		<div class="col-md-4">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_turnover"  value="1000001,2000000" data-title="1,000,001-2,000,000" <?php echo ($biz_give_invest_turnover == '1000001,2000000') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                         
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">2,000,001-5,000,000 </label>
                                                                              		<div class="col-md-4">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_turnover"  value="2000001,5000000" data-title="2,000,001-5,000,000" <?php echo ($biz_give_invest_turnover == '2000001,5000000') ? "checked='checked'":"";  ?>>                                                                                             </label>
                                                                                           
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">5,000,000+</label>
                                                                              		<div class="col-md-4">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_turnover"  value="5000000,0" data-title="5,000,000+" <?php echo ($biz_give_invest_turnover == '5000000,0') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                          
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                                                                                                         
                                                                                                                                                        
                                                                                <div class="box_form_subcategory">
                                                                                      <label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">No Requirement</label>
                                                                                      <div class="col-md-4">
                                                                                             <div class="radio-list">
                                                                                            	<label class="radio-inline">
                                                                                             	<input type="radio" name="biz_give_invest_turnover"  value="0,0" data-title="No Requirement" <?php echo ($biz_give_invest_turnover == '0,0') ? "checked='checked'":"";  ?>>
                                                                                             	</label>
                                                                                             </div>
                                                                                     </div>
                                                                                 </div> 
                                                                             
                                                                         </div> 
                                                                     </div>  <!-- Turnover requirement  -->
                                                                     
                                                                     <div class="form-group"> <!-- Years in business   -->
                                                                     	<div class="col-md-12">
                                                                              h. Years in Business Requirements
                                                                              
                                                                              <?php $biz_give_invest_year =  $BP_Company_Full->biz_give_investment->years_in_biz_min . ',' . $BP_Company_Full->biz_give_investment->years_in_biz_max; ?>
                                                                              
                                                                              <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">0 - 2 Years</label>
                                                                              		<div class="col-md-4">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_yrs"  value="0,2" data-title="0 - 2 Years" <?php echo ($biz_give_invest_year == '0,2') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                           
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">2 - 5 Years </label>
                                                                              		<div class="col-md-4">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_yrs"  value="2,5" data-title="2 - 5 Years" <?php echo ($biz_give_invest_year == '2,5') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                        
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">5 - 10 Years </label>
                                                                              		<div class="col-md-4">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_yrs"  value="5,10" data-title="5 - 10 Years" <?php echo ($biz_give_invest_year == '5,10') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                         
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-6 control-label" style="margin-right:40px;text-align:left">10 Years +</label>
                                                                              		<div class="col-md-4">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_yrs"  value="10,0" data-title="10 Years +" <?php echo ($biz_give_invest_year == '10,0') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                           
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                            
                                                                                                                                                            
                                                                                <div class="box_form_subcategory">
                                                                                      <label  class="col-md-6 control-label" style="margin-right:40px; text-align:left">No Requirement</label>
                                                                                      <div class="col-md-4">
                                                                                            <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                             <input type="radio" name="biz_give_invest_yrs"  value="0,0" data-title="No Requirement" <?php echo ($biz_give_invest_year == '0,0') ? "checked='checked'":"";  ?>>
                                                                                             </label>
                                                                                             </div>
                                                                                     </div>
                                                                                 </div> 
                                                                             
                                                                         </div> 
                                                                     </div>  <!-- Years in business  -->
                                                                     
                                                                     
                                                            	</div> <!-- form-body  -->
                                                                
                                                                </div>
                                                                
                                                                </div>
                                                                
                                                         </div> <!-- col-md-6  -->
                                                         
                                                         <!------------------------  Provide Services  ------------------------->
                                                         
                                                         <div class="col-md-6" >
                                                         	
															<div class="panel panel-info">
                                                                <div class="panel-heading"><h3 class="panel-title"><input type="checkbox" name="biz_give_service_provide_bool" value="1" data-title="Service Provider" <?php echo ($BP_Company_Full->bool_biz_give_service) ? "checked='checked'":""; ?>  > Provide Services  </h3></div>
                                                                <div class="panel-body">                                                            	
                                                                
                                                                <div class="form-body"  style="padding-left:20px;">
                                                             		                                                                     
                                                                    <?php foreach($service_provider as $service):  ?>
                                                                    	<?php if(!in_array($service['id'],$ngo_biz_services)):  ?>                                                                   
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left"><?php echo $service['service_name']; ?> </label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="biz_give_service_provide[]"  value="<?php echo $service['id']; ?>" data-title="<?php echo $service['service_name']; ?>"  <?php
                                                                                     if(!empty($biz_give_services)){
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
                                                                             </div>
                                                                         </div> 
                                                                     </div> 
                                                                     	<?php endif;  ?>
                                                                     <?php endforeach;  ?>
                                                                     
                                                                     <?php  
																	 	$biz_give_service_other = "";
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
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-11">
                                                                              <label  class=" control-label" style="text-align:left">g. Other, Please Specify </label><br>
                                                                               <input type="text" name="biz_give_service_provide_other" class="form-control" value="<?php echo $biz_give_service_other; ?>">
                                                                              
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     
                                                            	</div> <!-- form-body  -->
                                                                
                                                             </div>
                                                             
                                                             </div>   
                                                            
                                                         </div> <!-- col-md-6  -->
                                                        
                                                         </div>
                                                        
                                                        <?php endif;  ?> <!--- TYPE_SME  --> 
                                                        
                                                        
                                                        
                                                        <?php if($mtype == "TYPE_INTL"):  ?>
                                                        <h4 class="well well-sm">I am looking to </h4>
                                                       <div class="row">
                                                       	<div class="container">
                                                        
                                                       
                                                        <div class="row">
                                                        
                                                     


															<!----------------------------  Invest   ------------------------------->
                                                         <div class="col-md-4">
                                                         	<div class="panel panel-info">
                                                                <div class="panel-heading">
                                                                	<h3 class="panel-title">
                                                                    	<input type="checkbox" name="biz_give_invest" value="1" data-title="Investors" <?php echo (isset($BP_Company_Full->bool_biz_give_invest)) ? "checked='checked'":""; ?>> Invest
                                                                    </h3>
                                                                </div>
                                                                <div class="panel-body">
                                                         
                                                         		<div class="form-body"  style="padding-left:20px;" >
                                                             		
                                                                     <?php $biz_give_invest_default =  $BP_Company_Full->biz_give_investment->min . ',' . $BP_Company_Full->biz_give_investment->max; ?>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                        	 a. Amount to invest in 
                                                                        
                                                                             <div class="col-md-12"> 
                                                                                  <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">Up to 1,000,000 USD</label>
                                                                                  <div class="col-md-1">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="radio" name="biz_give_invest_amount"  value="0,1000000" data-title="Up to 1,000,000 USD"  <?php echo ($biz_give_invest_default == '0,1000000') ? "checked='checked'":"";  ?>>
                                                                                         </label>
                                                                                 </div>
                                                                             </div>
                                                                             
                                                                             <div class="col-md-12">
                                                                             	<label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">1,000,001 – 2,000,000 USD</label>
                                                                                <div class="col-md-1">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="radio" name="biz_give_invest_amount"  value="1000001,2000000" data-title="1,000,001 – 2,000,000 USD" <?php echo ($biz_give_invest_default == '1000001,2000000') ? "checked='checked'":"";  ?>>
                                                                                     </label>
                                                                             	</div>
                                                                             </div>
                                                                             
                                                                             
                                                                            <div class="col-md-12">
                                                                            	<label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">2,000,001 – 5,000,000 USD</label>
                                                                                <div class="col-md-1">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="radio" name="biz_give_invest_amount"  value="2000001,5000000" data-title="2,000,001 – 5,000,000 USD" <?php echo ($biz_give_invest_default == '2000001,5000000') ? "checked='checked'":"";  ?>>
                                                                                     </label>
                                                                             	</div>
                                                                            
                                                                            </div>
                                                                            
                                                                            
                                                                            <div class="col-md-12">
                                                                            	<label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">Over 5,000,000 USD</label>
                                                                                <div class="col-md-1">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="radio" name="biz_give_invest_amount"  value="5000000,0" data-title="Over 5,000,000 USD" <?php echo ($biz_give_invest_default == '5000000,0') ? "checked='checked'":"";  ?>>
                                                                                     </label>
                                                                             	</div>
                                                                            </div>
                                                                             
                                                                             
                                                                         </div>  <!-- col-md-12  -->
                                                                     </div> <!-- form-group  -->
                                                                     
                                                                     
                                                                     
                                                                                                                                          
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              b. SME employee size to invest in 
                                                                              
                                                                               <?php $biz_give_invest_employee =  $BP_Company_Full->biz_give_investment->sme_employee_min . ',' . $BP_Company_Full->biz_give_investment->sme_employee_max; ?>
                                                                              
                                                                              <div class="col-md-10 col-md-offset-1">
                                                                                  <label  class="col-md-8 control-label" style="margin-right:20px; text-align:left">1 - 50</label>
                                                                                  <div class="col-md-2">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="radio" name="biz_give_invest_emp_size"  value="1,50" data-title="1 - 50" <?php echo ($biz_give_invest_employee == '1,50') ? "checked='checked'":"";  ?>>
                                                                                         </label>
                                                                                 </div>
                                                                             </div>
                                                                             
                                                                             <div class="col-md-10 col-md-offset-1">
                                                                                  <label  class="col-md-8 control-label" style="margin-right:20px; text-align:left">51 - 100</label>
                                                                                  <div class="col-md-2">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="radio" name="biz_give_invest_emp_size"  value="51,100" data-title="51 - 100" <?php echo ($biz_give_invest_employee == '51,100') ? "checked='checked'":"";  ?>>
                                                                                         </label>
                                                                                 </div>
                                                                             </div>
                                                                             
                                                                             <div class="col-md-10 col-md-offset-1">
                                                                                  <label  class="col-md-8 control-label" style="margin-right:20px; text-align:left">101 - 200</label>
                                                                                  <div class="col-md-2">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="radio"  name="biz_give_invest_emp_size"  value="101,200" data-title="101 - 200" <?php echo ($biz_give_invest_employee == '101,200') ? "checked='checked'":"";  ?>>
                                                                                         </label>
                                                                                 </div>
                                                                             </div>
                                                                             
                                                                             <div class="col-md-10 col-md-offset-1">
                                                                                  <label  class="col-md-8 control-label" style="margin-right:20px; text-align:left">200+</label>
                                                                                  <div class="col-md-2">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="radio" name="biz_give_invest_emp_size"  value="200,0" data-title="200+" <?php echo ($biz_give_invest_employee == '200,0') ? "checked='checked'":"";  ?>>
                                                                                         </label>
                                                                                 </div>
                                                                             </div>
                                                                             
                                                                             <div class="col-md-10 col-md-offset-1">
                                                                                  <label  class="col-md-8 control-label" style="margin-right:20px; text-align:left">No Requirement</label>
                                                                                  <div class="col-md-2">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="radio" name="biz_give_invest_emp_size"  value="0,0" data-title="No Requirement" <?php echo ($biz_give_invest_employee == '0,0') ? "checked='checked'":"";  ?>>
                                                                                         </label>
                                                                                 </div>
                                                                             </div>
                                                                             
                                                                             
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     
                                                                     <div class="form-group"> <!-- Industry to invest  -->
                                                                     	<div class="col-md-12">
                                                                              c. Industry to invest in 
                                                                              
                                                                              <?php	foreach($company_industries as $company_ind):	?> 
                                                                              
                                                                              <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-9 control-label" style="margin-right:20px;text-align:left">
																						<?php echo $company_ind['ind_name']; ?> 
                                                                                    </label>
                                                                              		<div class="col-md-2">
                                                                                        <label class="checkbox-inline">
                                                                                         <input type="checkbox" name="biz_give_invest_ind[]"  value="<?php echo $company_ind['id']; ?>" data-title="<?php echo $company_ind['ind_name']; ?>"  <?php
																						
																								if(!empty($biz_give_invest_industries)){
																									if(in_array($company_ind['id'],$biz_give_invest_industries)){
																										echo "checked='checked'";	
																									} else {
																										echo "";	
																									}
																								} else {
																									echo "";	
																								}
																						 
																						 ?>  >
                                                                                         </label>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             <?php endforeach;  ?>
                                                                             
                                                                             <?php
																			 	$biz_give_invest_ind_other = "";
																			 	if(!empty($biz_give_invest_industries)){
																					
																					foreach($BP_Company_Full->biz_give_investment->industries as $biz_give_invest){
																						if($biz_give_invest->is_user_value == 1){
																							$biz_give_invest_ind_other = $biz_give_invest->ind_name;
																							break;
																						}
																					}
																					
																				} else {
																					$biz_give_invest_ind_other = "";
																				}
																			 
																			
																			 
																			 ?>
                                                                             
                                                                                <div class="box_form_subcategory">
                                                                                      <label  class=" control-label" style="text-align:left">Other, Please Specify </label><br>
                                                                                       <input type="text" name="biz_give_invest_ind_other" class="form-control" value="<?php echo $biz_give_invest_ind_other;  ?>">
                                                                                      
                                                                                 </div> 
                                                                            
                                                                                
                                                                             
                                                                         </div> 
                                                                     </div>  <!-- form-group  -->
                                                                     
                                                                     
                                                                     <div class="form-group"> <!-- Turnover requirement   -->
                                                                     	<div class="col-md-12">
                                                                              d.	Turnover requirement
                                                                              
                                                                              <?php $biz_give_invest_turnover =  $BP_Company_Full->biz_give_investment->turnover_min . ',' . $BP_Company_Full->biz_give_investment->turnover_max; ?>
                                                                              
                                                                              <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-7 control-label" style="margin-right:40px;text-align:left">Up to 1,000,000 </label>
                                                                              		<div class="col-md-3">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_turnover"  value="0,1000000" data-title="Up to 1,000,000" <?php echo ($biz_give_invest_turnover == '0,1000000') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                           
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-7 control-label" style="margin-right:40px;text-align:left">1,000,001-2,000,000 </label>
                                                                              		<div class="col-md-3">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_turnover"  value="1000001,2000000" data-title="1,000,001-2,000,000" <?php echo ($biz_give_invest_turnover == '1000001,2000000') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                         
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-7 control-label" style="margin-right:40px;text-align:left">2,000,001-5,000,000 </label>
                                                                              		<div class="col-md-3">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_turnover"  value="2000001,5000000" data-title="2,000,001-5,000,000" <?php echo ($biz_give_invest_turnover == '2000001,5000000') ? "checked='checked'":"";  ?>>                                                                                             </label>
                                                                                           
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-7 control-label" style="margin-right:40px;text-align:left">5,000,000+</label>
                                                                              		<div class="col-md-3">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_turnover"  value="5000000,0" data-title="5,000,000+" <?php echo ($biz_give_invest_turnover == '5000000,0') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                          
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                                                                                                         
                                                                                                                                                        
                                                                                <div class="box_form_subcategory">
                                                                                      <label  class="col-md-7 control-label" style="margin-right:40px;text-align:left">No Requirement</label>
                                                                                      <div class="col-md-3">
                                                                                             <div class="radio-list">
                                                                                            	<label class="radio-inline">
                                                                                             	<input type="radio" name="biz_give_invest_turnover"  value="0,0" data-title="No Requirement" <?php echo ($biz_give_invest_turnover == '0,0') ? "checked='checked'":"";  ?>>
                                                                                             	</label>
                                                                                             </div>
                                                                                     </div>
                                                                                 </div> 
                                                                             
                                                                         </div> 
                                                                     </div>  <!-- Turnover requirement  -->
                                                                     
                                                                     <div class="form-group"> <!-- Years in business   -->
                                                                     	<div class="col-md-12">
                                                                              e. Years in Business Requirements
                                                                              
                                                                              <?php $biz_give_invest_year =  $BP_Company_Full->biz_give_investment->years_in_biz_min . ',' . $BP_Company_Full->biz_give_investment->years_in_biz_max; ?>
                                                                              
                                                                              <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-7 control-label" style="margin-right:40px;text-align:left">0 - 2 Years</label>
                                                                              		<div class="col-md-3">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_yrs"  value="0,2" data-title="0 - 2 Years" <?php echo ($biz_give_invest_year == '0,2') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                           
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-7 control-label" style="margin-right:40px;text-align:left">2 - 5 Years </label>
                                                                              		<div class="col-md-3">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_yrs"  value="2,5" data-title="2 - 5 Years" <?php echo ($biz_give_invest_year == '2,5') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                        
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-7 control-label" style="margin-right:40px;text-align:left">5 - 10 Years </label>
                                                                              		<div class="col-md-3">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_yrs"  value="5,10" data-title="5 - 10 Years" <?php echo ($biz_give_invest_year == '5,10') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                         
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                 
                                                                              		<label  class="col-md-7 control-label" style="margin-right:40px;text-align:left">10 Years +</label>
                                                                              		<div class="col-md-3">
                                                                                         <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                            <input type="radio" name="biz_give_invest_yrs"  value="10,0" data-title="10 Years +" <?php echo ($biz_give_invest_year == '10,0') ? "checked='checked'":"";  ?>>
                                                                                            </label>
                                                                                           
                                                                                         </div>
                                                                              		</div>
                                                                         
                                                                             </div>
                                                                            
                                                                                                                                                            
                                                                                <div class="box_form_subcategory">
                                                                                      <label  class="col-md-7 control-label" style="margin-right:40px; text-align:left">No Requirement</label>
                                                                                      <div class="col-md-3">
                                                                                            <div class="radio-list">
                                                                                            <label class="radio-inline">
                                                                                             <input type="radio" name="biz_give_invest_yrs"  value="0,0" data-title="No Requirement" <?php echo ($biz_give_invest_year == '0,0') ? "checked='checked'":"";  ?>>
                                                                                             </label>
                                                                                             </div>
                                                                                     </div>
                                                                                 </div> 
                                                                             
                                                                         </div> 
                                                                     </div>  <!-- Years in business  -->
                                                                     
                                                                     
                                                            	</div> <!-- form-body  -->
                                                                
                                                                </div>
                                                                
                                                                </div>
                                                                
                                                         </div> <!-- col-md-4  (Invest)  -->
                                                         
                                                         <!---------------  Service Provider ------------->
                                                         <div class="col-md-4" >
                                                         	
															<div class="panel panel-info">
                                                                <div class="panel-heading"><h3 class="panel-title"><input type="checkbox" name="biz_give_service_provide_bool" value="1" data-title="Service Provider" <?php echo (isset($BP_Company_Full->bool_biz_give_service)) ? "checked='checked'":""; ?>  > Provide Services </h3></div>
                                                                <div class="panel-body">                                                            	
                                                                
                                                                <div class="form-body"  style="padding-left:20px;">
                                                             		                                                                     
                                                                    <?php foreach($service_provider as $service):  ?>
                                                                    	<?php if(!in_array($service['id'],$ngo_biz_services)):  ?>                                                                   
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left"><?php echo $service['service_name']; ?> </label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="biz_give_service_provide[]"  value="<?php echo $service['id']; ?>" data-title="<?php echo $service['service_name']; ?>"  <?php
                                                                                     if(!empty($biz_give_services)){
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
                                                                             </div>
                                                                         </div> 
                                                                     </div> 
                                                                     	<?php endif;  ?>
                                                                     <?php endforeach;  ?>
                                                                     
                                                                     <?php  
																	 	$biz_give_service_other = "";
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
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-11">
                                                                              <label  class=" control-label" style="text-align:left">g. Other, Please Specify </label><br>
                                                                               <input type="text" name="biz_give_service_provide_other" class="form-control" value="<?php echo $biz_give_service_other; ?>">
                                                                              
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     
                                                            	</div> <!-- form-body  -->
                                                                
                                                             </div>
                                                             
                                                             </div>   
                                                            
                                                         </div> <!-- col-md-4 (Service Provider) ------------>  
                                                         
                                                         <!--------------------    Partnership   ------------------------------>    
                                               			
                                                        <div class="col-md-4">
                                                        
                                                        <div class="panel panel-info">
                                                                <div class="panel-heading"><h3 class="panel-title"><input type="checkbox" name="biz_need_partner" value="1" data-title="Partner in"  <?php echo (isset($BP_Company_Full->bool_biz_need_partner_in)) ? "checked='checked'":""; ?> >Partner with Myanmar Companies</h3></div>
                                                                <div class="panel-body">
                                                        
                                                        
                                                         	<div class="form-body" style="padding-left:20px;">
                                                            
                                                                    <?php	foreach($biz_needs_partner_in as $biz_need_partner):	?> 
                                                                    	<?php if(!in_array($biz_need_partner['id'],$ngo_biz_type)):  ?>
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                        	                                                                        
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left"><?php echo $biz_need_partner['type_text'];  ?></label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline" for="biz_needs_partner_in_<?php echo $biz_need_partner['id'];  ?>">
                                                                                     <input type="checkbox" id="biz_needs_partner_in_<?php echo $biz_need_partner['id'];  ?>" name="biz_needs_partner_in[]"  value="<?php echo $biz_need_partner['id'];  ?>" data-title="<?php echo $biz_need_partner['type_text'];  ?>"  <?php 
																					
																					 if(!empty($biz_need_partner_biz_types)){
																						 if(in_array($biz_need_partner['id'],$biz_need_partner_biz_types)){
																							 echo "checked='checked'";	
																						 } else {
																							 echo "";	
																						 }
																					 } else {
																						echo "";	 
																					 }
																					 
																					 ?> >
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div> 
                                                                     	<?php endif;  ?>
																	 <?php endforeach;  ?>
                                                                     
                                                                     <?php  
																	  if ((!empty($biz_need_partner_biz_types))){
																		  
																			$biz_need_partner_biz_type_other = "";
																			foreach($BP_Company_Full->biz_need_partner_biz_types as $biz_partner):
																				if(($biz_partner->is_user_value == 1)){
																					$biz_need_partner_biz_type_other = $biz_partner->type_text;
																					break;
																				}
																			endforeach;	
																			
																	   } else {
																		   $biz_need_partner_biz_type_other = "";
																	   }
																	  ?>
                                                                     
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-11">
                                                                              <label  class=" control-label" style="text-align:left">Other, Please Specify </label><br>
                                                                               <input type="text" name="biz_needs_partner_other" class="form-control" value="<?php echo $biz_need_partner_biz_type_other; ?>" >
                                                                              
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     
                                                                     <h4>Industry</h4>
                                                                     
                                                                      <?php	foreach($biz_needs_partner_in_ind as $biz_needs_partner_ind):	?> 
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                        	                                                                        
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left"><?php echo $biz_needs_partner_ind['ind_name'];  ?></label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline" for="biz_needs_partner_in_ind_<?php echo $biz_needs_partner_ind['id'];  ?>">
                                                                                     <input type="checkbox" name="biz_needs_partner_in_ind[]" id="biz_needs_partner_in_ind_<?php echo $biz_needs_partner_ind['id'];  ?>"  value="<?php echo $biz_needs_partner_ind['id'];  ?>" data-title="<?php echo $biz_needs_partner_ind['ind_name'];  ?>" <?php 
																					 
																					 
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
                                                                             </div>
                                                                         </div> 
                                                                     </div> 
                                                                     
																	 <?php endforeach;  ?>
                                                                     
                                                                     <?php  
																	  if ((!empty($biz_need_partner_industries))){
																		  
																			$biz_need_partner_ind_other = "";
																			foreach($BP_Company_Full->biz_need_partner_industries as $biz_partner):
																				if(($biz_partner->is_user_value == 1)){
																					$biz_need_partner_ind_other = $biz_partner->ind_name;
																					break;
																				}
																			endforeach;	
																			
																	   } else {
																		   $biz_need_partner_ind_other = "";
																	   }
																	  ?>
                                                                     
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-11">
                                                                              <label  class=" control-label" style="text-align:left">Other, Please Specify </label><br>
                                                                               <input type="text" name="biz_needs_partner_in_ind_other" class="form-control" value="<?php echo  $biz_need_partner_ind_other; ?>">
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                 </div>    
                                                              </div>
                                                              
                                                              </div>   
                                                         </div> <!-- col-md-4 (Partnership)   -->
                                                         
                                                         
                                                        </div>
                                                         
                                                      </div>
                                                      </div>
                                                        
                                                        <?php endif;  ?> <!--- TYPE_INTL  --> 
                                                        
                                                        
                                                        
                                                        <?php if($mtype == "TYPE_NGO"):  ?>
                                                        <h4 class="well well-sm">Services Offered</h4>
                                                        <div class="row">
                                               			
                                                        <?php $biz_need_ngo_supp_serv = $BP_Company_Full->biz_need_ngo_supp_serv;  ?>
                                                         
                                                         <div class="col-md-6"  > <!-- col-md-6  -->
                                                         	
                                                            	<div class="panel panel-info">
                                                                <div class="panel-heading"><h4 class="panel-title"><input type="checkbox" name="biz_need_ngo_supp_serv" value="1" data-title="Non-Profit Organization" <?php echo (isset($BP_Company_Full->bool_biz_need_ngo_supp_serv)) ? "checked='checked'":""; ?>  > Services or Resources Offered </h4></div>
                                                                <div class="panel-body">
                                                                
                                                                
                                                                <div class="form-body" style="padding:10px 0 0 20px;">
                                                                              
                                                                              <?php foreach($service_provider as $services):  ?>
                                                                              		<?php if(in_array($services['id'],$ngo_biz_services)): ?>
                                                                                    <div class="form-group"> <!-- Services Provided   -->
                                                                     					<div class="col-md-12">
                                                                              
                                                                                      	<div class="box_form_subcategory">
                                                                                              <label>
                                                                                              	<input type="checkbox" name="biz_need_ngo_supp_serv_type[]"  value="<?php echo $services['id']; ?>" data-title="<?php echo $services['service_name']; ?>"  <?php
                                                                                                     if(!empty($biz_need_ngo_services_provided)){
                                                                                                         if(in_array($services['id'],$biz_need_ngo_services_provided)){
                                                                                                             echo "checked='checked'";
                                                                                                         } else {
                                                                                                             echo "";
                                                                                                         }
                                                                                                     } else {
                                                                                                         echo "";
                                                                                                     }
                                                                                                     
                                                                                                     ?>>  <?php echo $services['service_name']; ?>
                                                                                              </label>
                                                                                              
                                                                                              
                                                                                             <!--
                                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left"><?php echo $services['service_name']; ?></label>
                                                                                              <div class="col-md-2">
                                                                                                    <label class="checkbox-inline">
                                                                                                     <input type="checkbox" name="biz_need_ngo_supp_serv_type[]"  value="<?php echo $services['id']; ?>" data-title="<?php echo $services['service_name']; ?>"  <?php
                                                                                                     if(!empty($biz_need_ngo_services_provided)){
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
                                                                                             </div>
                                                                                             -->
                                                                                             
                                                                                         </div> 
                                                                                          </div> 
                                                                     				</div>  <!-- Services Provided  -->
                                                                             		<?php  endif; ?>
                                                                             <?php endforeach;  ?>
                                                                             
                                                                             <?php
																			 	$ngo_services_other = "";
																				
																				//print_r($service_provider);
																				
																				//$biz_need_ngo_supp_serv
																				
																			 	if(!empty($biz_need_ngo_supp_serv/*$biz_need_ngo_services_provided*/)):
																					foreach($biz_need_ngo_supp_serv->services_provided as $ngo_services):
																						if($ngo_services->is_user_value == 1 ){
																							$ngo_services_other = $ngo_services->service_name;
																							break;
																						}
																					endforeach;
																				endif;																	 
																			 ?>
                                                                              <div class="form-group">
                                                                                <div class="col-md-12">
                                                                                      <label  class=" control-label" style="text-align:left">Other, Please Specify </label><br>
                                                                                       <input type="text" name="biz_need_ngo_supp_serv_type_other" class="form-control" value="<?php echo $ngo_services_other; ?>">
                                                                                      
                                                                                 </div> 
                                                                               </div>  
                                                                                 
                                                                                 
                                                                        
                                                                     
										<!-- If Funding is Provided   -->                                                                     
										<!--
                                                                     <div class="form-group"> 
                                                                     	<div class="col-md-12">
                                                                              b.	If Funding is Provided
                                                                              <?php $biz_need_ngo_funding = $BP_Company_Full->biz_need_ngo_supp_serv->fund_min . ',' . $BP_Company_Full->biz_need_ngo_supp_serv->fund_max;  ?>
                                                                              <div class="box_form_subcategory">
                                                                                      <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">Up to USD $50,000</label>
                                                                                      <div class="col-md-2">
                                                                                            <label class="checkbox-inline">
                                                                                             <input type="radio" name="biz_need_ngo_ss_fund"  value="0,50000" data-title="Up to USD $50,000" <?php echo ($biz_need_ngo_funding == '0,50000') ? "checked='checked'":"";  ?>>
                                                                                             </label>
                                                                                     </div>
                                                                                 </div> 
                                                                             
                                                                             
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                      <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">USD $51,000 – 100,000</label>
                                                                                      <div class="col-md-2">
                                                                                            <label class="checkbox-inline">
                                                                                             <input type="radio" name="biz_need_ngo_ss_fund"  value="51000,100000" data-title="USD $51,000 – 100,000" <?php echo ($biz_need_ngo_funding == '51000,100000') ? "checked='checked'":"";  ?>>
                                                                                             </label>
                                                                                     </div>
                                                                             </div> 
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                      <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">USD $101,000 – 500,000</label>
                                                                                      <div class="col-md-2">
                                                                                            <label class="checkbox-inline">
                                                                                             <input type="radio" name="biz_need_ngo_ss_fund"  value="101000,500000" data-title="USD $101,000 – 500,000" <?php echo ($biz_need_ngo_funding == '101000,500000') ? "checked='checked'":"";  ?>>
                                                                                             </label>
                                                                                     </div>
                                                                             </div> 
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                      <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">USD $501,000 – 1,000,000</label>
                                                                                      <div class="col-md-2">
                                                                                            <label class="checkbox-inline">
                                                                                             <input type="radio" name="biz_need_ngo_ss_fund"  value="501000,1000000" data-title="USD $501,000 – 1,000,000" <?php echo ($biz_need_ngo_funding == '501000,1000000') ? "checked='checked'":"";  ?>>
                                                                                             </label>
                                                                                     </div>
                                                                             </div> 
                                                                             
                                                                             <div class="box_form_subcategory">
                                                                                      <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">Over USD $1,000,000</label>
                                                                                      <div class="col-md-2">
                                                                                            <label class="checkbox-inline">
                                                                                             <input type="radio" name="biz_need_ngo_ss_fund"  value="1000000,0" data-title="Over USD $1,000,000" <?php echo ($biz_need_ngo_funding == '1000000,0') ? "checked='checked'":"";  ?>>
                                                                                             </label>
                                                                                     </div>
                                                                             </div> 
                                                                             
                                                                               
                                                                                 
                                                                                 
                                                                         </div> 
                                                                     </div>  
										-->
										<!-- If Funding is Provided  -->
                                                                     
                                                                     
                                                            	</div> <!-- form-body  -->
                                                                
                                                             </div>
                                                             
                                                           </div>     
                                                            
                                                         </div> <!-- col-md-6 -->
                                                         
                                                         </div> <!--- row  --> 
                                                        
                                                        <?php endif;  ?> <!--- TYPE_NGO  --> 
											</div>
                    						<!------------------------------------- tab3  --------------------------------------->
                                        
                                            
                                            <!------------------------------------  Other Questions  ------------------------------>
                                            
                                            
                                            <!-- tab4  -->
											<div class="tab-pane" id="tab4">
												<h4 class=" well well-sm">Other Questions</h4>
                                                	<div class="row">
                                                    	<div class="container">
                                                        	<div class="form-body" style="padding-left:20px;">
                                                            		
                                                                    
                                                            
                                                            		<?php if(($mtype == "TYPE_SME") || ($mtype == "TYPE_INTL")){ 
																	
																	$partner_label = ($mtype == "TYPE_SME") ? "Looking for business partners, please describe what type of partners you are looking for (maximum 150 words).":"If you are looking for business partnership in Myanmar, please describe type of Partners (maximum 350 words).";
																	
																	?>
                                                                    
                                                                    <div class="form-group">
                                                                        <label><?php echo $partner_label; ?></label>
                                                                        <div class="col-md-12">
                                                                            <textarea class="form-control" rows="3" name="biz_need_detail_partner"><?php echo $biz_needs['biz_need_detail_partner'];  ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <?php } ?>
                                                                    
                                                                    <?php if(($mtype == "TYPE_SME")){ ?>
                                                                    
                                                                    <div class="form-group">
                                                                        <label>Looking for investors, please describe more details (maximum 150 words).</label>
                                                                        <div class="col-md-12">
                                                                            <textarea class="form-control" rows="3" name="biz_need_detail_invest"><?php echo $biz_needs['biz_need_detail_invest'];  ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-group">
                                                                        <label>Looking for service providers, please describe more details. (maximum 150 words)</label>
                                                                        <div class="col-md-12">
                                                                            <textarea class="form-control" rows="3" name="biz_need_detail_sp"><?php echo $biz_needs['biz_need_detail_sp'];  ?></textarea>
                                                                        </div>
                                                                    </div>	
                                                                    
                                                                    <?php  } ?>
                                                                    
                                                                    <?php if(($mtype == "TYPE_SME") || ($mtype == "TYPE_INTL")){ 
																	
																	$invest_label = ($mtype == "TYPE_SME") ? "Looking to invest, please provide more details (maximum 150 words)":"If you are looking to invest in Myanmar, please describe more details. (maximum 350 words)";
																	
																	$provide_services_label = ($mtype == "TYPE_SME") ? "Looking to Provide Services, please provide more details (150 words).":"If you are looking to provide services in Myanmar, please describe more details (350 words).";
																	
																	?>
                                                                    
                                                                    <div class="form-group">
                                                                        <label><?php echo $invest_label; ?></label>
                                                                        <div class="col-md-12">
                                                                            <textarea class="form-control" rows="3" name="biz_give_detail_invest"><?php echo $biz_needs['biz_give_detail_invest']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-group">
                                                                        <label><?php echo $provide_services_label; ?></label>
                                                                        <div class="col-md-12">
                                                                            <textarea class="form-control" rows="3" name="biz_give_detail_sp"><?php echo $biz_needs['biz_give_detail_sp']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <?php  } ?>
                                                                    
                                                                    <!-----------------     Non-Profit Other Questions      ------------------->
                                                                    
                                                                    <?php if($mtype == "TYPE_NGO") {  ?>
                                                                    
                                                                     <div class="form-group">
                                                                        <label>Please provide more details about the services and resources offered by your organization (maximum 350 words).</label>
                                                                        <div class="col-md-12">
                                                                            <textarea class="form-control" rows="3" name="biz_need_detail_ngo"><?php echo $biz_needs['biz_need_detail_ngo']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                
                                                            		<?php } ?>
                                                            
                                                            
                                                				
                                                
                                                				</div>
                                                			</div>
													</div>
											</div>
                                            <!-- tab4  -->                                            
                                            <!----------------------------     Summary     ------------------>
                                            
                                            <!-- tab5  -->
											<div class="tab-pane" id="tab5">
												<h4 class="well well-sm">Detailed Summary</h4>
												<h4 class="form-section">General Info</h4>
                                                
                                                <div class="col-md-12">
                                                    
                                                    <div class="col-md-6" >
                                                    	<div class="form-group">
                                                            <label class="control-label col-md-6">Company Name:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="company_name"></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Country of Incorporation:</label>
                                                            <div class="col-md-6">
                                                            <?php //if($mtype == "TYPE_INTL"){  ?>
                                                                <p class="form-control-static bold" data-display="country_of_incorporate"></p>
                                                             <?php //} else {  ?>
                                                           
                                                           <!--     	<p class="form-control-static bold" >Myanmar</p>  -->
                                                                <?php //} ?>    
                                                            </div>
                                                        </div>
                                                        
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Year of Incorporation:</label>
                                                            <div class="col-md-6">
                                                            	
                                                                	<p class="form-control-static bold" data-display="year_of_incorporate"></p>
                                                               
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Business Registration:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="reg_number"></p>
                                                            </div>
                                                        </div>
                                                    
                                                    </div> <!-- col-md-6  -->
                                                    
                                                     <div class="col-md-6" >
                                                    	
                                                         <div class="form-group">
                                                            <label class="control-label col-md-6">Location of Head Office:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="location_head_office"></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">CEO / Managing Director:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="ceo_md"></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Other Branches:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="other_branch"></p>
                                                            </div>
                                                        </div>
                                                    
                                                    </div> <!-- col-md-6  -->
                                                </div> <!-- col-md-12  -->
                                                
                                                <div class="clearfix"></div>
                                               
                                                <div class="col-md-12">
                                                    
                                                    <div class="col-md-6" >
                                                    	<div class="form-group">
                                                            <label class="control-label col-md-6">Address 1:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="address_number"></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Town / City:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="address_city"></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">State / Region:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="address_region"></p>
                                                            </div>
                                                        </div>
                                                    
                                                    </div> <!-- col-md-6  -->
                                                    
                                                     <div class="col-md-6" >
                                                    	
                                                         <div class="form-group">
                                                            <label class="control-label col-md-6">Address 2:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="address_street"></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Postal Code:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="address_postal_code"></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Country:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="address_country"></p>
                                                            </div>
                                                        </div>
                                                    
                                                    </div> <!-- col-md-6  -->
                                                </div> <!-- col-md-12  -->
                                                
                                                <div class="clearfix"></div>
                                                
                                                <!--  Contact Details -->
                                               
                                                <div class="col-md-12">
                                                    
                                                    <div class="col-md-6" >
                                                    	<div class="form-group">
                                                            <label class="control-label col-md-6">Contact person:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="contact_person"></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Office telephone:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="contact_telephone"></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Fax:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="contact_fax"></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Website:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="contact_web"></p>
                                                            </div>
                                                        </div>
                                                    
                                                    </div> <!-- col-md-6  -->
                                                    
                                                     <div class="col-md-6" >
                                                    	
                                                         <div class="form-group">
                                                            <label class="control-label col-md-6">Position Title:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="contact_position"></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Mobile:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="contact_mobile"></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Email:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="contact_email"></p>
                                                            </div>
                                                        </div>
                                                    
                                                    </div> <!-- col-md-6  -->
                                                </div> <!-- col-md-12  -->
                                                
                                                <!--  Contact Details -->
                                                
                                                
                                                <div class="clearfix"></div>
												<h4 class="form-section">Business Related</h4>
                                                
                                                <div class="col-md-12">
                                                	<div class="col-md-6">
                                                    
                                                    	<div class="form-group">
                                                            <label class="control-label col-md-6">Type of Business:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="company_biz_types"></p>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Other Business:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="company_biz_types_other"></p>
                                                            </div>
                                                        </div>
                                                        
                                                        <?php if(($mtype == "TYPE_SME") || ($mtype == "TYPE_INTL")):  ?>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-6">Industry Operates:</label>
                                                                <div class="col-md-6">
                                                                    <p class="form-control-static bold" data-display="company_industries"></p>
                                                                </div>
                                                            </div>
                                                    	<?php endif;  ?>
                                                    </div> <!-- col-md-6  -->
                                                    
                                                    <div class="col-md-6">
                                                    	<?php if(($mtype == "TYPE_SME") || ($mtype == "TYPE_INTL")):  ?>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-6">Annual Turnover:</label>
                                                                <div class="col-md-6">
                                                                    <p class="form-control-static bold" data-display="turnover"></p>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="control-label col-md-6">Number of Employees:</label>
                                                                <div class="col-md-6">
                                                                    <p class="form-control-static bold" data-display="num_employee"></p>
                                                                </div>
                                                            </div>
                                                        <?php endif;  ?>
                                                        <div class="form-group">
                                                            <label class="control-label col-md-6">Company's Background:</label>
                                                            <div class="col-md-6">
                                                                <p class="form-control-static bold" data-display="summary"></p>
                                                            </div>
                                                        </div>
                                                    
                                                    </div> <!-- col-md-6  -->
                                                </div> <!-- col-md-12  -->
												
                                                <div class="clearfix"></div>
												
                                                <!------------------  Business Needs Summary   ------------->
                                                
                                                <div class="row">
                                                <div class="container">
                                                
												
                                                	<div class="col-md-12">
                                                    	 <?php if(($mtype == "TYPE_SME")):  ?>
                                                		<div class="col-md-6">
                                                        <h4 class="form-section">Looking For </h4>	
                                                           
                                                            <!----------  Investment  -------->
                                                            <h5>Investment</h5>  
                                                            <div class="form-group">
                                                                 <label class="control-label col-md-6">Amount:</label>
                                                                 <div class="col-md-6">
                                                                      <p class="form-control-static bold" data-display="biz_need_invest_amount"></p>
                                                                 </div>
                                                             </div>  
                                                            
                                                            
                                                            <!----------  Partner(s) in  -------->
                                                            <h5>Partner(s)</h5>
                                                            
                                                            <div class="form-group">
                                                                <label class="control-label col-md-6">Type of Business: </label>
                                                                <div class="col-md-6">
                                                                    <p class="form-control-static bold" data-display="biz_needs_partner_in"></p>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="control-label col-md-6">Others: </label>
                                                                <div class="col-md-6">
                                                                    <p class="form-control-static bold" data-display="biz_needs_partner_other"></p>
                                                                </div>
                                                            </div>
                                                            
                                                            
                                                            <div class="form-group">
                                                                <label class="control-label col-md-6">Industry: </label>
                                                                <div class="col-md-6">
                                                                    <p class="form-control-static bold" data-display="biz_needs_partner_in_ind"></p>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="form-group">
                                                                <label class="control-label col-md-6">Other Industry: </label>
                                                                <div class="col-md-6">
                                                                    <p class="form-control-static bold" data-display="biz_needs_partner_in_ind_other"></p>
                                                                </div>
                                                            </div>
                                                           
                                                             <!----------  Service Providers  -------->   
                                                             <h5>Service Providers</h5>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-6">Service Provider:</label>
                                                                    <div class="col-md-6">
                                                                        <p class="form-control-static bold" data-display="biz_needs_service_provide"></p>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-6">Other Service Provider:</label>
                                                                    <div class="col-md-6">
                                                                        <p class="form-control-static bold" data-display="biz_needs_service_provide_other"></p>
                                                                    </div>
                                                                </div>   
                                                                
                                                            
                                                            
                                                       
                                                            
                                                             <!----------  Service Providers  -------->
                                                            
                                                        </div><!-- col-md-6  -->
                                                        
                                                        
                                                        <div class="col-md-6">
                                                        	<h4 class="form-section">Looking To </h4>
                                                        		<!----------  Investors  -------->
                                                              
                                                                		<h5>Invest</h5>
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-6">Amount:</label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="biz_give_invest_amount"></p>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-6">Employee Size:</label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="biz_give_invest_emp_size"></p>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-6">Industry to Invest:</label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="biz_give_invest_ind"></p>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        
                                                                        
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-6">Turnover Requirement:</label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="biz_give_invest_turnover"></p>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-6">Years of Business Requirement:</label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="biz_give_invest_yrs"></p>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <h5>Provide Services</h5>
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-6">Service Provider:</label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="biz_give_service_provide"></p>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-6">Other Service Provider:</label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="biz_give_service_provide_other"></p>
                                                                            </div>
                                                                        </div>
                                                                <!----------  Investors  -------->
                                                        
                                                        </div><!-- col-md-6  -->
                                                         <?php endif;   ?>
                                                         
                                                         <?php if(($mtype == "TYPE_INTL")):  ?>
                                                         <div class="col-md-6">
                                                        	<h4 class="form-section">Looking To </h4>
                                                        		
                                                                <!-----   Invest   -------->
                                                                <h5>Invest</h5>
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-6">Amount:</label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="biz_give_invest_amount"></p>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-6">Employee Size:</label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="biz_give_invest_emp_size"></p>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-6">Industry to Invest:</label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="biz_give_invest_ind"></p>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        
                                                                        
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-6">Turnover Requirement:</label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="biz_give_invest_turnover"></p>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-6">Years of Business Requirement:</label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="biz_give_invest_yrs"></p>
                                                                            </div>
                                                                        </div>
                                                        
                                                        
                                                            <h5>Provide Services</h5>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-6">Service Provider:</label>
                                                                    <div class="col-md-6">
                                                                        <p class="form-control-static bold" data-display="biz_give_service_provide"></p>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-6">Other Service Provider:</label>
                                                                    <div class="col-md-6">
                                                                        <p class="form-control-static bold" data-display="biz_give_service_provide_other"></p>
                                                                    </div>
                                                                </div>
                                                             </div>
                                                             
                                                             <div class="col-md-6">
                                                             <h4 class="form-section">&nbsp;</h4>
                                                             	<!----------  Partner(s) in  -------->
                                                            	<h5>Partner with Myanmar Companies</h5>
                                                            
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-6">Type of Business: </label>
                                                                        <div class="col-md-6">
                                                                            <p class="form-control-static bold" data-display="biz_needs_partner_in"></p>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-6">Others: </label>
                                                                        <div class="col-md-6">
                                                                            <p class="form-control-static bold" data-display="biz_needs_partner_other"></p>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-6">Industry: </label>
                                                                        <div class="col-md-6">
                                                                            <p class="form-control-static bold" data-display="biz_needs_partner_in_ind"></p>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="form-group">
                                                                        <label class="control-label col-md-6">Other Industry: </label>
                                                                        <div class="col-md-6">
                                                                            <p class="form-control-static bold" data-display="biz_needs_partner_in_ind_other"></p>
                                                                        </div>
                                                                    </div>
                                                            
                                                                
                                                             </div>   
                                                         
                                                         <?php endif;  ?>
                                                         
                                                         <?php if(($mtype == "TYPE_NGO")):  ?>
                                                         <div class="col-md-6">
                                                         	<h4 class="form-section">Non-Profit Organizations</h4>
                                                         
                                                                 <div class="form-group">
                                                                            <label class="control-label col-md-6">Organization Type: </label>
                                                                            <div class="col-md-6">
                                                                                <p class="form-control-static bold" data-display="company_biz_types"></p>
                                                                            </div>
                                                                 </div>
                                                         		<div class="form-group">
                                                                    <label class="control-label col-md-6">Services Provided:</label>
                                                                    <div class="col-md-6">
                                                                        <p class="form-control-static bold" data-display="biz_need_ngo_supp_serv_type"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-6">Other Services Provided:</label>
                                                                    <div class="col-md-6">
                                                                        <p class="form-control-static bold" data-display="biz_need_ngo_supp_serv_type_other"></p>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!--
                                                                <div class="form-group">
                                                                    <label class="control-label col-md-6">If Funding is Provided:</label>
                                                                    <div class="col-md-6">
                                                                        <p class="form-control-static bold" data-display="biz_need_ngo_ss_fund"></p>
                                                                    </div>
                                                                </div>
                                                                -->
                                                                
                                                         </div>
                                                         <?php endif;  ?>
                                                         
                                                        
                                                	</div> <!-- col-md-12  -->
                                                </div>
                                                </div>
                                                
												
                                                <!------------------  Other Questions Summary   ------------->
                                                
                                                <div class="clearfix"></div>
                                                <h4 class="form-section">Other Questions</h4>
                                                
                                                
                                                
                                                <?php if(($mtype == "TYPE_INTL") || ($mtype == "TYPE_SME")){ ?>
                                                
                                                	<div class="form-group">
                                                        <label class="control-label col-md-3">Looking for Partners:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static bold" data-display="biz_need_detail_partner"></p>
                                                        </div>
                                                    </div>
                                                    
                                                <?php } ?>    
                                                
                                                
                                                <?php if(($mtype == "TYPE_SME")){ ?>	
                                                
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Looking for Investors:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static bold" data-display="biz_need_detail_invest"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Looking for Service Providers:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static bold" data-display="biz_need_detail_sp"></p>
                                                        </div>
                                                    </div>
                                                
                                                <?php  }  ?>
                                                
                                                
                                                <?php if(($mtype == "TYPE_INTL") || ($mtype == "TYPE_SME")){ ?>	
                                                
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Looking to Invest:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static bold" data-display="biz_give_detail_invest"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">Looking to Provide Services:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static bold" data-display="biz_give_detail_sp"></p>
                                                        </div>
                                                    </div>
                                                
                                                <?php } ?>

                                                
                                                <?php  if($mtype == "TYPE_NGO"){ ?>
                                                
                                                	<div class="form-group">
                                                        <label class="control-label col-md-3">NonProfit Org:</label>
                                                        <div class="col-md-9">
                                                            <p class="form-control-static bold" data-display="biz_need_detail_ngo"></p>
                                                        </div>
                                                    </div>
                                                <?php  } ?>

                                                
                                                <hr class="" />
                                                
                                                <div class="clearfix"></div>
                                                <h4 class="form-section">Terms and Conditions</h4>
                                                <div class="form-group">
													
													<div class="col-md-12" style="padding-left:20px;">
														<div class="well well-sm">
                                                        <input type="checkbox" name="terms_accepted" value="1" id="terms_and_conditions" <?php echo ($BP_Company_Full->terms_accepted == 1) ? "checked='checked'":"";  ?>> I agree to the <a href="#" title="Terms &amp; conditions" data-toggle="modal" data-target="#model_terms">Terms and Conditions</a>  stated in this directory. 		
                                                        </div>
													</div>
												</div>
                                                
                                                
                                                <div id="error_message">
                                                    
                                                </div>
                                                
											</div>
                                            <!-- tab5  -->
                                            
                                            
                                            
                                            
										</div>
                                        <!-- tab content  -->
                                        
									</div>
                                    <!--  form body  -->
                                    <div class="progress"></div>
									<div class="form-actions fluid">
										<div class="row">
											<div class="col-md-12 ">
                                            	<div class="pull-left">
                                                	<small><span class="label_required">*</span> Required fields.</small>
                                                </div>
                                            
												<div class="pull-right">
													<a href="javascript:;" class="btn default button-previous">
													<i class="m-icon-swapleft"></i> Back 
													</a>
													<a href="javascript:;" class="btn green button-next">
													Continue <i class="m-icon-swapright m-icon-white"></i>
													</a>
													
                                                    <a href="javascript:;" class="btn yellow button-submit">
													Submit <i class="m-icon-swapright m-icon-white"></i>
													</a>
                                                   
                                                    <!--
                                                    <button type="submit" name="Application_Form" class="btn yellow button-submit">
                                                    	Submit <i class="m-icon-swapright m-icon-white"></i>
                                                    </button>  
                                                     -->                          
												</div>
											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- END PAGE CONTENT-->    
		</div>
		<!-- END PAGE -->  
	</div>
    
    <script>
	
	function check_email(){
		$('#contact_email').live('change', function(){
			$.ajax({
				url: "/ajax/",
				dataType:"json",
				type: "POST",
				data: { 
					'contact_email': $('#contact_email').val()
				},	
				success: function(data){
					/*if(data.result){
						alert('Email exists');
					} else {
						alert('Email available');
					}*/
				},
				error: function(data){
					console.log(data);
					alert('Error in getting the email');	
				}
			});	
		});	
	}
	
	function form_wizard(){
		
		FormWizard.init();
	}
	
	function initialize_form_business()
	{
		
		   		$('#sme_window').modal({backdrop:'static'});
				$('#form_dialog_biz_reg').on( "submit", function( event ) {
				  	event.preventDefault();
				  	var biz_reg = $('#biz_registration').val();
			  		var biz_country = $('#country_incorp').val(); 
				  $.ajax({
						type:"POST",
						url:"/ajax/",
						dataType:'json',
						data:{mode:'CHECK_COMPANY',reg_no:'registration no',num:34 },
						success: function(data){
								if(data){
									$('#sme_window').modal('hide');
									$('#business_registration').val(biz_reg);
									$('#country_of_incorporate').val(biz_country).change();
									$('#address_country').val(biz_country).change();
									
								}
						}
						
				  });
				});
	}
	</script>
    
    <?php Theme_Vars::add_script_ready('form_wizard();');  ?>
    
    <?php if (is_null($company_id) || $company_id == 0) : ?>
    <?php //Theme_Vars::add_script_ready('initialize_form_business();'); ?>
    <?php //Theme_Vars::add_script_ready('check_email();'); ?>
    <?php endif; ?>
    
    <?php
    $post_id = 489;
    $queried_post = get_post($post_id);
    $title = $queried_post->post_title;
    ?>
    
    
    
    <div class="modal fade" id="model_terms" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title"><?php echo $title; ?></h4>
          </div>
          <div class="modal-body">
            <p><?php
            $content = apply_filters('the_content', $queried_post->post_content);
            echo $content; ?></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
   
	<!-- END CONTAINER -->
	<?php get_footer(); ?>
    
    
    
 