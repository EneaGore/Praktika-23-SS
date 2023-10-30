<?php
ini_set('max_execution_time', '0');
//header('content-type: application/json');

//Simulation the process of making a cocktail by waiting for 15 seconds
//$test_json = file_get_contents("../database/cock_q.json");
//$jsonArray = json_decode($test_json,true);



//echo sizeof($res -> fetchArray());
/*
while ($row = $res->fetchArray()) {
        print_r($row[0]);
}
 */

/*
while ($row = $res->fetchArray()) {
        print_r($row["id"]);
}
*/
set_time_limit(0);
//max_execution_time = 0;
$empty_queue = true;

	$db = new SQLite3("../database/queue.db");

$res_count = $db -> query("SELECT count(*) FROM orders");
$row_count = $res_count -> fetchArray();
$count =  $row_count[0];
	
	//$test_json = file_get_contents("../database/cock_q.json");
//$jsonArray = json_decode($test_json,true);
//$last_idx = 0;

if ($count == 0) {
//	echo("cocktail queue empty");
	sleep(random_int(3,6));
	echo "waiting";
	exit;	
}else{
        $empty_queue = false;	
	$res_select = $db -> query("SELECT * FROM orders WHERE rowid = (SELECT MIN(rowid) FROM orders)");
	$row_select = $res_select -> fetchArray();
	$db -> exec("DELETE FROM orders WHERE rowid = (SELECT MIN(rowid) FROM orders)");
}

$result = array();
$result["id"] = $row_select['id'];
$result["order"] =  $row_select['drink'];
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
//file_put_contents("../database/cock_q.json",$pretty_json);
print json_encode($result);
exit;
?>

