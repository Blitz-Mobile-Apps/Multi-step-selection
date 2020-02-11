<?php 



add_action( 'wp_ajax_cms_formsubmit', 'cms_formsubmit' );

add_action( 'wp_ajax_nopriv_cms_formsubmit', 'cms_formsubmit' );

function cms_formsubmit(){



	global $api_username, $api_password, $api_signature, $api_version, $api_endpoint, $wpdb;

		$request_params = array(

			'METHOD'        => 'DoDirectPayment',

			'USER'          => $api_username,

			'PWD'           => $api_password,

			'SIGNATURE'     => $api_signature,

			'VERSION'       => $api_version,

			'PAYMENTACTION' => 'Sale',

			'IPADDRESS'     => $_SERVER['REMOTE_ADDR'],

			'ACCT'          => $_POST['carddetails']['cardno'],

			'EXPDATE'       => $_POST['carddetails']['mm'].$_POST['carddetails']['yy'],

			'CVV2'          => $_POST['carddetails']['cvv'],

			'FIRSTNAME'     => $_POST['billing']['first_name'],

			'LASTNAME'      => $_POST['billing']['last_name'],

			'COUNTRYCODE'   => 'UK',

			'AMT'           => $_POST['amount'],

			'CURRENCYCODE'  => 'GBP',

			'DESC'          => 'Personalise your blend',

		);

		$nvp_string = '';

		foreach($request_params as $var=>$val){

			$nvp_string .= '&'.$var.'='.urlencode($val);

		}

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_VERBOSE, 1);

		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);

		curl_setopt($curl, CURLOPT_TIMEOUT, 30);

		curl_setopt($curl, CURLOPT_URL, $api_endpoint);

		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

		$result = curl_exec($curl);

		curl_close($curl);

		$result_array = NVPToArray($result);

		if ($result_array['ACK'] == 'Success') {

			



			$payment = array(

				'name_blend' => $_POST['name_your_blend'], 

				'pers_msg' => $_POST['optional_personal_message'], 

				'amount' => $_POST['amount'], 

				'ingredients' => json_encode($_POST['Ingredients']), 

				'billingdata' => json_encode($_POST['billing']), 

				'delivery_date' => $_POST['delivery_date'],

				'transaction_id' => $result_array['TRANSACTIONID'], 

				'correlationid' => $result_array['CORRELATIONID'], 

				'status' => 'new order', 

			);

			$wpdb->insert( $wpdb->prefix.'dynamic_form_inquiries', $payment);

			$msg = array('status' => true, 'type' => false,  'msg' => 'You reqest has been submited!', 'msg2' => $result_array );

		}else{

			$msg = array('status' => false, 'type' => false, 'msg' => 'Something went wrong!',  'msg2' => $result_array);

		}

		print(json_encode($msg));

		exit();

	}





/****** for miles calculation **************/



add_action( 'wp_ajax_miles_charges', 'miles_charges' );

add_action( 'wp_ajax_nopriv_miles_charges', 'miles_charges' );

function miles_charges(){





		if ($_POST['result'] < 5) {

			$msg = array('delivery_charges' => false, 'delivery_cost' => 0, 'delivery' => true);

		}



		if ($_POST['result'] > 5 && $_POST['result'] <= 10) {

			$msg = array('delivery_charges' => true, 'delivery_cost' => 10 , 'delivery' => true);

		}



		if ($_POST['result'] > 10) {

			$msg = array('delivery_charges' => false, 'delivery_cost' => 0, 'delivery' => false);

		}





		print(json_encode($msg));

		exit();

	}





// Popupfunctin



add_action( 'wp_ajax_booking_billing_detail', 'booking_billing_detail' );

add_action( 'wp_ajax_nopriv_booking_billing_detail', 'booking_billing_detail' );

function booking_billing_detail(){

	global $wpdb;

	$id = $_GET['id'];

	$results = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'dynamic_form_inquiries WHERE id='.$id);

	$data = json_decode($results->billingdata);

	$message .= '<h2>Billing Details</h2>';

	$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';

	

	foreach ($data as $key => $value) {

		$message .= "<tr style='background: #eee;'><td><strong>".ucwords(str_replace('_', ' ', $key)).":</strong> </td><td>".$value."</td></tr>";

	}

	

	$message .= "</table>";

	echo $message;

	exit();

}



add_action( 'wp_ajax_booking_order_details', 'booking_order_details' );

add_action( 'wp_ajax_nopriv_booking_order_details', 'booking_order_details' );

function booking_order_details(){

	global $wpdb;

	$id = $_GET['id'];

	$results = $wpdb->get_row('SELECT * FROM '.$wpdb->prefix.'dynamic_form_inquiries WHERE id='.$id);

	$data = json_decode($results->ingredients);

	// echo "<pre>";
	// print_r($data);

	$message .= '<h2>Ingredients Details</h2>';

	$message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';

	

	foreach ($data as $key => $value) {

		if ($key == "Cake-Filling") {
			$message .= "";
		} 
		else{
			$message .= "<tr style='background: #eee;'><td><strong>".ucwords(str_replace('-', ' ', $key)).":</strong> </td><td>".$value."</td></tr>";
		}
		
	}

	

	$message .= "<tr style='background: #eee;'><td><strong>Amount:</strong> </td><td>".$results->amount."</td></tr>";

	$message .= "</table>";

	echo $message;

	exit();

}