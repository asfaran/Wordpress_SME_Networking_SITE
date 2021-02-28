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
   <link href="assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>              
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
				<div class="col-md-12 col-sm-12">
                	
					<div class="row">
                    	<div class="col-md-12">
                    	 <!-- BLOCK START -->   
                           <div class="panel panel-warning">
                                <div class="panel-heading"><h2 class="panel-title">Application for SME Myanmar</h2></div>
                                <div class="panel-body" style="background-color:#f5f5f5">
                                	<div class="space20"></div>	
                                 	
                                 
                                         <form class="form-horizontal" role="form" action="" method="post">
                                            <div class="form-body">
                                            
                                            <div class="row">
                                            <div class="col-offset-2 col-md-8">
                                            
                                               <div class="form-group">
                                                  <label  class="col-md-5 control-label">Company name:</label>
                                                  <div class="col-md-7">
                                                     <input type="text" class="form-control"  >
                                                  </div>
                                               </div>
                                               
                                               <div class="form-group">
                                                  <label  class="col-md-5 control-label">Country of incorporation:</label>
                                                  <div class="col-md-7">
                                                     <select id="countries" name="countries" class="form-control">
                                                        <option value="Afghanistan">Afghanistan</option>
                                                        <option value="Åland Islands">Åland Islands</option>
                                                        <option value="Albania">Albania</option>
                                                        <option value="Algeria">Algeria</option>
                                                        <option value="American Samoa">American Samoa</option>
                                                        <option value="Andorra">Andorra</option>
                                                        <option value="Angola">Angola</option>
                                                        <option value="Anguilla">Anguilla</option>
                                                        <option value="Antarctica">Antarctica</option>
                                                        <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                        <option value="Argentina">Argentina</option>
                                                        <option value="Armenia">Armenia</option>
                                                        <option value="Aruba">Aruba</option>
                                                        <option value="Australia">Australia</option>
                                                        <option value="Austria">Austria</option>
                                                        <option value="Azerbaijan">Azerbaijan</option>
                                                        <option value="Bahamas">Bahamas</option>
                                                        <option value="Bahrain">Bahrain</option>
                                                        <option value="Bangladesh">Bangladesh</option>
                                                        <option value="Barbados">Barbados</option>
                                                        <option value="Belarus">Belarus</option>
                                                        <option value="Belgium">Belgium</option>
                                                        <option value="Belize">Belize</option>
                                                        <option value="Benin">Benin</option>
                                                        <option value="Bermuda">Bermuda</option>
                                                        <option value="Bhutan">Bhutan</option>
                                                        <option value="Bolivia">Bolivia</option>
                                                        <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                        <option value="Botswana">Botswana</option>
                                                        <option value="Bouvet Island">Bouvet Island</option>
                                                        <option value="Brazil">Brazil</option>
                                                        <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                        <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                        <option value="Bulgaria">Bulgaria</option>
                                                        <option value="Burkina Faso">Burkina Faso</option>
                                                        <option value="Burundi">Burundi</option>
                                                        <option value="Cambodia">Cambodia</option>
                                                        <option value="Cameroon">Cameroon</option>
                                                        <option value="Canada">Canada</option>
                                                        <option value="Cape Verde">Cape Verde</option>
                                                        <option value="Cayman Islands">Cayman Islands</option>
                                                        <option value="Central African Republic">Central African Republic</option>
                                                        <option value="Chad">Chad</option>
                                                        <option value="Chile">Chile</option>
                                                        <option value="China">China</option>
                                                        <option value="Christmas Island">Christmas Island</option>
                                                        <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                                        <option value="Colombia">Colombia</option>
                                                        <option value="Comoros">Comoros</option>
                                                        <option value="Congo">Congo</option>
                                                        <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                                                        <option value="Cook Islands">Cook Islands</option>
                                                        <option value="Costa Rica">Costa Rica</option>
                                                        <option value="Cote D'ivoire">Cote D'ivoire</option>
                                                        <option value="Croatia">Croatia</option>
                                                        <option value="Cuba">Cuba</option>
                                                        <option value="Cyprus">Cyprus</option>
                                                        <option value="Czech Republic">Czech Republic</option>
                                                        <option value="Denmark">Denmark</option>
                                                        <option value="Djibouti">Djibouti</option>
                                                        <option value="Dominica">Dominica</option>
                                                        <option value="Dominican Republic">Dominican Republic</option>
                                                        <option value="Ecuador">Ecuador</option>
                                                        <option value="Egypt">Egypt</option>
                                                        <option value="El Salvador">El Salvador</option>
                                                        <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                        <option value="Eritrea">Eritrea</option>
                                                        <option value="Estonia">Estonia</option>
                                                        <option value="Ethiopia">Ethiopia</option>
                                                        <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                                        <option value="Faroe Islands">Faroe Islands</option>
                                                        <option value="Fiji">Fiji</option>
                                                        <option value="Finland">Finland</option>
                                                        <option value="France">France</option>
                                                        <option value="French Guiana">French Guiana</option>
                                                        <option value="French Polynesia">French Polynesia</option>
                                                        <option value="French Southern Territories">French Southern Territories</option>
                                                        <option value="Gabon">Gabon</option>
                                                        <option value="Gambia">Gambia</option>
                                                        <option value="Georgia">Georgia</option>
                                                        <option value="Germany">Germany</option>
                                                        <option value="Ghana">Ghana</option>
                                                        <option value="Gibraltar">Gibraltar</option>
                                                        <option value="Greece">Greece</option>
                                                        <option value="Greenland">Greenland</option>
                                                        <option value="Grenada">Grenada</option>
                                                        <option value="Guadeloupe">Guadeloupe</option>
                                                        <option value="Guam">Guam</option>
                                                        <option value="Guatemala">Guatemala</option>
                                                        <option value="Guernsey">Guernsey</option>
                                                        <option value="Guinea">Guinea</option>
                                                        <option value="Guinea-bissau">Guinea-bissau</option>
                                                        <option value="Guyana">Guyana</option>
                                                        <option value="Haiti">Haiti</option>
                                                        <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                                        <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                                        <option value="Honduras">Honduras</option>
                                                        <option value="Hong Kong">Hong Kong</option>
                                                        <option value="Hungary">Hungary</option>
                                                        <option value="Iceland">Iceland</option>
                                                        <option value="India">India</option>
                                                        <option value="Indonesia">Indonesia</option>
                                                        <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                                        <option value="Iraq">Iraq</option>
                                                        <option value="Ireland">Ireland</option>
                                                        <option value="Isle of Man">Isle of Man</option>
                                                        <option value="Israel">Israel</option>
                                                        <option value="Italy">Italy</option>
                                                        <option value="Jamaica">Jamaica</option>
                                                        <option value="Japan">Japan</option>
                                                        <option value="Jersey">Jersey</option>
                                                        <option value="Jordan">Jordan</option>
                                                        <option value="Kazakhstan">Kazakhstan</option>
                                                        <option value="Kenya">Kenya</option>
                                                        <option value="Kiribati">Kiribati</option>
                                                        <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                                        <option value="Korea, Republic of">Korea, Republic of</option>
                                                        <option value="Kuwait">Kuwait</option>
                                                        <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                        <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                                        <option value="Latvia">Latvia</option>
                                                        <option value="Lebanon">Lebanon</option>
                                                        <option value="Lesotho">Lesotho</option>
                                                        <option value="Liberia">Liberia</option>
                                                        <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                        <option value="Liechtenstein">Liechtenstein</option>
                                                        <option value="Lithuania">Lithuania</option>
                                                        <option value="Luxembourg">Luxembourg</option>
                                                        <option value="Macao">Macao</option>
                                                        <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                                                        <option value="Madagascar">Madagascar</option>
                                                        <option value="Malawi">Malawi</option>
                                                        <option value="Malaysia">Malaysia</option>
                                                        <option value="Maldives">Maldives</option>
                                                        <option value="Mali">Mali</option>
                                                        <option value="Malta">Malta</option>
                                                        <option value="Marshall Islands">Marshall Islands</option>
                                                        <option value="Martinique">Martinique</option>
                                                        <option value="Mauritania">Mauritania</option>
                                                        <option value="Mauritius">Mauritius</option>
                                                        <option value="Mayotte">Mayotte</option>
                                                        <option value="Mexico">Mexico</option>
                                                        <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                                        <option value="Moldova, Republic of">Moldova, Republic of</option>
                                                        <option value="Monaco">Monaco</option>
                                                        <option value="Mongolia">Mongolia</option>
                                                        <option value="Montenegro">Montenegro</option>
                                                        <option value="Montserrat">Montserrat</option>
                                                        <option value="Morocco">Morocco</option>
                                                        <option value="Mozambique">Mozambique</option>
                                                        <option value="Myanmar">Myanmar</option>
                                                        <option value="Namibia">Namibia</option>
                                                        <option value="Nauru">Nauru</option>
                                                        <option value="Nepal">Nepal</option>
                                                        <option value="Netherlands">Netherlands</option>
                                                        <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                        <option value="New Caledonia">New Caledonia</option>
                                                        <option value="New Zealand">New Zealand</option>
                                                        <option value="Nicaragua">Nicaragua</option>
                                                        <option value="Niger">Niger</option>
                                                        <option value="Nigeria">Nigeria</option>
                                                        <option value="Niue">Niue</option>
                                                        <option value="Norfolk Island">Norfolk Island</option>
                                                        <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                        <option value="Norway">Norway</option>
                                                        <option value="Oman">Oman</option>
                                                        <option value="Pakistan">Pakistan</option>
                                                        <option value="Palau">Palau</option>
                                                        <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                                        <option value="Panama">Panama</option>
                                                        <option value="Papua New Guinea">Papua New Guinea</option>
                                                        <option value="Paraguay">Paraguay</option>
                                                        <option value="Peru">Peru</option>
                                                        <option value="Philippines">Philippines</option>
                                                        <option value="Pitcairn">Pitcairn</option>
                                                        <option value="Poland">Poland</option>
                                                        <option value="Portugal">Portugal</option>
                                                        <option value="Puerto Rico">Puerto Rico</option>
                                                        <option value="Qatar">Qatar</option>
                                                        <option value="Reunion">Reunion</option>
                                                        <option value="Romania">Romania</option>
                                                        <option value="Russian Federation">Russian Federation</option>
                                                        <option value="Rwanda">Rwanda</option>
                                                        <option value="Saint Helena">Saint Helena</option>
                                                        <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                        <option value="Saint Lucia">Saint Lucia</option>
                                                        <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                                        <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                                        <option value="Samoa">Samoa</option>
                                                        <option value="San Marino">San Marino</option>
                                                        <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                                        <option value="Senegal">Senegal</option>
                                                        <option value="Serbia">Serbia</option>
                                                        <option value="Seychelles">Seychelles</option>
                                                        <option value="Sierra Leone">Sierra Leone</option>
                                                        <option value="Singapore">Singapore</option>
                                                        <option value="Slovakia">Slovakia</option>
                                                        <option value="Slovenia">Slovenia</option>
                                                        <option value="Solomon Islands">Solomon Islands</option>
                                                        <option value="Somalia">Somalia</option>
                                                        <option value="South Africa">South Africa</option>
                                                        <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                                        <option value="Spain">Spain</option>
                                                        <option value="Sri Lanka">Sri Lanka</option>
                                                        <option value="Sudan">Sudan</option>
                                                        <option value="Suriname">Suriname</option>
                                                        <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                                        <option value="Swaziland">Swaziland</option>
                                                        <option value="Sweden">Sweden</option>
                                                        <option value="Switzerland">Switzerland</option>
                                                        <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                                        <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                                        <option value="Tajikistan">Tajikistan</option>
                                                        <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                                        <option value="Thailand">Thailand</option>
                                                        <option value="Timor-leste">Timor-leste</option>
                                                        <option value="Togo">Togo</option>
                                                        <option value="Tokelau">Tokelau</option>
                                                        <option value="Tonga">Tonga</option>
                                                        <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                        <option value="Tunisia">Tunisia</option>
                                                        <option value="Turkey">Turkey</option>
                                                        <option value="Turkmenistan">Turkmenistan</option>
                                                        <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                                        <option value="Tuvalu">Tuvalu</option>
                                                        <option value="Uganda">Uganda</option>
                                                        <option value="Ukraine">Ukraine</option>
                                                        <option value="United Arab Emirates">United Arab Emirates</option>
                                                        <option value="United Kingdom">United Kingdom</option>
                                                        <option value="United States">United States</option>
                                                        <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                                        <option value="Uruguay">Uruguay</option>
                                                        <option value="Uzbekistan">Uzbekistan</option>
                                                        <option value="Vanuatu">Vanuatu</option>
                                                        <option value="Venezuela">Venezuela</option>
                                                        <option value="Viet Nam">Viet Nam</option>
                                                        <option value="Virgin Islands, British">Virgin Islands, British</option>
                                                        <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                                        <option value="Wallis and Futuna">Wallis and Futuna</option>
                                                        <option value="Western Sahara">Western Sahara</option>
                                                        <option value="Yemen">Yemen</option>
                                                        <option value="Zambia">Zambia</option>
                                                        <option value="Zimbabwe">Zimbabwe</option>
                                                        </select>

                                                  </div>
                                               </div>
                                               <div class="form-group">
                                                  <label  class="col-md-5 control-label">Year of incorporation:</label>
                                                  <div class="col-md-7">
                                                     <input type="text" class="form-control"  >
                                                  </div>
                                               </div>
                    
                                               <div class="form-group">
                                                  <label  class="col-md-5 control-label">Location of head office:</label>
                                                  <div class="col-md-7">
                                                     <input type="text" class="form-control" >
                                                  </div>
                                               </div>
                                               
                                               <div class="form-group">
                                                  <label  class="col-md-5 control-label">CEO / Managing Director:</label>
                                                  <div class="col-md-7">
                                                     <input type="text" class="form-control" >
                                                  </div>
                                               </div>
                                               
                                               <div class="form-group">
                                                  <label  class="col-md-5 control-label">Other Branches:</label>
                                                  <div class="col-md-7">
                                                     <input type="text" class="form-control"  >
                                                  </div>
                                               </div>
                                               
                                           </div>
                                           
                                           </div>
                                           
                                           
                                           <div class="row">
                                           		<h4 style="margin-left:20px;">Mailing Address</h4>  
                                               <div class="col-md-12">  
                                                 	<div class="col-md-6">  <!-- col-md-6  -->
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">No:</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  >
                                                              </div>
                                                        </div>
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Town/City</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  >
                                                              </div>
                                                        </div>
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">State/Region</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  >
                                                              </div>
                                                         </div>
                                            		</div> <!-- col-md-6  -->
                                                    
                                                    
                                                    <div class="col-md-6"> <!-- col-md-6  -->
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Street:</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  >
                                                              </div>
                                                         </div>
                                                       
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Postal Code: </label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  >
                                                              </div>
                                                         </div>
                                                        
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Country:</label>
                                                              <div class="col-md-7">
                                                                 <select id="countries" name="countries" class="form-control">
                                                                    <option value="Afghanistan">Afghanistan</option>
                                                                    <option value="Åland Islands">Åland Islands</option>
                                                                    <option value="Albania">Albania</option>
                                                                    <option value="Algeria">Algeria</option>
                                                                    <option value="American Samoa">American Samoa</option>
                                                                    <option value="Andorra">Andorra</option>
                                                                    <option value="Angola">Angola</option>
                                                                    <option value="Anguilla">Anguilla</option>
                                                                    <option value="Antarctica">Antarctica</option>
                                                                    <option value="Antigua and Barbuda">Antigua and Barbuda</option>
                                                                    <option value="Argentina">Argentina</option>
                                                                    <option value="Armenia">Armenia</option>
                                                                    <option value="Aruba">Aruba</option>
                                                                    <option value="Australia">Australia</option>
                                                                    <option value="Austria">Austria</option>
                                                                    <option value="Azerbaijan">Azerbaijan</option>
                                                                    <option value="Bahamas">Bahamas</option>
                                                                    <option value="Bahrain">Bahrain</option>
                                                                    <option value="Bangladesh">Bangladesh</option>
                                                                    <option value="Barbados">Barbados</option>
                                                                    <option value="Belarus">Belarus</option>
                                                                    <option value="Belgium">Belgium</option>
                                                                    <option value="Belize">Belize</option>
                                                                    <option value="Benin">Benin</option>
                                                                    <option value="Bermuda">Bermuda</option>
                                                                    <option value="Bhutan">Bhutan</option>
                                                                    <option value="Bolivia">Bolivia</option>
                                                                    <option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option>
                                                                    <option value="Botswana">Botswana</option>
                                                                    <option value="Bouvet Island">Bouvet Island</option>
                                                                    <option value="Brazil">Brazil</option>
                                                                    <option value="British Indian Ocean Territory">British Indian Ocean Territory</option>
                                                                    <option value="Brunei Darussalam">Brunei Darussalam</option>
                                                                    <option value="Bulgaria">Bulgaria</option>
                                                                    <option value="Burkina Faso">Burkina Faso</option>
                                                                    <option value="Burundi">Burundi</option>
                                                                    <option value="Cambodia">Cambodia</option>
                                                                    <option value="Cameroon">Cameroon</option>
                                                                    <option value="Canada">Canada</option>
                                                                    <option value="Cape Verde">Cape Verde</option>
                                                                    <option value="Cayman Islands">Cayman Islands</option>
                                                                    <option value="Central African Republic">Central African Republic</option>
                                                                    <option value="Chad">Chad</option>
                                                                    <option value="Chile">Chile</option>
                                                                    <option value="China">China</option>
                                                                    <option value="Christmas Island">Christmas Island</option>
                                                                    <option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>
                                                                    <option value="Colombia">Colombia</option>
                                                                    <option value="Comoros">Comoros</option>
                                                                    <option value="Congo">Congo</option>
                                                                    <option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>
                                                                    <option value="Cook Islands">Cook Islands</option>
                                                                    <option value="Costa Rica">Costa Rica</option>
                                                                    <option value="Cote D'ivoire">Cote D'ivoire</option>
                                                                    <option value="Croatia">Croatia</option>
                                                                    <option value="Cuba">Cuba</option>
                                                                    <option value="Cyprus">Cyprus</option>
                                                                    <option value="Czech Republic">Czech Republic</option>
                                                                    <option value="Denmark">Denmark</option>
                                                                    <option value="Djibouti">Djibouti</option>
                                                                    <option value="Dominica">Dominica</option>
                                                                    <option value="Dominican Republic">Dominican Republic</option>
                                                                    <option value="Ecuador">Ecuador</option>
                                                                    <option value="Egypt">Egypt</option>
                                                                    <option value="El Salvador">El Salvador</option>
                                                                    <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                                    <option value="Eritrea">Eritrea</option>
                                                                    <option value="Estonia">Estonia</option>
                                                                    <option value="Ethiopia">Ethiopia</option>
                                                                    <option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>
                                                                    <option value="Faroe Islands">Faroe Islands</option>
                                                                    <option value="Fiji">Fiji</option>
                                                                    <option value="Finland">Finland</option>
                                                                    <option value="France">France</option>
                                                                    <option value="French Guiana">French Guiana</option>
                                                                    <option value="French Polynesia">French Polynesia</option>
                                                                    <option value="French Southern Territories">French Southern Territories</option>
                                                                    <option value="Gabon">Gabon</option>
                                                                    <option value="Gambia">Gambia</option>
                                                                    <option value="Georgia">Georgia</option>
                                                                    <option value="Germany">Germany</option>
                                                                    <option value="Ghana">Ghana</option>
                                                                    <option value="Gibraltar">Gibraltar</option>
                                                                    <option value="Greece">Greece</option>
                                                                    <option value="Greenland">Greenland</option>
                                                                    <option value="Grenada">Grenada</option>
                                                                    <option value="Guadeloupe">Guadeloupe</option>
                                                                    <option value="Guam">Guam</option>
                                                                    <option value="Guatemala">Guatemala</option>
                                                                    <option value="Guernsey">Guernsey</option>
                                                                    <option value="Guinea">Guinea</option>
                                                                    <option value="Guinea-bissau">Guinea-bissau</option>
                                                                    <option value="Guyana">Guyana</option>
                                                                    <option value="Haiti">Haiti</option>
                                                                    <option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>
                                                                    <option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>
                                                                    <option value="Honduras">Honduras</option>
                                                                    <option value="Hong Kong">Hong Kong</option>
                                                                    <option value="Hungary">Hungary</option>
                                                                    <option value="Iceland">Iceland</option>
                                                                    <option value="India">India</option>
                                                                    <option value="Indonesia">Indonesia</option>
                                                                    <option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option>
                                                                    <option value="Iraq">Iraq</option>
                                                                    <option value="Ireland">Ireland</option>
                                                                    <option value="Isle of Man">Isle of Man</option>
                                                                    <option value="Israel">Israel</option>
                                                                    <option value="Italy">Italy</option>
                                                                    <option value="Jamaica">Jamaica</option>
                                                                    <option value="Japan">Japan</option>
                                                                    <option value="Jersey">Jersey</option>
                                                                    <option value="Jordan">Jordan</option>
                                                                    <option value="Kazakhstan">Kazakhstan</option>
                                                                    <option value="Kenya">Kenya</option>
                                                                    <option value="Kiribati">Kiribati</option>
                                                                    <option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option>
                                                                    <option value="Korea, Republic of">Korea, Republic of</option>
                                                                    <option value="Kuwait">Kuwait</option>
                                                                    <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                                    <option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>
                                                                    <option value="Latvia">Latvia</option>
                                                                    <option value="Lebanon">Lebanon</option>
                                                                    <option value="Lesotho">Lesotho</option>
                                                                    <option value="Liberia">Liberia</option>
                                                                    <option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option>
                                                                    <option value="Liechtenstein">Liechtenstein</option>
                                                                    <option value="Lithuania">Lithuania</option>
                                                                    <option value="Luxembourg">Luxembourg</option>
                                                                    <option value="Macao">Macao</option>
                                                                    <option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option>
                                                                    <option value="Madagascar">Madagascar</option>
                                                                    <option value="Malawi">Malawi</option>
                                                                    <option value="Malaysia">Malaysia</option>
                                                                    <option value="Maldives">Maldives</option>
                                                                    <option value="Mali">Mali</option>
                                                                    <option value="Malta">Malta</option>
                                                                    <option value="Marshall Islands">Marshall Islands</option>
                                                                    <option value="Martinique">Martinique</option>
                                                                    <option value="Mauritania">Mauritania</option>
                                                                    <option value="Mauritius">Mauritius</option>
                                                                    <option value="Mayotte">Mayotte</option>
                                                                    <option value="Mexico">Mexico</option>
                                                                    <option value="Micronesia, Federated States of">Micronesia, Federated States of</option>
                                                                    <option value="Moldova, Republic of">Moldova, Republic of</option>
                                                                    <option value="Monaco">Monaco</option>
                                                                    <option value="Mongolia">Mongolia</option>
                                                                    <option value="Montenegro">Montenegro</option>
                                                                    <option value="Montserrat">Montserrat</option>
                                                                    <option value="Morocco">Morocco</option>
                                                                    <option value="Mozambique">Mozambique</option>
                                                                    <option value="Myanmar">Myanmar</option>
                                                                    <option value="Namibia">Namibia</option>
                                                                    <option value="Nauru">Nauru</option>
                                                                    <option value="Nepal">Nepal</option>
                                                                    <option value="Netherlands">Netherlands</option>
                                                                    <option value="Netherlands Antilles">Netherlands Antilles</option>
                                                                    <option value="New Caledonia">New Caledonia</option>
                                                                    <option value="New Zealand">New Zealand</option>
                                                                    <option value="Nicaragua">Nicaragua</option>
                                                                    <option value="Niger">Niger</option>
                                                                    <option value="Nigeria">Nigeria</option>
                                                                    <option value="Niue">Niue</option>
                                                                    <option value="Norfolk Island">Norfolk Island</option>
                                                                    <option value="Northern Mariana Islands">Northern Mariana Islands</option>
                                                                    <option value="Norway">Norway</option>
                                                                    <option value="Oman">Oman</option>
                                                                    <option value="Pakistan">Pakistan</option>
                                                                    <option value="Palau">Palau</option>
                                                                    <option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>
                                                                    <option value="Panama">Panama</option>
                                                                    <option value="Papua New Guinea">Papua New Guinea</option>
                                                                    <option value="Paraguay">Paraguay</option>
                                                                    <option value="Peru">Peru</option>
                                                                    <option value="Philippines">Philippines</option>
                                                                    <option value="Pitcairn">Pitcairn</option>
                                                                    <option value="Poland">Poland</option>
                                                                    <option value="Portugal">Portugal</option>
                                                                    <option value="Puerto Rico">Puerto Rico</option>
                                                                    <option value="Qatar">Qatar</option>
                                                                    <option value="Reunion">Reunion</option>
                                                                    <option value="Romania">Romania</option>
                                                                    <option value="Russian Federation">Russian Federation</option>
                                                                    <option value="Rwanda">Rwanda</option>
                                                                    <option value="Saint Helena">Saint Helena</option>
                                                                    <option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>
                                                                    <option value="Saint Lucia">Saint Lucia</option>
                                                                    <option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>
                                                                    <option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>
                                                                    <option value="Samoa">Samoa</option>
                                                                    <option value="San Marino">San Marino</option>
                                                                    <option value="Sao Tome and Principe">Sao Tome and Principe</option>
                                                                    <option value="Saudi Arabia">Saudi Arabia</option>
                                                                    <option value="Senegal">Senegal</option>
                                                                    <option value="Serbia">Serbia</option>
                                                                    <option value="Seychelles">Seychelles</option>
                                                                    <option value="Sierra Leone">Sierra Leone</option>
                                                                    <option value="Singapore">Singapore</option>
                                                                    <option value="Slovakia">Slovakia</option>
                                                                    <option value="Slovenia">Slovenia</option>
                                                                    <option value="Solomon Islands">Solomon Islands</option>
                                                                    <option value="Somalia">Somalia</option>
                                                                    <option value="South Africa">South Africa</option>
                                                                    <option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>
                                                                    <option value="Spain">Spain</option>
                                                                    <option value="Sri Lanka">Sri Lanka</option>
                                                                    <option value="Sudan">Sudan</option>
                                                                    <option value="Suriname">Suriname</option>
                                                                    <option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>
                                                                    <option value="Swaziland">Swaziland</option>
                                                                    <option value="Sweden">Sweden</option>
                                                                    <option value="Switzerland">Switzerland</option>
                                                                    <option value="Syrian Arab Republic">Syrian Arab Republic</option>
                                                                    <option value="Taiwan, Province of China">Taiwan, Province of China</option>
                                                                    <option value="Tajikistan">Tajikistan</option>
                                                                    <option value="Tanzania, United Republic of">Tanzania, United Republic of</option>
                                                                    <option value="Thailand">Thailand</option>
                                                                    <option value="Timor-leste">Timor-leste</option>
                                                                    <option value="Togo">Togo</option>
                                                                    <option value="Tokelau">Tokelau</option>
                                                                    <option value="Tonga">Tonga</option>
                                                                    <option value="Trinidad and Tobago">Trinidad and Tobago</option>
                                                                    <option value="Tunisia">Tunisia</option>
                                                                    <option value="Turkey">Turkey</option>
                                                                    <option value="Turkmenistan">Turkmenistan</option>
                                                                    <option value="Turks and Caicos Islands">Turks and Caicos Islands</option>
                                                                    <option value="Tuvalu">Tuvalu</option>
                                                                    <option value="Uganda">Uganda</option>
                                                                    <option value="Ukraine">Ukraine</option>
                                                                    <option value="United Arab Emirates">United Arab Emirates</option>
                                                                    <option value="United Kingdom">United Kingdom</option>
                                                                    <option value="United States">United States</option>
                                                                    <option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>
                                                                    <option value="Uruguay">Uruguay</option>
                                                                    <option value="Uzbekistan">Uzbekistan</option>
                                                                    <option value="Vanuatu">Vanuatu</option>
                                                                    <option value="Venezuela">Venezuela</option>
                                                                    <option value="Viet Nam">Viet Nam</option>
                                                                    <option value="Virgin Islands, British">Virgin Islands, British</option>
                                                                    <option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>
                                                                    <option value="Wallis and Futuna">Wallis and Futuna</option>
                                                                    <option value="Western Sahara">Western Sahara</option>
                                                                    <option value="Yemen">Yemen</option>
                                                                    <option value="Zambia">Zambia</option>
                                                                    <option value="Zimbabwe">Zimbabwe</option>
                                                                    </select>
                                                              </div>
                                                         </div>
                                                       
                                            		</div> <!-- col-md-6  -->
                                                    
                                           </div> <!-- row  -->
                                           
                                           <div class="row">
                                           		 <h4 style="margin-left:40px;">Contact Details</h4> 
                                               	<div class="col-md-12">  
                                                
                                                 	<div class="col-md-6">  <!-- col-md-6  -->
                                                       
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Contact person:</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  >
                                                              </div>
                                                        </div>
                                                       
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Office telephone:</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  >
                                                              </div>
                                                        </div>
                                                       
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Fax:</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  >
                                                              </div>
                                                         </div>
                                                         
                                                         <div class="form-group">
                                                              <label  class="col-md-5 control-label">Website:</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  >
                                                              </div>
                                                         </div>
                                                        
                                                       
                                                        
                                                        
                                            		</div> <!-- col-md-6  -->
                                                    
                                                    
                                                    <div class="col-md-6"> <!-- col-md-6  -->
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Position title:</label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  >
                                                              </div>
                                                         </div>
                                                       
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Mobile: </label>
                                                              <div class="col-md-7">
                                                                 <input type="text" class="form-control"  >
                                                              </div>
                                                         </div>
                                                        
                                                        
                                                        <div class="form-group">
                                                              <label  class="col-md-5 control-label">Email:</label>
                                                              <div class="col-md-7">
                                                                 <input type="email" class="form-control"  >
                                                              </div>
                                                         </div>
                                                        
                                            		</div> <!-- col-md-6  -->
                                                 </div>   
                                                    
                                           </div> <!-- row  -->
                                           <div class="clearfix"></div>
                                           
                                           <div class="row">
                                           		<div class="container"> 
                                               	<div class="col-md-12" style="padding:20px;">  
                                                	<h4 class="well" style="width:95%; margin-left:20px;">BUSINESS RELATED INFORMATION</h4> 
                                                 	
                                                    <div class="col-md-6">  <!-- col-md-6  -->
                                                       <h5>Type of business (check one or more)</h5>
                                                      <div class="form-group">
                                                         <label  class="control-label">&nbsp;</label>
                                                          <div class="checkbox-list">
                                                             <label>
                                                             	<input type="checkbox"> Service
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox"> Manufacturing
                                                             </label>
                                                              <label>
                                                             	<input type="checkbox"> Trading 
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox"> Distribution 
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox"> Engineering and construction
                                                             </label>
                                                             <div class="col-md-8">
                                                             	Other, Please specify: <input type="text" name="other" class="form-control" >
                                                             </div>   
                                                            
                                                          </div>
                                                       </div>
                                            		</div> <!-- col-md-6  -->
                                                    
                                                    
                                                    <div class="col-md-6"> <!-- col-md-6  -->
                                                        <h5>Industry where company operates (check one or more)</h5>
                                                        
                                                        <div class="row">
                                                        	<div class="col-md-12">
                                                                <div class="col-md-6">
                                                            
                                                                   <div class="form-group">
                                                                     <label  class="control-label">&nbsp;</label>
                                                                      <div class="checkbox-list">
                                                                         <label>
                                                                            <input type="checkbox"> Oil &amp; Gas
                                                                         </label>
                                                                         <label>
                                                                            <input type="checkbox"> Basic Material
                                                                         </label>
                                                                          <label>
                                                                            <input type="checkbox"> Industrials 
                                                                         </label>
                                                                         <label>
                                                                            <input type="checkbox"> Consumer Goods 
                                                                         </label>
                                                                         <label>
                                                                            <input type="checkbox"> Health Care
                                                                         </label>
                                                                         <label>
                                                                            <input type="checkbox"> Consumer Services
                                                                         </label>
                                                                      </div>
                                                                   </div>
                                                                 
                                                                 </div> <!-- col-md-6  -->
                                                                 
                                                                 <div class="col-md-6">
                                                            
                                                                    <div class="form-group">
                                                                     <label  class="control-label">&nbsp;</label>
                                                                      <div class="checkbox-list">
                                                                         <label>
                                                                            <input type="checkbox"> Telecommunications
                                                                         </label>
                                                                         <label>
                                                                            <input type="checkbox"> Utilities
                                                                         </label>
                                                                          <label>
                                                                            <input type="checkbox"> Financials 
                                                                         </label>
                                                                         <label>
                                                                            <input type="checkbox"> Technology 
                                                                         </label>
                                                                         <label>
                                                                            <input type="checkbox"> Hotel and tourism 
                                                                         </label>
                                                                         <label>
                                                                            <input type="checkbox"> Business and professional services
                                                                         </label>
                                                                      </div>
                                                                   </div>
                                                                 
                                                                 </div> <!-- col-md-6  -->
                                                                 
                                                             </div>  <!-- col-md-12  -->
                                                       
                                                        </div><!-- row  -->
                                            		</div> <!-- col-md-6  -->
                                                    
                                            	</div> <!-- col-md-12  -->
                                                    
                                                </div>   <!-- container  --> 
                                           </div> <!-- row  -->         
                                                    
                                           <div class="row">     
                                              <div class="container">
                                                 <div class="col-md-12">    
                                                    
                                                    <div class="col-md-6">  <!-- col-md-6  -->
                                                       <h5>Annual turnover or revenue (USD): (Check one)</h5>
                                                      <div class="form-group">
                                                         <label  class="control-label">&nbsp;</label>
                                                          <div class="checkbox-list">
                                                             <label>
                                                             	<input type="checkbox"> Under 500,000
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox"> 500,001 – 1,000,000
                                                             </label>
                                                              <label>
                                                             	<input type="checkbox"> 1,000,001 – 2,000,000 
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox"> Over 2,000,000
                                                             </label>
                                                            
                                                           
                                                            
                                                          </div>
                                                       </div>
                                            		</div> <!-- col-md-6  -->
                                                    
                                                    <div class="col-md-6">  <!-- col-md-6  -->
                                                       <h5>Number of employees: (Check one)</h5>
                                                      <div class="form-group">
                                                         <label  class="control-label">&nbsp;</label>
                                                          <div class="checkbox-list">
                                                             <label>
                                                             	<input type="checkbox"> Less than 50
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox"> 51-100
                                                             </label>
                                                              <label>
                                                             	<input type="checkbox"> 101-200
                                                             </label>
                                                             <label>
                                                             	<input type="checkbox"> Over 200 
                                                             </label>
                                                          </div>
                                                       </div>
                                            		</div> <!-- col-md-6  -->
                                                   </div> <!-- col-md-12  -->
                                                </div>   <!-- container  --> 
                                           </div> <!-- row  -->
                                           
                                           <div class="row">
                                           		<div class="container">
                                                	<div class="col-md-12">
                                                    	<h5>Summary of company’s background and business activities (maximum 350 words)</h5>
                                                    	 <div class="form-group">
                                                              <div class="col-md-11" style="margin-left:15px;">
                                                                <textarea class="form-control" rows="3"></textarea>
                                                              </div>
                                                         </div>
                                                    </div>	<!-- col-md-12  -->
                                                </div> <!-- container  --> 
                                           </div> <!-- row  -->
                                           
                                           
                                           <div class="row">
                                           		<div class="container">
                                                	<div class="col-md-12">
                                                    	<h4 class="well" style="width:95%; margin-left:20px;">BUSINESS NEEDS</h4> 
                                                    	 
                                                         <div class="col-md-12 margin-bottom-20">
                                                         	<h4>We are looking for (Check all that apply)</h4>
                                                         </div>
                                                         
                                                         
                                                         <div class="col-md-4" >
                                                         	<div class="form-body" style="border-right:#ccc 1px solid">
                                                         			<div class="form-group">
                                                                    	<div class="col-md-12">
                                                                            <label>
                                                                                <input type="checkbox"> <strong>Partner in</strong>
                                                                             </label>
                                                                         </div>
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-6 control-label" style="margin-right:20px; text-align:left">a. Services </label>
                                                                              <div class="col-md-4">
                                                                                 <div class="radio-list">
                                                                                    <label class="radio-inline">
                                                                                    <input type="radio" name="services_bneed"  value="1" > Yes
                                                                                    </label>
                                                                                    <label class="radio-inline">
                                                                                    <input type="radio" name="services_bneed"  value="0" > No
                                                                                    </label>
                                                                                  
                                                                                 </div>
                                                                              </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                      <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-6 control-label" style="margin-right:20px; text-align:left">b. Manufacturing </label>
                                                                              <div class="col-md-4">
                                                                                 <div class="radio-list">
                                                                                    <label class="radio-inline">
                                                                                    <input type="radio" name="manufacture_bneed"  value="1" > Yes
                                                                                    </label>
                                                                                    <label class="radio-inline">
                                                                                    <input type="radio" name="manufacture_bneed"  value="0" > No
                                                                                    </label>
                                                                                  
                                                                                 </div>
                                                                              </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                      <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-6 control-label" style="margin-right:20px; text-align:left">c. Trading </label>
                                                                              <div class="col-md-4">
                                                                                 <div class="radio-list">
                                                                                    <label class="radio-inline">
                                                                                    <input type="radio" name="trade_bneed"  value="1" > Yes
                                                                                    </label>
                                                                                    <label class="radio-inline">
                                                                                    <input type="radio" name="trade_bneed"  value="0" > No
                                                                                    </label>
                                                                                  
                                                                                 </div>
                                                                              </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                      <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-6 control-label" style="margin-right:20px; text-align:left">d. Distribution </label>
                                                                              <div class="col-md-4">
                                                                                 <div class="radio-list">
                                                                                    <label class="radio-inline">
                                                                                    <input type="radio" name="distribute_bneed"  value="1" > Yes
                                                                                    </label>
                                                                                    <label class="radio-inline">
                                                                                    <input type="radio" name="distribute_bneed"  value="0" > No
                                                                                    </label>
                                                                                  
                                                                                 </div>
                                                                              </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                      <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-6 control-label" style="margin-right:20px; text-align:left">e. Engineering and Construction </label>
                                                                              <div class="col-md-4">
                                                                                 <div class="radio-list">
                                                                                    <label class="radio-inline">
                                                                                    <input type="radio" name="engineer_bneed"  value="1" > Yes
                                                                                    </label>
                                                                                    <label class="radio-inline">
                                                                                    <input type="radio" name="engineer_bneed"  value="0" > No
                                                                                    </label>
                                                                                  
                                                                                 </div>
                                                                              </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-11">
                                                                              <label  class=" control-label" style="text-align:left">f. Other, Please Specify </label><br>
                                                                               <input type="text" name="other_bneed" class="form-control">
                                                                              
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     
                                                                 </div>    
                                                                     
                                                                     
                                                         </div> <!-- col-md-4   -->
                                                         
                                                         <div class="col-md-4">
                                                         		<div class="form-body" style="border-right:#ccc 1px solid">
                                                             		<div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-7 control-label" style="margin-right:20px; text-align:left">We need investment</label>
                                                                              <div class="col-md-4">
                                                                                 <div class="radio-list">
                                                                                    <label class="radio-inline">
                                                                                    <input type="radio" name="services_bneed"  value="1" > Yes
                                                                                    </label>
                                                                                    <label class="radio-inline">
                                                                                    <input type="radio" name="services_bneed"  value="0" > No
                                                                                    </label>
                                                                                  
                                                                                 </div>
                                                                              </div>
                                                                              <small>If Yes, please go to Investor section</small>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                             <label>
                                                                                <input type="checkbox"> <strong>Investor </strong>
                                                                             </label>
                                                                     	</div>
                                                                     </div>
                                                                     
                                                                                                                                         
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">a.	Up to 1,000,000 USD</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="investor_1m"  value="option1">
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div> 
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">b.	1,000,001 – 2,000,000 USD</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="investor_2m"  value="option1">
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">c.	2,000,001 – 5,000,000 USD</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="investor_5m"  value="option1">
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">d.	Over 5,000,000 USD</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="investor_5more"  value="option1">
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     
                                                            	</div> <!-- form-body  -->
                                                         </div>
                                                         
                                                         <div class="col-md-4">
                                                         	
                                                            	<div class="form-body">
                                                             		
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                             <label>
                                                                                <input type="checkbox"> <strong>Service Provider </strong>
                                                                             </label>
                                                                     	</div>
                                                                     </div>
                                                                     
                                                                                                                                         
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">a.	Accounting </label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="service_accounting"  value="option1">
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div> 
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">b.	Legal</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="service_legal"  value="option1">
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">c.	Logistics</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="service_logistics"  value="option1">
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">d.	ICT</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="service_ict"  value="option1">
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">e.	Training</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="service_training"  value="option1">
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-12">
                                                                              <label  class="col-md-9 control-label" style="margin-right:20px; text-align:left">f.	Consultancy</label>
                                                                              <div class="col-md-2">
                                                                                 	<label class="checkbox-inline">
                                                                                     <input type="checkbox" name="service_consultancy"  value="option1">
                                                                                     </label>
                                                                             </div>
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     <div class="form-group">
                                                                     	<div class="col-md-11">
                                                                              <label  class=" control-label" style="text-align:left">g. Other, Please Specify </label><br>
                                                                               <input type="text" name="service_other" class="form-control">
                                                                              
                                                                         </div> 
                                                                     </div>
                                                                     
                                                                     
                                                            	</div> <!-- form-body  -->
                                                            
                                                         </div>
                                                         
                                                         
                                                         
                                                         
                                                        
                                                         
                                                    </div>	<!-- col-md-12  -->
                                                </div> <!-- container  --> 
                                           </div> <!-- row  -->
                                           
                                           <div class="row">
                                           		<div class="container">
                                                	<div class="col-md-12">
                                                    		<p>If you are looking for business partners, please describe what type of partners you are looking for. (maximum 350 words)</p>
                                                             <div class="form-group">
                                                                  <div class="col-md-11" style="margin-left:15px;">
                                                                    <textarea class="form-control" rows="3"></textarea>
                                                                  </div>
                                                             </div>
                                                    </div>	<!-- col-md-12  -->
                                                </div> <!-- container  --> 
                                           </div><!-- row  -->
                                           
                                           <div class="row">
                                           		<div class="container">
                                                	<div class="col-md-12">
                                                    		<p>If you are looking for foreign investors, please describe more details. (maximum 350 words)</p>
                                                             <div class="form-group">
                                                                  <div class="col-md-11" style="margin-left:15px;">
                                                                    <textarea class="form-control" rows="3"></textarea>
                                                                  </div>
                                                             </div>
                                                    </div>	<!-- col-md-12  -->
                                                </div> <!-- container  --> 
                                           </div><!-- row  -->
                                           
                                           <div class="row">
                                           		<div class="container">
                                                	<div class="col-md-12">
                                                    		<p>If you are looking for service providers or to provide services, please describe more details. (maximum 350 words)</p>
                                                             <div class="form-group">
                                                                  <div class="col-md-11" style="margin-left:15px;">
                                                                    <textarea class="form-control" rows="3"></textarea>
                                                                  </div>
                                                             </div>
                                                    </div>	<!-- col-md-12  -->
                                                </div> <!-- container  --> 
                                           </div><!-- row  -->
                                           
                                           
                                           
                                           
                                           <div class="space20"></div>
                                           <div class="row">
                                            	<div class="col-md-12">   
                                                    <div class="form-actions fluid">
                                                       <div class="col-md-offset-5 col-md-7">
                                                          <button type="submit" class="btn yellow">Submit Application</button>
                                                       </div>
                                                    </div>
                                           		</div> 
                                           </div>
                                         </form>
                                         
                                         
                                </div>
                            </div>
                           <!-- BLOCK END -->
                       </div>    
               
               
                    
                    </div>
					
					               
				</div>
                
                </div>

				        
			</div>
		</div>
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