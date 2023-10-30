<?php

//max_execution_time = 0;
$empty_queue = true;
$db = new SQLite3("../database/queue.db");

$res_count = $db -> query("SELECT count(*) FROM orders WHERE status =='in_queue'");
$row_count = $res_count -> fetchArray();
$count =  $row_count[0];
	
//$test_json = file_get_contents("../database/cock_q.json");
//$jsonArray = json_decode($test_json,true);
//$last_idx = 0;

if ($count == 0) {
//	echo("cocktail queue empty");
	//sleep(random_int(3,6));
	$res = array();

$res['id'] = "None";
$res['order'] =  "None";
$res['uniq'] = "None";
print json_encode($res);
	//print json_encode('{"id":"None","status":"None","uniqid":"None"}');
	exit;	
}else{
        $empty_queue = false;		
$res_select = $db -> query("SELECT * FROM orders WHERE status =='in_queue' ORDER BY (rowid) ASC Limit 1;
");
	#	$res_select = $db -> query("SELECT * FROM orders WHERE rowid = (SELECT MIN(rowid) FROM orders) AND status == 'in_queue'");
	$row_select = $res_select -> fetchArray();
	//$db -> exec("UPDATE orders SET status='done' WHERE id == '{$row_select["id"]}'");

}

$result = array();
$result['id'] = $row_select['id'];
$result['order'] =  $row_select['drink'];
$result['uniq'] = $row_select['uniqid'];

//$result["id"]= $jsonArray[0]['id'];
//$result["order"] =  $jsonArray[0]['order'];

//$resulte["id"]= "test";
//$resulte["order"] =  "test";

// Delete the first Element of the queue
//unset($jsonArray[$last_idx]);
//$jsonArray = array_values($jsonArray);


// $db -> exec("DELETE FROM orders WHERE rowid = (SELECT MIN(rowid) FROM orders)");


// Rewrite the cocktail queue
//$pretty_json = json_encode($jsonArray, JSON_PRETTY_PRINT);
//file_put_co:ntents("../database/cock_q.json",$pretty_json);
print json_encode($result);
//print_r($result);
exit;
?>

