<?php
$db = new SQLite3("../database/queue.db");
//$db->busyTimeout(5000);
//$db -> exec("PRAGMA journal_mode = wal;");
//$db->exec('PRAGMA synchronous = NORMAL;');
//$res = $db -> query("SELECT * FROM orders WHERE rowid = (SELECT MIN(rowid) from orders)");
$res = $db -> query("SELECT count(*) FROM orders");

//echo sizeof($res -> fetchArray());
while ($row = $res->fetchArray()) {
        print_r($row[0]);
}

//$row = $res -> fetchArray();
//print_r($row["id"]);
?>

