let counter = 0;
let currentLimit = 30; // Set an initial limit
let loadedItems = 30;
let displayedItems = 30;
let totalLoadedItems = 30;
let loadMoreCalled = false;
let isFetching = false;
let loadcounter = 1;
let currentDate = new Date().toISOString().slice(0, 10);
class mallfront {

  constructor() {
    // this.getData();
  }

  ser_color = "";
  name_color = "";
  btn_color = "";
  id = "";
  
	initialize(){

		


		var defaultCountry = "United States of America";
		var selectedCountryCookie = mf.getSelectedCountryFromCookie();
		if (selectedCountryCookie && selectedCountryCookie !== "") {
		  defaultCountry = selectedCountryCookie;
		}

		console.log("cookie:",selectedCountryCookie);
		const PerAff_mainApiUrl =
		  "https://performanceaffiliate.com/performanceAffiliateClone/refApis/searlcoMallFront.php?MADKAI=" +
		  PerAffconToken +
		  "&selectedCountry=" +
		  selectedCountryCookie +
		  "&defaultCountry=" +
		  defaultCountry +
		  "&initialize=true";

		//========================== Fetch Advert Records ========================//
		fetch(PerAff_mainApiUrl)
		  .then((response) => response.json())
		  .then((PerAff_data) => {

		  mf.ser_color = PerAff_data.ser_color;
		  mf.name_color = PerAff_data.name_color;
		  mf.btn_color = PerAff_data.btn_color;
		  mf.id = PerAff_data.id;

		  console.log("id is:", mf.id);
			
		  	var consDiv = document.getElementById("sfPerAff");

			var htmlContent = `<div id="PerAff_histoFrec"></div>
	        <section class="PerAff_partner_info" id="PerAff_eskd_srch"><br><br>
	            <div class="container">
	                <div class="row">
	                    <div class="row d-flex justify-content-center">
	                        <div class="col-md-8">
	                        <div class="search">
	                        <div class="search-container frmSearch">
	                            <input type="text" id="search-bar"  name="Keyword" class="search-input" placeholder="Search A Retailer">
	                            <a href="#">
	                                <div class="search-icon" onclick="mf.searchResult(event)" style="background-color:${mf.ser_color}" ><i class="fas fa-search"></i></div>
	                            </a>
	                        </div>
	                    </div>
	                    
	                        </div>
	                    </div>
	                    <div class="col-md-8">
	                        <div class="view-text text-start" id="livesearch">
	                            <h4>Our Partnered Retailers</h4>
	                        </div>
	                    </div>
	                    <div class="col-md-4">
	                    <label>Please Select a Country</label>
	                    <select class="form-select form-select-sm" id="countrySelect" onchange="mf.handleCountryChange()" title="select a country">`;
	        			htmlContent+= `<option value="Select a Country" selected>Select a Country</option>`;
						if(PerAff_data.partnercountries != null && PerAff_data.partnercountries.length > 0)
	        			{	
	        				for(var x in PerAff_data.partnercountries)
	        				{
	        				var countryName = PerAff_data.partnercountries[x].country_name;
	        				htmlContent+= `<option value="${countryName}" >${countryName}</option>`;
	        				}
	        			}
	                   
	        htmlContent+= `</select>
	                 

	                </div>
	                </div>
	            </div>
	            
	        </section>
	        <div class="partner-name pt-35" id="PerAff_elefRec">
			    <div class="main">
			        <div class="container bg-gry">
			            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 d-flex record" id="PerAff_suggesstion-box">
			            	<br style="display: contents;">
			            </div>
						<span id="consLimit" style="display:none;">PerAff_data.consLimit</span><center><button id="btn_showmore" class="btn PerAff-btn-view" style="background:${mf.btn_color};" onclick="mf.loadMore()">Show More</button></center>
			        </div>
			     </div>
			</div>
	        `;

	        consDiv.innerHTML = htmlContent;

		    //consDiv.innerHTML = PerAff_data.resData;
		    // Links1
		    const PerAff_link = document.createElement("link");
		    PerAff_link.rel = "stylesheet";
		    PerAff_link.href =
		      "https://performanceaffiliate.com/performanceAffiliateClone/affiliates/shop_Front_Apis/css/etfSupportPerAff.css";
		    document.head.appendChild(PerAff_link);
		    // Links2
		    const PerAff_link2 = document.createElement("link");
		    PerAff_link2.rel = "stylesheet";
		    PerAff_link2.href =
		      "https://performanceaffiliate.com/performanceAffiliateClone/affiliates/shop_Front_Apis/css/etfPerAff.css";
		    document.head.appendChild(PerAff_link2);
		    // Links3
		    const PerAff_link3 = document.createElement("link");
		    PerAff_link3.rel = "stylesheet";
		    PerAff_link3.href =
		      "https://use.fontawesome.com/releases/v5.15.4/css/all.css";
		    document.head.appendChild(PerAff_link3);
		    // Add Script
		    const PerAff_script = document.createElement("script");
		    PerAff_script.src = "https://code.jquery.com/jquery-3.6.0.min.js";
		    document.body.appendChild(PerAff_script);

		    var selectElement = document.getElementById("countrySelect");
	  	    selectElement.value = mf.getSelectedCountryFromCookie();
	  	    mf.handleCountryChange();

		  })
		  .catch((error) => console.error(error));

		  
	}
	handleCountryChange() {
		$("#btn_showmore").show();
		var consDiv = document.getElementById("PerAff_suggesstion-box");
		consDiv.innerHTML = "";
		$("#btn_showmore").html('<i class="fas fa-spinner fa-spin"></i> Loading...');
		
		var defaultCountry = "United States of America";
		var selectedCountryCookie = mf.getSelectedCountryFromCookie();
		
		if (selectedCountryCookie && selectedCountryCookie !== "") {
			defaultCountry = selectedCountryCookie;
		}
		
		var selectElement = document.getElementById("countrySelect");
		var selectedValue = selectElement.value;
		console.log("Selected value: " + selectedValue);
		document.cookie = "selectedCountry=" + selectedValue + "; path=/";
		currentLimit = 30;
		totalLoadedItems = 30;
		loadcounter = 1;
		var jsonFileUrl = `https://performanceaffiliate.com/performanceAffiliateClone/refApis/jsonFiles/dateFile-${mf.id}-${currentDate}.json`;
		
		$.ajax({
			type: "GET",
			url: jsonFileUrl,
			dataType: "json",
			success: function(PerAff_data) {
				// if(loadMoreCalled === true) {
				if (PerAff_data != null && PerAff_data.length > 0) {
					console.log("json file found");
					// Process data from JSON file
					loadedItems += currentLimit;
					mf.processData(PerAff_data, loadedItems, loadedItems + currentLimit);
				} else {
					console.log("json file not found");
					mf.fetchFromApi();	
				}
			},
			error: function(error) {
				console.error(error);
				// If there's an error fetching JSON, fallback to API call
				mf.fetchFromApi();
			}
		});
		loadedItems = 0;
	}
	processData(PerAff_data, startIndex, endIndex) {
		if(loadMoreCalled === true){
			totalLoadedItems= currentLimit*loadcounter + 30;
			loadcounter++;
			console.log("loadcounter:", loadcounter);
			console.log("limit:", totalLoadedItems);
			loadMoreCalled = false;}
			var selectElement = document.getElementById("countrySelect");
			var selectedValue = selectElement.value;
			if(selectedValue == ""){selectedValue = "United States of America";}
			console.log("Selected value: " + selectedValue);
			document.cookie = "selectedCountry=" + selectedValue + "; path=/";
			//  endIndex = loadedItems + currentLimit;
			// let counter = 0;
			var consDiv = document.getElementById("PerAff_suggesstion-box");
			consDiv.innerHTML = "";
			var dataHtml = "";
			for (let x = 0; x < PerAff_data.length; x++) {
				
				var dataitem = PerAff_data[x];
				let discountTags = "";
				let percentageType = "";
				let onclickFunction = "";
				if (dataitem.discount_mer_cop_string == selectedValue) {
				  if(dataitem.without_disc == "without_disc"){
					onclickFunction = `mf.PerAff_s_Brand('${dataitem.merchant_profileimage}', '${dataitem.companyname}', '${dataitem.program_description}', '${dataitem.url_link}', '${mf.btn_color}', '${mf.name_color}')`;
				  }
				else{
					if (dataitem.discType == null) {
						percentageType = "%";
						dataitem.discType = "";
					  }
					discountTags = `
					  <div class="flat-code" style="margin-bottom:-23px;">
						<span class="off" style="background-color: ${mf.name_color}; color:#fff;">
						  Discount ${dataitem.discType} ${dataitem.discount_amount} ${percentageType}
						</span>
						<span></span>
					  </div>
					  <br>`;
					onclickFunction = `mf.PerAff_s_Brand_Disc('${dataitem.merchant_profileimage}','${dataitem.coupon_details}','${dataitem.valid_to}','${dataitem.valid_from}','${dataitem.program_description}','${dataitem.url_link}','${mf.btn_color}','${mf.name_color}')`;
				  }
			
				dataHtml +=`<div class="col">
				<div class="partner-card">
					${discountTags}
					<div class="flat-code" style="margin-bottom:-23px;"></div>
					<br>
					<br>
					<a href="#top" style="text-decoration:none;">
						<div onclick="${onclickFunction}">
							<div class="partner-img" style="margin-bottom: -30px; margin-top: -30px;">
								<br>
								<img src="https://performanceaffiliate.com/merchants/uploadedimage/${dataitem.merchant_profileimage}" alt="" height="65px">
							</div>
							<br>
							<div>
							<div class="partner-name" style="-webkit-text-stroke: thin; background-color: white; color:${mf.name_color}; overflow: hidden; text-overflow: ellipsis; max-height: 2.4em; line-height: 1.2em;">
								<b style="cursor:pointer;">${dataitem.companyname}</b>
							</div>
							<p style="float:right; margin-top:-80%; font-size:8px;"></p>
							<button type="button" class="btn btn-outline-chashback title" style="height:78px">
								${dataitem.program_description}
								<i class="fas fa-caret-right"></i>
							</button>
							<a href="#top" style="cursor:pointer; text-decoration:none; color:${mf.name_color};" onclick="${onclickFunction}" class="PerAffterms">View</a>
						</div>
						

						</div>
					</a>
				</div>
			</div>`;
			counter++;	
			if (counter >= totalLoadedItems) {
				counter = 0;
                break; // Exit the loop after 30 items are found
            }
		}
			
		}
			loadedItems = endIndex;
			consDiv.innerHTML = dataHtml;
			$("#btn_showmore").html("Show More");
	}
	
