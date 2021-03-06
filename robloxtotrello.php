<?php

//$data = json_decode($HTTP_RAW_POST_DATA, true);

$Key = $_GET["Key"];
$Token = $_GET["Token"];
$BotKey = $_GET["BotKey"];

$cardscurl = curl_init("https://api.trello.com/1/lists/595987df3e10c1bea15389d0/cards?key={$Key}&token={$Token}");
curl_setopt($cardscurl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cardscurl, CURLOPT_HEADER, 0);
$Cards = json_decode(curl_exec($cardscurl), true);
curl_close($cardscurl);

function Fail($TheCard, $Comment) {
	if ((int)($TheCard["badges"]["comments"]) < 2) {
		$CardID = $TheCard["id"];
		
		$commentdata = json_encode(array("text" => $Comment, "key" => $_GET["Key"], "token" => $_GET["Token"]));
		
		$commentcurl = curl_init("https://api.trello.com/1/cards/{$CardID}/actions/comments");
		curl_setopt($commentcurl, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($commentcurl, CURLOPT_POSTFIELDS, $commentdata);
		curl_setopt($commentcurl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($commentcurl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($commentdata))
		);
		
		$commentresult = curl_exec($commentcurl);
	}
}

foreach ($Cards as $Card) {
	$Role = "";
	$Rank = 0;
	$UserID = 0;
	
	if (count($Card["labels"]) > 0) {
		$Role = reset($Card["labels"])["name"];
	}
	
	if ($Role == "Nurse") {$Rank = 20;}
	if ($Role == "Teacher's Aid") {$Rank = 55;}
	if ($Role == "Teacher") {$Rank = 151;}
	if ($Role == "Secretary") {$Rank = 152;}
	
	$sep1 = stripos($Card["name"], " | ");
	if ($sep1) {
		$sep1 += 3;
		$sepstr = substr($Card["name"], $sep1);
		$sep2 = stripos($sepstr, " | ");
		
		$UserID = (int)substr($Card["name"], $sep1, $sep2);
	}
	
	if (($Role != "") && ($Rank != 0) && ($UserID != 0)) {
		echo "UserID: {$UserID}<br>Role: {$Role}<br>Applied Rank: {$Rank}<br>";
		
		//$usercurl = curl_init("http://www.roblox.com/Game/LuaWebService/HandleSocialRequest.ashx?method=GetGroupRank&playerid={$UserID}&groupId=2518831");
		//curl_setopt($usercurl, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($usercurl, CURLOPT_HEADER, 0);
		//$UserRank = (int)(substr(curl_exec($usercurl), 22, -8));
		
		$usercurl = curl_init("https://api.roblox.com/users/{$UserID}/groups");
		curl_setopt($usercurl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($usercurl, CURLOPT_HEADER, 0);
		$UserGroups = curl_exec($usercurl);

		//if ($UserRank > 0) {
		if (strpos($UserGroups, 'Little Angels Daycare') !== false) {
			//echo "Current Rank: {$UserRank}<br><br>";
			
			$rankdata = json_encode(array("key" => $BotKey));
			
			$rankcurl = curl_init("http://obscure-harbor-96531.herokuapp.com/setRank/2518831/{$UserID}/{$Rank}");
			curl_setopt($rankcurl, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($rankcurl, CURLOPT_POSTFIELDS, $rankdata);
			curl_setopt($rankcurl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($rankcurl, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($rankdata))
			);
			
			$result = curl_exec($rankcurl);
			
			$movedata = json_encode(array("value" => "5956aa471322be9f9f27857f", "key" => $_GET["Key"], "token" => $_GET["Token"]));
			
			$movecurl = curl_init("https://api.trello.com/1/cards/{$Card["id"]}/idList");
			curl_setopt($movecurl, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($movecurl, CURLOPT_POSTFIELDS, $movedata);
			curl_setopt($movecurl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($movecurl, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($movedata))
			);
		
			$moveresult = curl_exec($movecurl);
			
		} else {Fail($Card, "User is not in the group, cannot auto rank.");}
	} else {Fail($Card, "Card is not formatted correctly, cannot auto rank.");}
}
?>