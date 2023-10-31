<?php
$id = $_REQUEST['uniq'];

$db = new SQLite3("../database/queue.db");

$db -> exec("DELETE FROM orders WHERE uniqid == '{$id}'");

?>
