<?php

$Key = $_GET["key"];
$Token = $_GET["token"];
$CardID = $_GET["cardid"];
$Passed = $_GET["passed"];
$PlayerName = $_GET["playername"];

function Comment($TheComment) {
	$commentdata = json_encode(array("text" => $TheComment, "key" => $_GET["key"], "token" => $_GET["token"]));
	
	$commentcurl = curl_init("https://api.trello.com/1/cards/{$CardID}/actions/comments");
	curl_setopt($commentcurl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($commentcurl, CURLOPT_POSTFIELDS, $commentdata);
	curl_setopt($commentcurl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($commentcurl, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($commentdata))
	);
	
	$commentresult = curl_exec($commentcurl);
	
	echo "{$CardID}<br>"
	echo $commentresult;
}

if ($Passed == "true") {
	Comment("{$PlayerName} passed this application.");
	
	$movedata = json_encode(array("value" => "595987df3e10c1bea15389d0", "key" => $_GET["key"], "token" => $_GET["token"]));
			
	$movecurl = curl_init("https://api.trello.com/1/cards/{$CardID}/idList");
	curl_setopt($movecurl, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($movecurl, CURLOPT_POSTFIELDS, $movedata);
	curl_setopt($movecurl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($movecurl, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($movedata))
	);
	
	$moveresult = curl_exec($movecurl);
	
} elseif ($Passed == "false") {
	Comment("{$PlayerName} rejected this application.");
	
	$movedata = json_encode(array("value" => "5956aa5375f28113f8489b47", "key" => $_GET["key"], "token" => $_GET["token"]));
			
	$movecurl = curl_init("https://api.trello.com/1/cards/{$CardID}/idList");
	curl_setopt($movecurl, CURLOPT_CUSTOMREQUEST, "PUT");
	curl_setopt($movecurl, CURLOPT_POSTFIELDS, $movedata);
	curl_setopt($movecurl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($movecurl, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($movedata))
	);
	
	$moveresult = curl_exec($movecurl);
}

?>