	fetchFromApi() {
		$("#btn_showmore").show();
		var consDiv = document.getElementById("PerAff_suggesstion-box");
		consDiv.innerHTML = "";
		$("#btn_showmore").html('<i class="fas fa-spinner fa-spin"></i> Loading...');
		
		var defaultCountry = "United States of America";
		var selectedCountryCookie = mf.getSelectedCountryFromCookie();
		
		if (selectedCountryCookie && selectedCountryCookie !== "") {
			defaultCountry = selectedCountryCookie;
		}
		
		var selectElement = document.getElementById("countrySelect");
		var selectedValue = selectElement.value;
		console.log("Selected value: " + selectedValue);
		document.cookie = "selectedCountry=" + selectedValue + "; path=/";
			const PerAff_mainApiUrl = "https://performanceaffiliate.com/performanceAffiliateClone/refApis/searlcoShopFront.php";
			$.ajax({
				type: "GET",
				url: PerAff_mainApiUrl,
				data: {
					MADKAI: PerAffconToken,
					selectedCountry: selectedValue,  
					defaultCountry: defaultCountry
				},
				dataType: "json",
				success: function(PerAff_data) {
					loadedItems += currentLimit;
					mf.processData(PerAff_data, loadedItems, loadedItems + currentLimit);
							},
			error: function (error) {
				console.error(error);
			}
		});
	
		loadedItems = 0; // Reset loadedItems to 0
					

	}
	
		
	
	
	// handleCountryChange() {
		
