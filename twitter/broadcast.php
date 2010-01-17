<?php
require_once("twitter.lib.php"); // Requires php5-curl
$twitter_debug = false;          // leave off for actual use

// First and Last name requires, the rest are optional - call this function as follows (omit any unused fields):
//
// broadcast("First","Lastname","M",27,"http://google.com","http://yahoo.com","en");
//
function broadcast_raw($data,$id,$status="missing")
{
	if (!isset($data['firstname']) || !isset($data['lastname']))
		return false;

	$first = $data['firstname'];
	$last = $data['lastname'];
	if (isset($data['city']))
		$city = $data['city'];
	else
		$city = "";
	if (isset($data['gender']))
		$gender = $data['gender'];
	else
		$gender = "";
	if (isset($data['age']))
		$age = $data['age'];
	else
		$age = "";
	if (isset($data['status']))
		$status = $data['status'];
	else
		$status = "";
	$info = "http://www.haitianquake.com/person.php?id=".$id;

	broadcast($first,$last,$city,$gender,$age,$info,"","en",$status);
}

function broadcast($first,$last,$city="",$gender="",$age="",$info="",$photo="",$lang="en",$status="missing") //Firstname Lastname, M/F (single letter only), Age (number only, no 'Age'), info: infolink photo: photolink #haitimissing
{
	global $twitter_debug; 
	if (strtolower($lang) == "ht")
		$twitter = new Twitter("haitimissingkr", "zWqOEOrC0RkPTwVOnJ88"); // Haitian Creole Twitter Feed
	else
		$twitter = new Twitter("haitimissing", "zWqOEOrC0RkPTwVOnJ88"); // English Twitter Feed

	$update = "";
	$update .= ucwords(strtolower($last));
	$update .= " ";
	$update .= ucwords(strtolower($first));
	
	if (strtoupper($gender) == "M" || strtoupper($gender) == "F")
		$update .= ", ".strtoupper($gender);
	if ($age != "")
		$update .= ", ".$age;
	if ($city != "")
		$update .= ", ".ucwords(strtolower($city));
	if(strtolower($status) != "missing")
		$update .= ", ".ucwords($status);
	if ($info != "")
	{
		$info = compress_URL($info);
		if (strtolower($lang) == "ht")
			$update .= ", info: ".$info;
		else
			$update .= ", info: ".$info;
	}
	if ($photo != "")
	{
		$photo = compress_URL($photo);
		if (strtolower($lang) == "ht")
			$update .= ", photo: ".$photo;
		else
			$update .= ", photo: ".$photo;
	}

	$update .= " #haitimissing";

	if($twitter_debug)
		echo "Posted: ".$update." in ".$lang;
	else
		$twitter->updateStatus($update);
}

// Compress the URL into a bit.ly URL
//
// $url = compress_URL("http://google.com");
//
function compress_URL($url,$format='json',$version='2.0.1')
{
	// Create the URL via bitly API
	$bitly = 'http://api.bit.ly/shorten?version='.$version.'&longUrl='.urlencode($url).'&login=haitimissing&apiKey=R_48563f7d786cd5b39f24ddc13a2d9267&format='.$format;

	// Could also use cURL here
	$response = file_get_contents($bitly);

	if(strtolower($format) == 'json')
	{
		$json = @json_decode($response,true);
		return $json['results'][$url]['shortUrl'];
	}
	else
	{
		$xml = simplexml_load_string($response);
		return 'http://bit.ly/'.$xml->results->nodeKeyVal->hash;
	}
}

if ($twitter_debug)
	broadcast("Firstname","Lastname","Port-au-Prince","M",27,"http://google.com","http://yahoo.com","en","testing");
?>
