



<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCINS2dyuBipK8MZzOQnzyKdrS2I1_b5I4&libraries=places,geometry"></script>

<script>

	

	function initialize() {

	var my_location_latitude = 51.4183325;

	var my_location_longitude = -0.414405;

	var input = document.getElementById('searchTextField');

	var autocomplete = new google.maps.places.Autocomplete(input);

	google.maps.event.addListener(autocomplete, 'place_changed', function () {

	var place = autocomplete.getPlace();

	document.getElementById('city2').value = place.name;

	document.getElementById('cityLat').value = place.geometry.location.lat();

	document.getElementById('cityLng').value = place.geometry.location.lng();



	var p1 = new google.maps.LatLng(place.geometry.location.lat(), place.geometry.location.lng());

	var p2 = new google.maps.LatLng(my_location_latitude, my_location_longitude);



	var result = (google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);

	result = result*0.62137;

	console.log(result);



	console.log(initial_price);

	var initial_price = jQuery(".order-summary__price").data('initialamount');

	jQuery(".order-summary__total span.price-total").text(parseInt(initial_price));

	var total=jQuery("input[name='amount']").val(initial_price);



	jQuery(".order-summary__group.deliveryyy").remove();



		jQuery('#ajax-loading-screen').css({'opacity':'1', 'display':'block'});

		jQuery('#ajax-loading-screen .loading-icon').animate({'opacity':1},400);

		jQuery.ajax({

		type: 'post',

		url: '<?php echo site_url(); ?>/wp-admin/admin-ajax.php?action=miles_charges',

		dataType: 'json',

		data: {result:result}

		})

		.done(function(value) {

		jQuery('#ajax-loading-screen').css({'opacity':'0', 'display':'none'});

		if (value.delivery_charges == false && value.delivery_cost == 0 || total >= 80) {

		     swal('Your delivery will be free as per our policy!');

		     		jQuery(".order-summary").prepend("<div class='order-summary__group deliveryyy'><div class='order-summary__entry'><div class='order-summary__description h-text-truncate' title='Intro'>Delivery:</div><div class='order-summary__price'>Free</div></div><div class='delivery_note'>Delivery timings are from 10am to 2pm</div></div>")

		      jQuery('form#cms_formsubmit button[type="submit"]').prop("disabled", false);

		}



		if (value.delivery_charges == true && value.delivery_cost == 10 ) {

			swal('You will be charged 10 pounds for delivery as per our policy!');

			total = parseInt(total) + 10;

			jQuery("input[name='amount']").val(total);

			jQuery(".order-summary").prepend("<div class='order-summary__group deliveryyy'><div class='order-summary__entry'><div class='order-summary__description h-text-truncate' title='Intro'>Delivery:</div><div class='order-summary__price'>£10</div></div><div class='delivery_note'>Delivery timings are from 10am to 2pm</div></div>")

			var final_total = jQuery(".order-summary__total span.price-total").text();

			final_total = parseInt(final_total) + 10;

			jQuery(".order-summary__total span.price-total").text(final_total);

			jQuery('form#cms_formsubmit button[type="submit"]').prop("disabled", false);

		}



		if (value.delivery == false) {

			swal('Sorry we do not deliver to areas over 10 miles');

			jQuery('form#cms_formsubmit button[type="submit"]').prop("disabled", true);

			jQuery(".order-summary__group.deliveryyy").remove();

						jQuery(".order-summary").prepend("<div class='order-summary__group deliveryyy'><div class='order-summary__entry'><div class='order-summary__description h-text-truncate' title='Intro'>Delivery:</div><div class='order-summary__price'>Not Available</div></div></div>")



		}

		console.log(value);

		})

		.fail(function() {

		jQuery('#ajax-loading-screen').css({'opacity':'0', 'display':'none'});

		// jQuery('.loader-css').hide();

		console.log("error");

		});





	});

	}



	google.maps.event.addDomListener(window, 'load', initialize);











</script>



<style>

.col{margin-right: 1% !important;}

div#billing-details, #payment-method{border:#e1e8ed 1px solid;margin-bottom:30px;background-color:white;border-radius:4px;float: left;padding-left: 10px;padding-bottom: 30px;width: 100%}

