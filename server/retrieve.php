<?php

$empty_queue = true;
$db = new SQLite3("../database/queue.db");

$res_count = $db -> query("SELECT count(*) FROM orders WHERE status =='in_queue'");
$row_count = $res_count -> fetchArray();
$count =  $row_count[0];


if ($count == 0) {

	$res = array();

$res['id'] = "None";
$res['order'] =  "None";
$res['uniq'] = "None";
print json_encode($res);
	exit;	
}else{
        $empty_queue = false;		
$res_select = $db -> query("SELECT * FROM orders WHERE status =='in_queue' ORDER BY (rowid) ASC Limit 1;
");
	$row_select = $res_select -> fetchArray();

}

$result = array();
$result['id'] = $row_select['id'];
$result['order'] =  $row_select['drink'];
$result['uniq'] = $row_select['uniqid'];

print json_encode($result);
exit;
?>