	// 	$("#btn_showmore").show();
	// 	var consDiv = document.getElementById("PerAff_suggesstion-box");
	// 	consDiv.innerHTML = "";
	// 	$("#btn_showmore").html('<i class="fas fa-spinner fa-spin"></i> Loading...');
		
	// 	var defaultCountry = "United States of America";
	// 	var selectedCountryCookie = mf.getSelectedCountryFromCookie();
		
	// 	if (selectedCountryCookie && selectedCountryCookie !== "") {
	// 		defaultCountry = selectedCountryCookie;
	// 	}
		
	// 	var selectElement = document.getElementById("countrySelect");
	// 	var selectedValue = selectElement.value;
	// 	console.log("Selected value: " + selectedValue);
	// 	document.cookie = "selectedCountry=" + selectedValue + "; path=/";
	// 	currentLimit = 30;
	
	// 	var jsonFileUrl = `https://performanceaffiliate.com/performanceAffiliateClone/refApis/dateFile-${mf.id}-${currentDate}.json?MADKAI=${PerAffconToken}&selectedCountry=${selectedCountryCookie}`;
		
	// 	$.ajax({
	// 		type: "GET",
	// 		url: jsonFileUrl,
	// 		dataType: "json",
	// 		success: function(PerAff_data) {
	// 			if (PerAff_data != null && PerAff_data.length > 0) {
	// 				// Calculate the end index based on the current limit and loaded items
	// 				let endIndex = loadedItems + currentLimit;
	
