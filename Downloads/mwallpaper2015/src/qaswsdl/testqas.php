<?php 
/**
 * Script to the connection with QAS server.
 */
$ch = curl_init() or die(curl_error());
curl_setopt($ch, CURLOPT_POST,false);
curl_setopt($ch, CURLOPT_URL,"https://ws2.ondemand.qas.com/ProOnDemand/V3/ProOnDemandService.asmx");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$data1=curl_exec($ch);
$error = curl_error($ch);
$info = curl_getinfo($ch);
curl_close($ch); 

if ($error) {
	echo "Error in connection";
	print_r($error);
	print_r($info);
} else  {
	echo "Success";
}
?>