<?php

// Set sandbox (test mode) to true/false.

$sandbox = get_option('paypalstatus');


//$sandbox = get_option('paypalstatus');





$api_version = '85.0';

$api_endpoint 	= $sandbox ? 	'https://api-3t.sandbox.paypal.com/nvp' : 'https://api-3t.paypal.com/nvp';

$api_username 	= get_option('API_username');

$api_password 	= get_option('API_password');

$api_signature 	= get_option('API_signature');





// Function to convert NTP string to an array

function NVPToArray($NVPString)

{

	$proArray = array();

	while(strlen($NVPString))

	{

		// name

		$keypos= strpos($NVPString,'=');

		$keyval = substr($NVPString,0,$keypos);

		// value

		$valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);

		$valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);

		// decoding the respose

		$proArray[$keyval] = urldecode($valval);

		$NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));

	}

	return $proArray;

}