<?php

error_reporting(E_ERROR | E_PARSE);

$percents = [];

$requests_qty = 10;

for ($i = 0; $i < $requests_qty; $i++) {

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://chaosserver/response');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	$result = curl_exec($ch);
	curl_close($ch);

	$code = substr($result, 9, 3);

	$percents[$code]++;

}

foreach($percents as $code=>$qty) {
	echo "{$code}: ".ceil($qty/$requests_qty*100).'%<br>';
}
