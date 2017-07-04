<?php

$ch = curl_init("http://api.roblox.com/groups/2518831");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);

echo curl_exec($ch);
?>