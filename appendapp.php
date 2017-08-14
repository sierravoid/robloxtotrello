<?php

//$Key = $_GET["key"];
//$Token = $_GET["token"];
$CardID = $_GET["cardid"];
$Passed = $_GET["passed"];
$PlayerName = $_GET["playername"];

function Comment($TheComment, $ID) {
	$commentdata = json_encode(array("text" => $TheComment, "key" => $_GET["key"], "token" => $_GET["token"]));
	
	$commentcurl = curl_init("https://api.trello.com/1/cards/{$ID}/actions/comments");
	curl_setopt($commentcurl, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($commentcurl, CURLOPT_POSTFIELDS, $commentdata);
	curl_setopt($commentcurl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($commentcurl, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($commentdata))
	);
	
	$commentresult = curl_exec($commentcurl);
}

function LogIt($TheLog, $ID) {
	$cardcurl = curl_init("https://api.trello.com/1/cards/{$ID}?key={$_GET['key']}&token={$_GET['token']}");
	curl_setopt($cardcurl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($cardcurl, CURLOPT_HEADER, 0);
	$Card = json_decode(curl_exec($cardcurl), true);
	curl_close($cardcurl);
	
	$URL = $Card["shortUrl"];
	$RestText = "an application.";
	
	$sep1 = stripos($Card["name"], " | ");
	
	if ($sep1) {
		$sepstr = substr($Card["name"], 0, $sep1);
		
		$Labels = $Card["idLabels"];
		reset($Labels);
		$Role = key($Labels);
		$RoleName = $Labels[$Role]["name"];
		
		$RestText = "{$sepstr}'s application for {$Role}.";
	}
	
	$webhookdata = json_encode(array("content" => "{$TheLog} {$RestText} ({$URL})"));
	
	$webhook = curl_init("https://discordapp.com/api/webhooks/345719418086621197/6i351Y7kXtNdp8lAqp893QBP56aoTpnSEVHZsu88FTU5tNzDZRMW-EVwY6hkrDQ7_rPd");
	curl_setopt($webhook, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($webhook, CURLOPT_POSTFIELDS, $webhookdata);
	curl_setopt($webhook, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($webhook, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Content-Length: ' . strlen($webhookdata))
	);
	
	$webhookresult = curl_exec($webhook);
}

if ($Passed == "true") {
	Comment("{$PlayerName} passed this application.", $CardID);
	
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
	
	LogIt("{$PlayerName} passed", $CardID);
	
} elseif ($Passed == "false") {
	Comment("{$PlayerName} rejected this application.", $CardID);
	
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
	
	LogIt("{$PlayerName} rejected", $CardID);
}

?>