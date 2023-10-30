<?php
//$id = $_POST['id'];
//$order = $_POST["order"];

$db = new SQLite3("../database/queue.db");
//$db->busyTimeout(5000);
//$db -> exec("PRAGMA journal_mode = wal;");
//$db->exec('PRAGMA synchronous = NORMAL;');
$db -> exec("DELETE FROM orders WHERE rowid = (SELECT MIN(rowid) FROM orders)");

?>
