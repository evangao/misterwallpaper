<?php

if (!empty($_GET['evid'])){
	$curl_url = 'http://sys.captcha2.com/validate.php';
	$post_str = "evid={$_GET['evid']}&x={$_GET['x']}&y={$_GET['y']}&ip={$_SERVER['REMOTE_ADDR']}";
	$result = do_curl($curl_url, $post_str);
	echo $result;
}

function check_captcha2_validation(){
	$ip_address = $_SERVER['REMOTE_ADDR'];
	if (isset($_REQUEST['captcha2_validation_id'])){
		$validation_id = $_REQUEST['captcha2_validation_id'];
		$check_validation_url = "http://sys.captcha2.com/check_validation.php?validation_id=$validation_id&ip_address=$ip_address";
		$captcha2_result = do_curl($check_validation_url);
		if ($captcha2_result === false) $captcha2_result = 'valid';
	}
	else{
		$captcha2_result = "invalid";
	}
	return $captcha2_result;
}

function do_curl($curl_url, $post_str=''){
	$curl_handle=curl_init();
	curl_setopt($curl_handle,CURLOPT_URL,$curl_url);
	curl_setopt($curl_handle, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,5);
	curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,true);
	if ($post_str){
		curl_setopt($curl_handle, CURLOPT_POST, true);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_str);
	}
	$result = curl_exec($curl_handle);
	curl_close($curl_handle);
	return $result;
}

?>