	// 				for (let x = loadedItems; x < endIndex && x < PerAff_data.length; x++) {
						
	// 					var dataitem = PerAff_data[x];
	// 					let discountTags = "";
	// 					let percentageType = "";
	// 					let onclickFunction = "";

	// 					  if(dataitem.without_disc == "without_disc"){
	// 						onclickFunction = `mf.PerAff_s_Brand('${dataitem.merchant_profileimage}', '${dataitem.companyname}', '${dataitem.program_description}', '${dataitem.url_link}', '${mf.btn_color}', '${mf.name_color}')`;
	// 					  }
	// 					else{
	// 						if (dataitem.discType == null) {
	// 							percentageType = "%";
	// 							dataitem.discType = "";
	// 						  }
	// 						discountTags = `
	// 						  <div class="flat-code" style="margin-bottom:-23px;">
	// 							<span class="off" style="background-color: ${mf.name_color}; color:#fff;">
	// 							  Discount ${dataitem.discType} ${dataitem.discount_amount} ${percentageType}
	// 							</span>
	// 							<span></span>
	// 						  </div>
	// 						  <br>`;
	// 						onclickFunction = `mf.PerAff_s_Brand_Disc('${dataitem.merchant_profileimage}','${dataitem.coupon_details}','${dataitem.valid_to}','${dataitem.valid_from}','${dataitem.program_description}','${dataitem.url_link}','${mf.btn_color}','${mf.name_color}')`;
	// 					  }
					
	// 					dataHtml +=`<div class="col">
	// 					<div class="partner-card">
	// 						${discountTags}
	// 						<div class="flat-code" style="margin-bottom:-23px;"></div>
	// 						<br>
	// 						<br>
	// 						<a href="#top" style="text-decoration:none;">
	// 							<div onclick="${onclickFunction}">
	// 								<div class="partner-img" style="margin-bottom: -30px; margin-top: -30px;">
	// 									<br>
	// 									<img src="https://performanceaffiliate.com/merchants/uploadedimage/${dataitem.merchant_profileimage}" alt="" height="65px">
	// 								</div>
	// 								<br>
	// 								<div>
	// 								<div class="partner-name" style="-webkit-text-stroke: thin; background-color: white; color:${mf.name_color}; overflow: hidden; text-overflow: ellipsis; max-height: 2.4em; line-height: 1.2em;">
	// 									<b style="cursor:pointer;">${dataitem.companyname}</b>
	// 								</div>
	// 								<p style="float:right; margin-top:-80%; font-size:8px;"></p>
	// 								<button type="button" class="btn btn-outline-chashback title" style="height:78px">
	// 									${dataitem.program_description}
	// 									<i class="fas fa-caret-right"></i>
	// 								</button>
	// 								<a href="#top" style="cursor:pointer; text-decoration:none; color:${mf.name_color};" onclick="${onclickFunction}" class="PerAffterms">View</a>
	// 							</div>
								

	// 							</div>
	// 						</a>
	// 					</div>
	// 				</div>`;
	// 				}
	
	// 				loadedItems = endIndex; // Update the loaded items count
	