header.e-fieldset__header.-divider-bottom{border-bottom:#e1e8ed 1px solid;padding-bottom:8px;margin-bottom:16px;display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-flow:row wrap;-ms-flex-flow:row wrap;flex-flow:row wrap;-webkit-align-items:baseline;-ms-flex-align:baseline;align-items:baseline;margin:16px;}

div#billing-details .e-fieldset__body{margin:8px 16px;}

div#billing-details .e-fieldset__body select{background-color:white;font-family:inherit;border:1px solid #cccccc;box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);color:rgba(0,0,0,0.75);display:block;font-size:1rem;margin:0 0 1.14286rem 0;padding:0.57143rem;height:2.64286rem;width:100%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;transition:box-shadow 0.45s,border-color 0.45s ease-in-out;border-radius:3px;margin:0 0!important;}

.p-l-z{padding-left:0;}

.p-r-z{padding-right:0;}

div#order-summary{background-color:#fafafa;border-radius:4px;border:#e1e8ed 1px solid;margin-bottom:30px;}

.sidebar-css .e-fieldset__body{margin:8px 16px;}

.sidebar-css .order-summary{width:100%;font-size:14px;overflow:auto;}

.sidebar-css .order-summary__group.-divider-top{border-top:#e1e8ed 1px solid;margin-top:10px;padding-top:10px;}

.sidebar-css .order-summary__entry.h-m0{display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-flow:row nowrap;-ms-flex-flow:row nowrap;flex-flow:row nowrap;margin-bottom:15px;}

.sidebar-css .order-summary__description.h-text-truncate{-webkit-flex:1 0;-ms-flex:1 0;flex:1 0;margin-right:10px;}

.sidebar-css .order-summary__total{-webkit-flex:0 0 150px;-ms-flex:0 0 150px;flex:0 0 150px;-webkit-align-self:baseline;-ms-flex-item-align:baseline;align-self:baseline;text-align:right;}

.sidebar-css h4.t-heading.-size-s.h-m0{}

.sidebar-css .order-summary__entry{display:-webkit-flex;display:-ms-flexbox;display:flex;-webkit-flex-flow:row nowrap;-ms-flex-flow:row nowrap;flex-flow:row nowrap;margin-bottom:15px;}

.sidebar-css h3.t-heading.-size-xs.h-m0{font-size:18px;}

form#cms_formsubmit input { height: 30px; padding-left: 8px; }

form#cms_formsubmit select { box-shadow: none !important; border: 1px solid #ccc !important; height: 34px !important; float: left; padding: 0 !important; }

form#cms_formsubmit span.field-name { font-size: 15px; }

form#cms_formsubmit h3.t-heading.-size-s , .sidebar-css h3.t-heading.-size-xs.h-m0{ font-size: 25px; font-weight: 600; }

form#cms_formsubmit .span_12 {width: 99%;}

form#cms_formsubmit button {height: 35px !important;line-height: 35px !important;padding: 0 30px !important;margin-top: 17px;}

span.t-currency {font-size: 17px;}

.error {color: red;}

</style>



 <br>

 <div class="container">



	<?php 

	// echo "<pre>";

	// print_r($_POST);

	// echo "</pre>";









	if (empty($_POST['Ingredients'])):

		echo '<script>window.location= "'.site_url().'"</script>';

	endif; ?>



	<form class="e-fieldset__body" id="cms_formsubmit" action="#" method="post">

		

		<?php

		foreach ($_POST['Ingredients'] as $key => $value) {

			echo "<input type='hidden' name='Ingredients[".$key."]' value='".$value."'>";

		}



		if (is_array($_POST['Ingredients']['Cake-Filling'])) {

			foreach ($_POST['Ingredients']['Cake-Filling'] as $fillingkey => $fillingvalue) {

				echo "<input type='hidden' name='Ingredients[Cake-Filling-".$fillingkey."]' value='".$fillingvalue."'>";

			}

		}



		foreach ($_POST['size'] as $sizekey => $sizevalue) {

			echo "<input type='hidden' name='Ingredients[size-".$sizekey."]' value='".$sizevalue."'>";

		}

		foreach ($_POST['topping_size'] as $topping_sizekey => $topping_sizevalue) {

			echo "<input type='hidden' name='Ingredients[size-".$topping_sizekey."]' value='".$topping_sizevalue."'>";

		}

		unset($_POST['Ingredients'], $_POST['size'], $_POST['topping_size']);		 

		foreach ($_POST as $key => $value) {

			echo "<input type='hidden' name='".$key."' value='".$value."'>";

		}

		?>





 		<div class="col span_9">

 			<div class="e-fieldset" id="billing-details">

 				<header class="e-fieldset__header -divider-bottom">

 					<div class="e-fieldset__title">

 						<h3 class="t-heading -size-s h-m0">

 							Billing Details 

 						</h3>

 					</div>

 				</header>

 				<div class="col span_6">

 					<div class="large-6 medium-6 columns first p-l-z">

 						<span class="field-name">First Name <abbr title="required">*</abbr></span>

 						<div class="e-form__input"><input class="f-input -type-string -width-full" type="text" name="billing[first_name]" required=""></div>

 					</div>

 				</div>

 				<div class="col span_6">

 					<div class="large-6 medium-6 columns last p-r-z">

 						<span class="field-name">Last Name <abbr title="required">*</abbr></span>

 						<div class="e-form__input"><input class="f-input -type-string -width-full" type="text" name="billing[last_name]" required=""></div>

 					</div>

 				</div>

 				<!-- <div class="col span_6">

 					<div class="large-6 medium-6 columns first p-r-z">

 						<span class="field-name">Country <abbr title="required">*</abbr></span>

 						<div class="e-form__input">

 							<select name="billing[country_code]">

 								<option value="UK" selected="selected">United Kingdom</option>

 							</select>

 						</div>

 					</div>

 				</div> -->

 				

 				<!-- <div class="col span_6">

 					<div class="large-6 medium-6 columns first p-l-z">

 						<span class="field-name">City <abbr title="required">*</abbr></span>

 						<div class="e-form__input"><input class="f-input -type-string -color-mid -width-full" maxlength="100" size="100" type="text" name="billing[city]" required=""></div>

 					</div>

 				</div>

 				<div class="col span_6">

 					<div class="large-6 medium-6 columns first p-r-z">

 						<span class="field-name">State / Province / Region</span>

 						<div class="e-form__input">

 							<select name="billing[region]">

 								<option value="">Select State</option>

 								<option value="ENG">England</option>

 								<option value="NIR">Northern Ireland</option>

 								<option value="SCT">Scotland</option>

 								<option value="WLS">Wales</option>

 								<option value="AL">Alabama</option>

 								<option value="AK">Alaska</option>

 								<option value="AZ">Arizona</option>

 								<option value="AR">Arkansas</option>

 								<option value="CA">California</option>

 								<option value="CO">Colorado</option>

 								<option value="CT">Connecticut</option>

 								<option value="DE">Delaware</option>

 								<option value="DC">District Of Columbia</option>

 								<option value="FL">Florida</option>

 								<option value="GA">Georgia</option>

 								<option value="HI">Hawaii</option>

 								<option value="ID">Idaho</option>

 								<option value="IL">Illinois</option>

 								<option value="IN">Indiana</option>

 								<option value="IA">Iowa</option>

 								<option value="KS">Kansas</option>

 								<option value="KY">Kentucky</option>

 								<option value="LA">Louisiana</option>

 								<option value="ME">Maine</option>

 								<option value="MD">Maryland</option>

 								<option value="MA">Massachusetts</option>

 								<option value="MI">Michigan</option>

 								<option value="MN">Minnesota</option>

 								<option value="MS">Mississippi</option>

 								<option value="MO">Missouri</option>

 								<option value="MT">Montana</option>

 								<option value="NE">Nebraska</option>

 								<option value="NV">Nevada</option>

 								<option value="NH">New Hampshire</option>

 								<option value="NJ">New Jersey</option>

 								<option value="NM">New Mexico</option>

 								<option value="NY">New York</option>

 								<option value="NC">North Carolina</option>

 								<option value="ND">North Dakota</option>

 								<option value="OH">Ohio</option>

 								<option value="OK">Oklahoma</option>

 								<option value="OR">Oregon</option>

 								<option value="PA">Pennsylvania</option>

 								<option value="RI">Rhode Island</option>

 								<option value="SC">South Carolina</option>

 								<option value="SD">South Dakota</option>

 								<option value="TN">Tennessee</option>

 								<option value="TX">Texas</option>

 								<option value="UT">Utah</option>

 								<option value="VT">Vermont</option>

 								<option value="VA">Virginia</option>

 								<option value="WA">Washington</option>

 								<option value="WV">West Virginia</option>

 								<option value="WI">Wisconsin</option>

 								<option value="WY">Wyoming</option>

 							</select>

 						</div>

 					</div>

 				</div> -->



 			<!-- 	<div class="col span_6">

 					<div class="large-6 medium-6 columns last p-l-z">

 						<span class="field-name">Zip / Postal Code</span>

 						<div class="e-form__input"><input class="f-input -type-string -width-full" maxlength="100" size="100" type="text" name="billing[zipcode]" required=""></div>

 					</div>

 				</div> -->



 				<div class="col span_6">

 					<div class="large-6 medium-6 columns last p-l-z">

 						<span class="field-name">Email Address</span>

 						<div class="e-form__input"><input type="email" class="form_div" id="username" name="billing[email]" required="" value=""></div>

 					</div>

 				</div>

 				<div class="col span_6">

 					<div class="large-6 medium-6 columns last p-l-z">

 						<span class="field-name">Mobile Phone</span>

 						<div class="e-form__input"><input class="f-input -type-string -width-full" maxlength="100" size="100" type="text" name="billing[zipcode]"></div>

 					</div>

 				</div>



 				<div class="col span_12">

 					<div class="large-6 medium-6 columns first p-l-z">

 						<span class="field-name">Address<abbr title="required">*</abbr></span>

 						<div class="e-form__input"><input id="searchTextField" type="text" size="50" class="f-input -type-string -width-full" name="billing[address]" placeholder="Enter a location" autocomplete="on"  /></div>

 						<!-- <div class="e-form__input"><input class="f-input -type-string -width-full" maxlength="100" size="100" type="text" name="billing[address]" required=""></div> -->

 						    <input type="hidden" id="city2" name="city2" />

						    <input type="hidden" id="cityLat" name="cityLat" />

						    <input type="hidden" id="cityLng" name="cityLng" />

 					</div>

 				</div>

 			</div>

 			<div style="clear: both;"></div>

 			<div id="payment-method">

 				<div class="e-fieldset">

 					<header class="e-fieldset__header -divider-bottom">

 						<div class="e-fieldset__title">

 							<h3 class="t-heading -size-s">Payment Information</h3>

 						</div>

 					</header>

 					<div class="col span_12">

 						<label class="card-label credit-card-number-label" for="credit-card-number">

 							<span class="field-name">Card Number</span>

 							<input type="tel" size="20" name="carddetails[cardno]" value="" maxlength="19">

 						</label>

 					</div>

 					<div class="col span_6">

 						<label class="card-label expiration-label right-border" for="expiration">

 							<span class="field-name">MM</span>

 							<input type="tel" size="2" name="carddetails[mm]" value="" maxlength="2">

 						</label>

 					</div>

 					<div class="col span_6">

 						<label class="card-label expiration-label right-border" for="expiration">

 							<span class="field-name">YY</span>

 							<input type="tel" size="4" name="carddetails[yy]" value="" maxlength="4">

 						</label>

 					</div>

 					<div class="col span_6">

 						<label class="card-label cvv-label" for="cvv">

 							<span class="field-name">CVV (3 digits)</span>

 							<input type="tel" size="4" name="carddetails[cvv]" value="456">

 						</label>

 					</div>

 					<div style="clear: both;"></div>

 				</div>

 				<footer class="e-fieldset__footer">

 					<button type="submit" disabled="disabled">Pay Now</button>

 				</footer>

 			</div>

 		</div>

 		<div class="col span_3">

 			<div class="sidebar-css" id="order-summary">

 				<header class="e-fieldset__header -divider-bottom">

 					<div class="e-fieldset__title">

 						<h3 class="t-heading -size-xs h-m0">Order Summary</h3>

 					</div>

 				</header>

 				<div class="e-fieldset__body">

 					<div class="order-summary">

 						<div class="order-summary__group">

 							<div class="order-summary__entry">

 								<div class="order-summary__description h-text-truncate" title="Intro">

 									Amount:

 								</div>

 								<div class="order-summary__price" data-initialamount="<?= $_POST['amount'];  ?>">

 									£<?php echo $_POST['amount']; ?>

 								</div>

 							</div>

 						</div>

 						<div class="order-summary__group -divider-top">

 							<div class="order-summary__entry h-m0">

 								<div class="order-summary__description h-text-truncate">

 									<h5 class="t-heading -size-s h-m0">Total:</h5>

 								</div>

 								<div class="order-summary__total">

 									<h5 class="t-heading -size-s h-m0">

 										<b><span class="t-currency">£</span><span class="price-total"><?php echo $_POST['amount']; ?></span></b>

 									</h5>

 								</div>

 							</div>

 						</div>

 					</div>

 				</div>

 			</div>

 		</div>

 	</form>

 	<div id="msg"></div>	

 </div>









