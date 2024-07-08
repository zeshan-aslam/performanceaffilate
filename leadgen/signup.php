<?php include('includes/header.php'); 

$filename                = "includes/mer_terms.htm";
$fp                      = fopen($filename,'r');
$contents                = fread ($fp, filesize ($filename));
fclose($fp);

?> 
<div class="container"> 
<div class=" custom_regiser inner_content cus_zindex">
	<div class="col-md-8 col-sm-8 col-xs-12">
		<h2>Leadgen Registration</h2>
		<p>Sign up for free. Then place our offers on your website, email list or any other traffic source and start earning!</p>
		<form action="controller/signup.php" class="" method="post">
		<?php
			if(isset($_SESSION['successr'])){
				echo '<p class="alert alert-success">'.$_SESSION['successr'].'</p>';
				unset($_SESSION['successr']);
			}else if(isset($_SESSION['failurer'])){
				echo '<p class="alert alert-danger">'.$_SESSION['failurer'].'</p>';
				unset($_SESSION['failurer']);
			}
			?>
			<div class="form-group">
				<label class="col-md-4">First Name</label>
				<div class="col-md-8">
					<input type="text" name="first_name" required placeholder="First Name" class="form-control" />
				</div>				
			</div>
			<div class="form-group">
				<label class="col-md-4">Last Name</label>
				<div class="col-md-8">
					<input type="text" name="last_name" required placeholder="Last Name" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">Category</label>
				<div class="col-md-8">
					<select name="av_category" required class="form-control">
						<option value="">----select acategory----</option>
						<option value="B2B Services / Retail">B2B Services / Retail</option>
						<option value="Charities">Charities</option>
						<option value="Education">Education</option>
						<option value="Entertainment">Entertainment</option>
						<option value="Finance &amp; Legal">Finance &amp; Legal</option>
						<option value="Freebies / Comps / Surveys">Freebies / Comps / Surveys</option>
						<option value="Gambling">Gambling</option>
						<option value="Motoring">Motoring</option>
						<option value="Online Dating">Online Dating</option>
						<option value="Other">Other</option>
						<option value="Retail">Retail</option>
						<option value="Shopping">Shopping</option>
						<option value="Travel">Travel</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">Company</label>
				<div class="col-md-8">
					<input type="text" name="av_company" required placeholder="Company" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">URL</label>
				<div class="col-md-8">
					<input type="text" name="av_url" required placeholder="URL" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">Skype</label>
				<div class="col-md-8">
					<input type="text" name="av_fax" required placeholder="Skype" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">Phone</label>
				<div class="col-md-8">
					<input type="text" name="av_phone" required placeholder="Phone" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">Email Address</label>
				<div class="col-md-8">
					<input type="email" name="av_email" required placeholder="Email Address" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">Address</label>
				<div class="col-md-8">
					<textarea type="text" name="av_address" required placeholder="" class="form-control"></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">Zip/Post Code</label>
				<div class="col-md-8">
					<input type="text" name="av_post_code" required placeholder="Zip/Post Code" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">City/Town</label>
				<div class="col-md-8">
					<input type="text" name="av_city" required placeholder="City/Town" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">State/County</label>
				<div class="col-md-8">
					<input type="text" name="av_state" required placeholder="State/County" class="form-control" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-4">Country</label>
				<div class="col-md-8">
					<select id="country" required name="av_country" class="form-control">
						<option value="">-----Select a Country-----</option>
						<option value="United States of America">United States of America</option>
						<option value="Canada">Canada</option>
						<option value="United Kingdom">United Kingdom</option>
						<option value="Afghanistan">Afghanistan</option>
						<option value="Albania">Albania</option>
						<option value="Algeria">Algeria</option>
						<option value="Amer.Virgin Is.">Amer.Virgin Is.</option>
						<option value="Andorra">Andorra</option>
						<option value="Angola">Angola</option>
						<option value="Anguilla">Anguilla</option>
						<option value="Antarctica">Antarctica</option>
						<option value="Antigua/Barbads">Antigua/Barbads</option>
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
						<option value="Bosnia-Herz.">Bosnia-Herz.</option>
						<option value="Botswana">Botswana</option>
						<option value="Bouvet Island">Bouvet Island</option>
						<option value="Brazil">Brazil</option>
						<option value="Brit.Ind.Oc.Ter">Brit.Ind.Oc.Ter</option>
						<option value="Brit.Virgin Is.">Brit.Virgin Is.</option>
						<option value="Brunei">Brunei</option>
						<option value="Bulgaria">Bulgaria</option>
						<option value="Burkina-Faso">Burkina-Faso</option>
						<option value="Burundi">Burundi</option>
						<option value="Cambodia">Cambodia</option>
						<option value="Cameroon">Cameroon</option>
						<option value="Cape Verde">Cape Verde</option>
						<option value="Cayman Islands">Cayman Islands</option>
						<option value="Central Afr.Rep">Central Afr.Rep</option>
						<option value="Chad">Chad</option>
						<option value="Channel Islands">Channel Islands</option>
						<option value="Chile">Chile</option>
						<option value="China">China</option>
						<option value="Christmas Islnd">Christmas Islnd</option>
						<option value="Coconut Islands">Coconut Islands</option>
						<option value="Colombia">Colombia</option>
						<option value="Comoro">Comoro</option>
						<option value="Congo">Congo</option>
						<option value="Cook Islands">Cook Islands</option>
						<option value="Costa Rica">Costa Rica</option>
						<option value="Croatia">Croatia</option>
						<option value="Cuba">Cuba</option>
						<option value="Cyprus">Cyprus</option>
						<option value="Czech Republic">Czech Republic</option>
						<option value="Denmark">Denmark</option>
						<option value="Djibouti">Djibouti</option>
						<option value="Dominica">Dominica</option>
						<option value="Dominican Rep.">Dominican Rep.</option>
						<option value="Ecuador">Ecuador</option>
						<option value="Egypt">Egypt</option>
						<option value="El Salvador">El Salvador</option>
						<option value="Equatorial Guin">Equatorial Guin</option>
						<option value="Eritrea">Eritrea</option>
						<option value="Estonia">Estonia</option>
						<option value="Ethiopia">Ethiopia</option>
						<option value="Faeroe Islands">Faeroe Islands</option>
						<option value="Falkland Islnds">Falkland Islnds</option>
						<option value="Fiji">Fiji</option>
						<option value="Finland">Finland</option>
						<option value="France">France</option>
						<option value="Frenc.Polynesia">Frenc.Polynesia</option>
						<option value="French Guinea">French Guinea</option>
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
						<option value="Guinea">Guinea</option>
						<option value="Guinea-Bissau">Guinea-Bissau</option>
						<option value="Guyana">Guyana</option>
						<option value="Haiti">Haiti</option>
						<option value="Heard/McDon.Isl">Heard/McDon.Isl</option>
						<option value="Honduras">Honduras</option>
						<option value="Hong Kong">Hong Kong</option>
						<option value="Hungary">Hungary</option>
						<option value="Iceland">Iceland</option>
						<option value="India">India</option>
						<option value="Indonesia">Indonesia</option>
						<option value="Iran">Iran</option>
						<option value="Iraq">Iraq</option>
						<option value="Ireland">Ireland</option>
						<option value="Israel">Israel</option>
						<option value="Italy">Italy</option>
						<option value="Ivory Coast">Ivory Coast</option>
						<option value="Jamaica">Jamaica</option>
						<option value="Japan">Japan</option>
						<option value="Jordan">Jordan</option>
						<option value="Kazakhstan">Kazakhstan</option>
						<option value="Kenya">Kenya</option>
						<option value="Kirghistan">Kirghistan</option>
						<option value="Kiribati">Kiribati</option>
						<option value="Kuwait">Kuwait</option>
						<option value="Laos">Laos</option>
						<option value="Latvia">Latvia</option>
						<option value="Lebanon">Lebanon</option>
						<option value="Lesotho">Lesotho</option>
						<option value="Liberia">Liberia</option>
						<option value="Libya">Libya</option>
						<option value="Liechtenstein">Liechtenstein</option>
						<option value="Lithuania">Lithuania</option>
						<option value="Luxembourg">Luxembourg</option>
						<option value="Macau">Macau</option>
						<option value="Macedonia">Macedonia</option>
						<option value="Madagascar">Madagascar</option>
						<option value="Malawi">Malawi</option>
						<option value="Malaysia">Malaysia</option>
						<option value="Maldives">Maldives</option>
						<option value="Mali">Mali</option>
						<option value="Malta">Malta</option>
						<option value="Marshall Islnds">Marshall Islnds</option>
						<option value="Martinique">Martinique</option>
						<option value="Mauritania">Mauritania</option>
						<option value="Mauritius">Mauritius</option>
						<option value="Mayotte">Mayotte</option>
						<option value="Mexico">Mexico</option>
						<option value="Micronesia">Micronesia</option>
						<option value="Minor Outl.Isl.">Minor Outl.Isl.</option>
						<option value="Moldavia">Moldavia</option>
						<option value="Monaco">Monaco</option>
						<option value="Mongolia">Mongolia</option>
						<option value="Montserrat">Montserrat</option>
						<option value="Morocco">Morocco</option>
						<option value="Mozambique">Mozambique</option>
						<option value="Myanmar">Myanmar</option>
						<option value="N.Mariana Islnd">N.Mariana Islnd</option>
						<option value="Namibia">Namibia</option>
						<option value="Nauru">Nauru</option>
						<option value="Nepal">Nepal</option>
						<option value="Netherland Antilles">Netherland Antilles</option>
						<option value="Netherlands">Netherlands</option>
						<option value="New Caledonia">New Caledonia</option>
						<option value="New Zealand">New Zealand</option>
						<option value="Nicaragua">Nicaragua</option>
						<option value="Niger">Niger</option>
						<option value="Nigeria">Nigeria</option>
						<option value="Niue Islands">Niue Islands</option>
						<option value="Norfolk Island">Norfolk Island</option>
						<option value="North Korea">North Korea</option>
						<option value="Norway">Norway</option>
						<option value="Oman">Oman</option>
						<option value="Pakistan">Pakistan</option>
						<option value="Palau">Palau</option>
						<option value="Panama">Panama</option>
						<option value="Papua New Guinea">Papua New Guinea</option>
						<option value="Paraguay">Paraguay</option>
						<option value="Peru">Peru</option>
						<option value="Philippines">Philippines</option>
						<option value="Pitcairn Islnds">Pitcairn Islnds</option>
						<option value="Poland">Poland</option>
						<option value="Portugal">Portugal</option>
						<option value="Puerto Rico">Puerto Rico</option>
						<option value="Qatar">Qatar</option>
						<option value="Reunion">Reunion</option>
						<option value="Romania">Romania</option>
						<option value="Russian Fed.">Russian Fed.</option>
						<option value="Rwanda">Rwanda</option>
						<option value="S.Tome,Principe">S.Tome,Principe</option>
						<option value="Samoa,American">Samoa,American</option>
						<option value="San Marino">San Marino</option>
						<option value="Saudi Arabia">Saudi Arabia</option>
						<option value="Senegal">Senegal</option>
						<option value="Seychelles">Seychelles</option>
						<option value="Sierra Leone">Sierra Leone</option>
						<option value="Singapore">Singapore</option>
						<option value="Slovakia">Slovakia</option>
						<option value="Slovenia">Slovenia</option>
						<option value="Solomon Islands">Solomon Islands</option>
						<option value="Somalia">Somalia</option>
						<option value="South Africa">South Africa</option>
						<option value="South Korea">South Korea</option>
						<option value="Spain">Spain</option>
						<option value="Sri Lanka">Sri Lanka</option>
						<option value="St. Helena">St. Helena</option>
						<option value="St. Lucia">St. Lucia</option>
						<option value="St. Vincent">St. Vincent</option>
						<option value="St.Kitts, Nevis">St.Kitts, Nevis</option>
						<option value="St.Pier,Miquel.">St.Pier,Miquel.</option>
						<option value="Sth Sandwich Is">Sth Sandwich Is</option>
						<option value="Sudan">Sudan</option>
						<option value="Suriname">Suriname</option>
						<option value="Svalbard">Svalbard</option>
						<option value="Swaziland">Swaziland</option>
						<option value="Sweden">Sweden</option>
						<option value="Switzerland">Switzerland</option>
						<option value="Syria">Syria</option>
						<option value="Tadzhikistan">Tadzhikistan</option>
						<option value="Taiwan">Taiwan</option>
						<option value="Tanzania">Tanzania</option>
						<option value="Thailand">Thailand</option>
						<option value="Togo">Togo</option>
						<option value="Tokelau Islands">Tokelau Islands</option>
						<option value="Tonga">Tonga</option>
						<option value="Trinidad,Tobago">Trinidad,Tobago</option>
						<option value="Tunisia">Tunisia</option>
						<option value="Turkey">Turkey</option>
						<option value="Turkmenistan">Turkmenistan</option>
						<option value="Turks &amp;Caicos">Turks &amp;Caicos</option>
						<option value="Tuvalu">Tuvalu</option>
						<option value="Uganda">Uganda</option>
						<option value="Ukraine">Ukraine</option>
						<option value="Uruguay">Uruguay</option>
						<option value="Utd.Arab.Emir.">Utd.Arab.Emir.</option>
						<option value="Uzbekistan">Uzbekistan</option>
						<option value="Vanuatu">Vanuatu</option>
						<option value="Vatican City">Vatican City</option>
						<option value="Venezuela">Venezuela</option>
						<option value="Vietnam">Vietnam</option>
						<option value="Wallis,Futuna">Wallis,Futuna</option>
						<option value="West Sahara">West Sahara</option>
						<option value="Western Samoa">Western Samoa</option>
						<option value="Yemen">Yemen</option>
						<option value="Yugoslavia">Yugoslavia</option>
						<option value="Zaire">Zaire</option>
						<option value="Zambia">Zambia</option>
						<option value="Zimbabwe">Zimbabwe</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-4">Currency</label>
				<div class="col-md-8">
					<select id="Currency" required name="av_Currency" class="form-control">
						<option value="">-----Select a Currency-----</option>
						<option value="GBP">£ GBP</option>
								<option value="USD">$ USD</option>
								<option value="EURO">€ EURO</option>				
					</select>
				</div>
			</div>
				
			<div class="form-group">
				<!--<label class="col-md-4">Tax/VAT Id</label>-->
				<div class="col-md-8">
					<input type="hidden" value='0'  class="form-control" name="av_tax_vat_id">
				</div>
			</div>
			<div class="form-group">
				<!--<label class="col-md-4">Account Type</label>-->
				<!--<div class="col-md-8">
					<select id=""  name="av_account_type" type="hidden" class="form-control" required="required">
						<option value="">-----select Account Type-----</option>
						<option value="normal">Self Managed (£0)</option>
						<option value="advance">Managed (£100p/m)</option>
					</select>
				</div>-->
			</div>
			<div class="form-group">
				<label class="col-md-4"></label>
				<div class="col-md-8">
					<textarea name="termsCondn" class="form-control col-md-8" cols="40" rows="5">
					<?php echo stripslashes($contents); ?>
					</textarea>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="form-group">
				<label class="col-md-8 col-md-offset-4">
				<input type="checkbox" required name="terms" value="1">
					Click here to indicate that you have read and agree to the User Agreement and Privacy Policy.
				</label>
			</div>
			
			<div class="col-md-8 col-md-offset-4">
				<div class="form-group">
					<div class="g-recaptcha" data-sitekey="6LdChJsUAAAAAGhxAxN-HWzbZNBLkq41HQCEb1Tm"></div>
				</div> 
			</div>
			<div class="form-group">
				<button type="submit" name="sign_in" class="register_btn">Register</button>
			</div>
			<div class="clearfix"></div>
		</form> 
	</div>
	<div class="col-md-4 col-sm-4 col-xs-12 signup_sidebar">
		<h2>WHY JOIN?</h2> 
		<ul>		
			<li>Increased traffic and sales</li>
			<li>Access to a pool of quality Members</li>
			<li>Easy Web-based access to the reports and administration</li>
			<li>24 hour turn-around customer service</li>
			<li>Gain internet real estate for your product and services</li>
			<li>Low customer acquisition costs</li>
			<li>An experienced team managing their affiliate program</li>
			<li>Ability to grow your current affiliate base</li>
			<li>Ability to choose the service that best suits your business needs</li>                 
		</ul> 
	</div>
	<div class="clearfix"></div>
</div>	
</div>	
<div class="container">
<?php include('includes/footer.php'); ?>