	// 				consDiv.innerHTML = dataHtml;
	// 			}
	// 			// if (PerAff_data.length === 0) {
	// 			// 	$("#btn_showmore").hide();
	// 			// 	mf.showAlert("Sorry no results found, Please select a different country");
	// 			// } else if (PerAff_data.length < 30) {
	// 			// 	$("#btn_showmore").hide();
	// 			// } else {
	// 				$("#btn_showmore").html("Show More");
	// 			// }
	
	// 			// // Check if displayedItems is greater or equal to PerAff_data length
	// 			// if (displayedItems >= PerAff_data.length) {
	// 			// 	$("#btn_showmore").hide();
	// 			// }
	// 		},
	// 		error: function (error) {
	// 			console.error(error);
	// 		}
	// 	});
	
	// 	loadedItems = 0; // Reset loadedItems to 0
	// }
	
	
	// To get the Selected Country from the country 
	getSelectedCountryFromCookie() {
	  var cookieValue = document.cookie
	    .split("; ")
	    .find((row) => row.startsWith("selectedCountry="));

	  if (cookieValue) {
	    var selectedCountry = cookieValue.split("=")[1];
	    return selectedCountry;
	  }
	//   console.log("cookie:",selectCountry);
	  return null;
	}

	// ========================= Single-Brand-Page  ======================= //

	PerAff_s_Brand(url, name, desc, linkurl, btncolor, namecolor) {
	  const PerAff_eskd_srch = document.getElementById("PerAff_eskd_srch");
	  const PerAff_elefRec = document.getElementById("PerAff_elefRec");
	  const PerAff_elefRectwo = document.getElementById("PerAff_elefRectwo");
	  const outputPerAff_histoFrec = document.getElementById("PerAff_histoFrec");
	  outputPerAff_histoFrec.innerHTML =
	    '<section class="PerAff_partner_info PerAff_single-info-page" id="top">' +
	    '<div class="container">' +
	    '<div class="row">' +
	    '<div class="col-md-12">' +
	    '<div class="PerAff_ethical-text mb-8">' +
	    '<div class="PerAff_products-card text-center mb-4" id="PerAff_suggesstion-box" style="background:#fff;">' +
	    '<div class="pro-img">' +
	    '<a href="company.php?id=7">' +
	    '<img src="https://performanceaffiliate.com/performanceAffiliateClone/merchants/uploadedimage/' +
	    url +
	    '" class="img-responsive" style="height:150px; width:150px;"  alt="">' +
	    "</a>" +
	    "</div><br>" +
	    "<a href=" +
	    linkurl +
	    ' target="_blank" type="button" class="btn PerAff-btn-view" style="background-color:' +
	    btncolor +
	    '; color:#fff;" aria-expanded="false"> Visit Now </a>' +
	    "</div><br>" +
	    '<center><a href="" type="button" class="btn PerAff-btn-view" style="background-color:' +
	    btncolor +
	    '; color:#fff; margin-top:-25px" aria-expanded="false"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></center>' +
	    '<br><div class="detailspage-section">' +
	    '<div class="PerAff_descript-brand">' +
	    "<h4 style='color:" +
	    namecolor +
	    "'>Company Details</h4>" +
	    "<p>" +
	    desc +
	    "</p>" +
	    "</div>" +
	    "</div>" +
	    ' <div class="PerAff_ads-img"><center><img src="https://performanceaffiliate.com/performanceAffiliateClone/merchants/uploadedimage/' +
	    url +
	    '"  alt="" style="height:200px; width:200px;" class="responsive-img"></center> </div>' +
	    "</div>" +
	    "</div>" +
	    "</div>" +
	    "</div>" +
	    "</section>";
	  PerAff_eskd_srch.style.display = "none";
	  PerAff_elefRec.style.display = "none";
	  PerAff_elefRectwo.style.display = "none";
	}

