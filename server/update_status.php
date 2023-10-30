<?php
$status = $_REQUEST['status'];
$id = $_REQUEST['uniq'];

$db = new SQLite3("../database/queue.db");
$db -> exec("UPDATE orders SET status='{$status}' WHERE uniqid == '{$id}'");
?>
