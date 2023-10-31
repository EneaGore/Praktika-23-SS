<?php
$id = $_POST['id'];
$order = $_POST["order"]; 

$uniq = uniqid("user_");
$db = new SQLite3("../database/queue.db");
$db -> exec("PRAGMA journal_mode = wal;");
$db->exec('PRAGMA synchronous = NORMAL;');
$db -> exec("INSERT INTO orders(id,drink,status,uniqid) VALUES('{$id}','{$order}','in_queue','{$uniq}');");
?> 