	// ========================= With Discount Single-Brand-Page   ======================= //
	PerAff_s_Brand_Disc(
	  imgurl,
	  wdesc,
	  valid_to,
	  valid_from,
	  desc,
	  linkurl,
	  btncolor,
	  namecolor
	) {

	  const PerAff_eskd_srch = document.getElementById("PerAff_eskd_srch");
	  const PerAff_elefRec = document.getElementById("PerAff_elefRec");
	  const PerAff_elefRectwo = document.getElementById("PerAff_elefRectwo");
	  const outputPerAff_histoFrec = document.getElementById("PerAff_histoFrec");
	  outputPerAff_histoFrec.innerHTML =
	    '<section class="PerAff_partner_info PerAff_single-info-page" id="top">' +
	    '<div class="container">' +
	    '<div class="row">' +
	    '<div class="col-md-12">' +
	    '<div class="PerAff_ethical-text mb-8">' +
	    '<div class="PerAff_products-card text-center mb-4" id="PerAff_suggesstion-box" style="background:#fff;">' +
	    '<div class="pro-img">' +
	    '<a href="company.php?id=7">' +
	    '<img src="https://performanceaffiliate.com/performanceAffiliateClone/merchants/uploadedimage/' +
	    imgurl +
	    '" class="img-responsive" style="height:150px; width:150px;"  alt="">' +
	    "</a>" +
	    "</div><br>" +
	    "<a href=" +
	    linkurl +
	    ' target="_blank" type="button" class="btn PerAff-btn-view" style="background-color:' +
	    btncolor +
	    '; color:#fff;" aria-expanded="false"> Visit Now </a>' +
	    "</div><br>" +
	    '<center><a href="" type="button" class="btn PerAff-btn-view" style="background-color:' +
	    btncolor +
	    '; color:#fff; margin-top:-25px" aria-expanded="false"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a></center>' +
	    '<br><div class="detailspage-section">' +
	    '<div class="PerAff_descript-brand">' +
	    "<h4 style='color:" +
	    namecolor +
	    "'>Coupon Details</h4>" +
	    "<p>" +
	    wdesc +
	    "</p>" +
	    "<b>Valid From:</b>" +
	    valid_from +
	    "<br>" +
	    "<b>Valid To:</b>" +
	    valid_to +
	    "</div>" +
	    "</div>" +
	    '<div class="detailspage-section">' +
	    '<div class="PerAff_descript-brand">' +
	    "<h4 style='color:" +
	    namecolor +
	    "'>Company Details</h4>" +
	    "<p>" +
	    desc +
	    "</p>" +
	    "</div>" +
	    "</div>" +
	    ' <div class="PerAff_ads-img"><center><img src="https://performanceaffiliate.com/performanceAffiliateClone/merchants/uploadedimage/' +
	    imgurl +
	    '"  alt=""  class="responsive-img"></center> </div>' +
	    "</div>" +
	    "</div>" +
	    "</div>" +
	    "</div>" +
	    "</section>";
	  PerAff_eskd_srch.style.display = "none";
	  PerAff_elefRec.style.display = "none";
	  PerAff_elefRectwo.style.display = "none";
	}
	// =============================== Search ============================= //

	searchResult(event) {
		var defaultCountry = "United States of America";
		var selectedCountryCookie = mf.getSelectedCountryFromCookie();
		if (selectedCountryCookie && selectedCountryCookie !== "") {
			defaultCountry = selectedCountryCookie;
		}
	  const search = $("#search-bar").val();
	  const PerAff_elefRectwo = document.getElementById("PerAff_elefRectwo");
	  console.log("This is", search);

	  if (search == "") {
	    // Redirect to the search page with empty search query
	    var selectedCountryCookie = mf.getSelectedCountryFromCookie();
	    window.location.href =
	      "https://performanceaffiliate.com/performanceAffiliateClone/refApis/searlcoMallFront.php?MADKAI=" +
		  PerAffconToken +
		  "&selectedCountry=" +
		  selectedCountryCookie +
		  "&defaultCountry=" +
		  defaultCountry;
	  } else {
	    var selectedCountryCookie = mf.getSelectedCountryFromCookie();
	    $.ajax({
	      type: "POST",
	      url:
	        "https://performanceaffiliate.com/performanceAffiliateClone/refApis/search.php?MADKAI=" +
	        PerAffconToken +
	        "&query=" +
	        search +
	        "&selectedCountry=" +
	        selectedCountryCookie +
			"&defaultCountry=" +
			defaultCountry,
	      success: function (data) {
	        console.log("Data checked", data);
	        $("#PerAff_suggesstion-box").html(data);
	        $("#search-bar").css("background", "#FFF");
	        PerAff_elefRectwo.style.display = "none";
	      },
	      error: function (xhr, status, error) {
	        console.error(xhr);
	      },
	    });
	  }
	}

