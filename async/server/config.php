<?php
header('content-type: application/json');
print  json_encode(file_get_contents("../database/cocktails.json"));
exit;
?>
