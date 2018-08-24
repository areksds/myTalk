<?php

function __recaptcha($response, $secret) {
	
	$url = 'https://www.google.com/recaptcha/api/siteverify';
	
	$data = array(
		'secret' => $secret,
		'response' => $response
	);
	$options = array(
		'http' => array (
			'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
			'method' => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$verify = file_get_contents($url, false, $context);
	$captcha_success = json_decode($verify);
	if ($captcha_success->success == false) {
		return 1;
	} else if ($captcha_success->success == true) {
		return 0;
	}
}

?>