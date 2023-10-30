<?php

$id = $_REQUEST["id"];
$order = $_REQUEST["order"];

$data = array("id" => $id, "order" => $order, "status" => "in_queue");
$test_json = file_get_contents("../database/cock_q.json");
$jsonArray = json_decode($test_json,true);
array_unshift($jsonArray,$data); 
$pretty_json = json_encode($jsonArray, JSON_PRETTY_PRINT);
file_put_contents("../database/cock_q.json",$pretty_json);
file_put_contents("../database/flag.txt","true");

/*
class MyDB extends SQLite3{
        function __construct(){
                $this -> open("test.db");
        }
}
$db = new MyDB();


$sql = "SELECT * FROM test";


$sql_insert = "INSERT INTO test(name) VALUES('ttt')";

$tedo = $db-> query($sql_insert);

$sql_delete = "" ;
$ret = $db-> query($sql);
// $ret = $db->query($sql);
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      echo "ID = ". $row['name'] . "\n";
   }
 */
?>
