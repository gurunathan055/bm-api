<?php
//use this to test iv curl is enabled, if it is not then you should enable it
//echo 'Curl: ', function_exists('curl_version') ? 'Enabled' : 'Disabled';
$soap_request = "<soapenv:Envelope
xmlns:soapenv=\"http://schemas.xmlsoap.org/soap/envelope/\"
xmlns:cbm=\"http://cbm.mmk.com\">\n";
$soap_request .= "<soapenv:Header/>\n";
$soap_request .= "<soapenv:Body>\n";
$soap_request .= " <cbm:getResources>\n";
$soap_request .= " <cbm:in0>3057</cbm:in0>\n";
$soap_request .= " <cbm:in1>info@madmaxsailingcharter.com</cbm:in1>\n";
$soap_request .= " <cbm:in2>password</cbm:in2>\n";
$soap_request .= " <cbm:in3>225</cbm:in3>\n";


$soap_request .= " </cbm:getResources>\n";
$soap_request .= "</soapenv:Body>\n";
$soap_request .= "</soapenv:Envelope>\n";
$header = array(
"Content-type: text/xml;charset=\"utf-8\"",
"Accept: text/xml",
"Cache-Control: no-cache",
"Pragma: no-cache",
"SOAPAction: \"run\"",
"Content-length: ".strlen($soap_request),
);
$soap_do = curl_init();
curl_setopt($soap_do, CURLOPT_URL, "https://www.booking-manager.com/cbm_web_service2/services/CBM");
curl_setopt($soap_do, CURLOPT_CONNECTTIMEOUT, 60);
curl_setopt($soap_do, CURLOPT_TIMEOUT, 60);
curl_setopt($soap_do, CURLOPT_RETURNTRANSFER, true );
curl_setopt($soap_do, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($soap_do, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($soap_do, CURLOPT_POST, true );
curl_setopt($soap_do, CURLOPT_POSTFIELDS, $soap_request);
curl_setopt($soap_do, CURLOPT_HTTPHEADER, $header);
$result = curl_exec($soap_do);
if($result === false) {
$err = 'Curl error: ' . curl_error($soap_do);
curl_close($soap_do);
print $err;
} else {
curl_close($soap_do);
//var_dump( $result);
 //$xml=simplexml_load_string($result) ;
settype($result, 'string');
 echo strlen($result);
$result = preg_replace("/(&lt;)/i","<",$result);
$result = preg_replace("/(&#xd;)/i"," ",$result);
$result = preg_replace("/(&gt;)/i",">",$result);
$result = preg_replace('/(<soap:Envelope xmlns:soap="http:\/\/schemas.xmlsoap.org\/soap\/envelope\/" xmlns:xsd="http:\/\/www.w3.org\/2001\/XMLSchema" xmlns:xsi="http:\/\/www.w3.org\/2001\/XMLSchema-instance"><soap:Body><ns1:getResourcesResponse xmlns:ns1="http:\/\/cbm.mmk.com"><ns1:out>)/i',"",$result);
$result = preg_replace("/(<\/ns1:out><\/ns1:getResourcesResponse><\/soap:Body><\/soap:Envelope>)/i","",$result);



$xml=simplexml_load_string($result) or die("Error: Cannot create object");
print_r($xml);


echo file_put_contents("test.xml",$result);

}
?>