	selectCountry(val) {
	  $("#search-box").val(val);
	  $("#PerAff_suggesstion-box").hide();
	}

	// =============================== Show More Loader ============================= //
	loadMore() {
		//   if (isFetching) {
    	// 	// If a fetch operation is already in progress, do nothing
    	// 	return;
  		// 	}

  		isFetching = true; // Set the flag to indicate fetch is in progress
		$("#btn_showmore").show();
		var consDiv = document.getElementById("PerAff_suggesstion-box");
		consDiv.innerHTML = "";
		$("#btn_showmore").html('<i class="fas fa-spinner fa-spin"></i> Loading...');
		
		var defaultCountry = "United States of America";
		var selectedCountryCookie = mf.getSelectedCountryFromCookie();
		
		if (selectedCountryCookie && selectedCountryCookie !== "") {
			defaultCountry = selectedCountryCookie;
		}
		
		var selectElement = document.getElementById("countrySelect");
		var selectedValue = selectElement.value;
		console.log("Selected value: " + selectedValue);
		document.cookie = "selectedCountry=" + selectedValue + "; path=/";
		var jsonFileUrl = `https://performanceaffiliate.com/performanceAffiliateClone/refApis/jsonFiles/dateFile-${mf.id}-${currentDate}.json`;
		
		$.ajax({
			type: "GET",
			url: jsonFileUrl,
			dataType: "json",
			success: function(PerAff_data) {
				if (PerAff_data != null && PerAff_data.length > 0) {
					console.log("json file found");
					loadMoreCalled = true;
					// Process data from JSON file
					loadedItems += currentLimit;
					mf.processData(PerAff_data, loadedItems, loadedItems + currentLimit);
				} else {
					console.log("json file not found");
					mf.fetchFromApi();	
				}
			},
			error: function(error) {
				console.error(error);
				// If there's an error fetching JSON, fallback to API call
				mf.fetchFromApi();
			}
		});

		
	}
	// loadMore() {
	// 	var defaultCountry = "United States of America";
	// 	var selectedCountryCookie = mf.getSelectedCountryFromCookie();
	// 	if (selectedCountryCookie && selectedCountryCookie !== "") {
	// 		defaultCountry = selectedCountryCookie;
	// 	}
	
	// 	var selectElement = document.getElementById("countrySelect");
	// 	var selectedValue = selectElement.value;
	// 	console.log("Selected value: " + selectedValue);
	// 	document.cookie = "selectedCountry=" + selectedValue + "; path=/";
	
	// 	currentLimit += 30;
	// 	console.log("limit:", currentLimit);
	
	// 	$("#btn_showmore").html('<i class="fas fa-spinner fa-spin"></i> Loading...');
	
	// 	const PerAff_mainApiUrl = "https://performanceaffiliate.com/performanceAffiliateClone/refApis/loadMoreTest.php";
	
	// 	$.ajax({
	// 		type: "GET",
	// 		url: PerAff_mainApiUrl,
	// 		data: {
	// 			MADKAI: PerAffconToken,
	// 			selectedCountry: selectedCountryCookie,
	// 			defaultCountry: defaultCountry,
	// 			consLimit: currentLimit
	// 		},
	// 		dataType: "json",
	// 		success: function (PerAff_data) {
	// 			var consDiv = document.getElementById("PerAff_suggesstion-box");
	
	// 			var dataHtml = "";
	
	// 			if (PerAff_data != null && PerAff_data.length > 0) {
	// 				let endIndex = loadedItems + currentLimit;
	
	// 				for (let x = loadedItems; x < endIndex && x < PerAff_data.length; x++) {
	// 					var dataitem = PerAff_data[x];
	// 					let discountTags = "";
	// 					let percentageType = "";
	// 					let onclickFunction = "";

