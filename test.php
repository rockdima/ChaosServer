<?php

error_reporting(E_ERROR | E_PARSE);


$percents = []; //response qty by code
$requests_qty = 100;

//loop requests
for ($i = 0; $i < $requests_qty; $i++) {

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://chaosserver/response'); //need to config your apache or nginx
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	$result = curl_exec($ch);
	curl_close($ch);

	//get response code
	$code = substr($result, 9, 3);

	//set a code and increase 
	$percents[$code]++;

}
//show the real percentage
foreach($percents as $code=>$qty) {
	echo "{$code}: ".ceil($qty/$requests_qty*100).'%<br>';
}
