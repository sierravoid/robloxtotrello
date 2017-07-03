<!DOCTYPE html>
<html>
<body>

<?php

$data = json_decode($HTTP_RAW_POST_DATA, true);

$Key = $data["Key"];
$Token = $data["Token"];
$BotKey = $data["BotKey"];

$cards = file_get_contents("http://www.google.com");
//$cards = file_get_contents("https://api.trello.com/1/lists/595987df3e10c1bea15389d0/cards?key=" . $Key . "$&token=" . $Token);

echo $cards;


//http://obscure-harbor-96531.herokuapp.com/setRank/2518831/$userid/$rank
//data: {key = $botkey}

//move cards: trello.com/1/cards/<card id>/idList?key=<key>&token=<token>&value=<list id>
?>

</body>
</html>