	// 					  if(dataitem.without_disc == "without_disc"){
	// 						onclickFunction = `mf.PerAff_s_Brand('${dataitem.merchant_profileimage}', '${dataitem.companyname}', '${dataitem.program_description}', '${dataitem.url_link}', '${mf.btn_color}', '${mf.name_color}')`;
	// 					  }
	// 					else{
	// 						if (dataitem.discType == null) {
	// 							percentageType = "%";
	// 							dataitem.discType = "";
	// 						  }
	// 						discountTags = `
	// 						  <div class="flat-code" style="margin-bottom:-23px;">
	// 							<span class="off" style="background-color: ${mf.name_color}; color:#fff;">
	// 							  Discount ${dataitem.discType} ${dataitem.discount_amount} ${percentageType}
	// 							</span>
	// 							<span></span>
	// 						  </div>
	// 						  <br>`;
	// 						onclickFunction = `mf.PerAff_s_Brand_Disc('${dataitem.merchant_profileimage}','${dataitem.coupon_details}','${dataitem.valid_to}','${dataitem.valid_from}','${dataitem.program_description}','${dataitem.url_link}','${mf.btn_color}','${mf.name_color}')`;
	// 					  }
					
	// 					dataHtml +=`<div class="col">
	// 					<div class="partner-card">
	// 						${discountTags}
	// 						<div class="flat-code" style="margin-bottom:-23px;"></div>
	// 						<br>
	// 						<br>
	// 						<a href="#top" style="text-decoration:none;">
	// 							<div onclick="${onclickFunction}">
	// 								<div class="partner-img" style="margin-bottom: -30px; margin-top: -30px;">
	// 									<br>
	// 									<img src="https://performanceaffiliate.com/merchants/uploadedimage/${dataitem.merchant_profileimage}" alt="" height="65px">
	// 								</div>
	// 								<br>
	// 								<div>
	// 								<div class="partner-name" style="-webkit-text-stroke: thin; background-color: white; color:${mf.name_color}; overflow: hidden; text-overflow: ellipsis; max-height: 2.4em; line-height: 1.2em;">
	// 									<b style="cursor:pointer;">${dataitem.companyname}</b>
	// 								</div>
	// 								<p style="float:right; margin-top:-80%; font-size:8px;"></p>
	// 								<button type="button" class="btn btn-outline-chashback title" style="height:78px">
	// 									${dataitem.program_description}
	// 									<i class="fas fa-caret-right"></i>
	// 								</button>
	// 								<a href="#top" style="cursor:pointer; text-decoration:none; color:${mf.name_color};" onclick="${onclickFunction}" class="PerAffterms">View</a>
	// 							</div>
								

	// 							</div>
	// 						</a>
	// 					</div>
	// 				</div>`;
	// 				}
	
	// 				loadedItems = endIndex;
	// 				consDiv.innerHTML = dataHtml;
	// 			}
	
	// 			if (PerAff_data.length === 0) {
	// 				$("#btn_showmore").hide();
	// 				mf.showAlert("Sorry no results found, Please select a different country");
	// 			} else if (PerAff_data.length < 30) {
	// 				$("#btn_showmore").hide();
	// 			} else {
	// 				$("#btn_showmore").html("Show More");
	// 			}
	
	// 			if (displayedItems >= PerAff_data.length) {
	// 				$("#btn_showmore").hide();
	// 			}
	// 		},
	// 		error: function (error) {
	// 			console.error(error);
	// 		}
	// 	});
	
	// 	loadedItems = 0;
	// }
	
	executeAtobFiveTimes(encodedString) {
	  var decodedString = encodedString;

	  for (var i = 0; i < 6; i++) {
	    decodedString = atob(decodedString);
	  }

	  return decodedString;
	}

	// =============================== End ============================= //

	showAlert(message) {
	  // Create an alert element with the provided message
	  var alertElement = $('<div class="alert">' + message + "</div>");

	  // Apply CSS styles to position the alert at the right bottom
	  alertElement.css({
	    position: "fixed",
	    right: "20px",
	    bottom: "20px",
	    padding: "10px",
	    background: "red",
	    color: "white",
	    zIndex: "9999",
	  });

	  // Append the alert element to the body
	  $("body").append(alertElement);

	  // Remove the alert element after 5 seconds
	  setTimeout(function () {
	    alertElement.remove();
	  }, 5000);
	}

}

const mf = new mallfront();
mf.initialize();



