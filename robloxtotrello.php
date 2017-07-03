<!DOCTYPE html>
<html>
<body>

<?php

$data = json_decode($HTTP_RAW_POST_DATA, true);

echo $data["Key"];

?>

</body>
</html>