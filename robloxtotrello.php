<!DOCTYPE html>
<html>
<body>

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

foreach ($Cards as $Card) {
	$Role = "";
	$Rank = 0;
	$UserID = 0;
	
	if (count($Card["labels"]) > 0) {
		$Role = reset($Card["labels"])["name"];
	}
	
	if ($Role == "Nurse") {$Rank = 55;}
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
		
		$usercurl = curl_init("http://www.roblox.com/Game/LuaWebService/HandleSocialRequest.ashx?method=GetGroupRank&playerid={$UserID}&groupId=2518831");
		curl_setopt($usercurl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($usercurl, CURLOPT_HEADER, 0);
		$UserRank = (int)(substr(curl_exec($usercurl), 22, -8));

		if ($UserRank > 0) {
			echo "Current Rank: {$UserRank}<br><br>";
		} else {
			echo "Current Rank: User is not in group<br><br>";
		}
	}
}


//http://obscure-harbor-96531.herokuapp.com/setRank/2518831/$userid/$rank
//data: {key = $botkey}

//move cards: trello.com/1/cards/<card id>/idList?key=<key>&token=<token>&value=<list id>
?>

</body>
</html>