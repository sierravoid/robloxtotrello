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
$cards = json_decode(curl_exec($cardscurl));
curl_close($cardscurl);

//echo $Key;

echo "1";
echo $cards;
echo "2";
echo $cards[0];


//http://obscure-harbor-96531.herokuapp.com/setRank/2518831/$userid/$rank
//data: {key = $botkey}

//move cards: trello.com/1/cards/<card id>/idList?key=<key>&token=<token>&value=<list id>
?>

</body>
</html>