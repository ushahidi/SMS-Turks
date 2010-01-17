<?php
function curl_req($url,$user='',$pw='')
{	
	$curl_handle = curl_init();
	curl_setopt($curl_handle,CURLOPT_URL,$url);
	curl_setopt($curl_handle,CURLOPT_HTTPHEADER,array('Content-type: application/x-www-form-urlencoded;charset=UTF-8'));
	curl_setopt($curl_handle,CURLOPT_CONNECTTIMEOUT,15); // Timeout set to 15 seconds. This is somewhat arbitrary and can be changed.
	curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER,1); //Set curl to store data in variable instead of print
	curl_setopt($curl_handle, CURLOPT_USERPWD, ''.$user.':'.$pw.'');
	$buffer = curl_exec($curl_handle);
	curl_close($curl_handle);
	
	return $buffer;
}
?>