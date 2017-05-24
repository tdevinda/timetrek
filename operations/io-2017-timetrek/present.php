<?php
namespace GDGSriLanka\TimeTreck;
// header('Access-Control-Allow-Origin: https://timetrek.gdgsrilanka.org');
header('Access-Control-Allow-Origin: *');
include_once ("UserDetails.php");

$email = $_REQUEST['e'];
$hash = preg_replace('/^(#)?([a-fA-F0-9]+)/', '$2', $_REQUEST['a']);

$userDetails = new UserDetails($email);
$finalHash = $userDetails->getHashForStep(5);

if(strcmp($finalHash, $hash) == 0) 
{
	$data['b'] = getShortURL($hash);
	$data['s'] = 403;

	echo json_encode($data);
}
else
{
	$data['b'] = "f0015901d";
	$data['s'] = 200;

	echo json_encode($data);
}


function getShortURL($hash)
{
	$data['longUrl'] = "http://rsvp.lk/gdgsrilanka/google-io-2017-sri-lanka/timetrek?1=". $hash;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://www.googleapis.com/urlshortener/v1/url?key={API KEY HERE}");
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_output = curl_exec ($ch);
	//echo $server_output;
	$output = json_decode($server_output);
	if($output->{'id'} != null) {
		return $output->{'id'};
	} else {
		return 'error';
	}

}



?>