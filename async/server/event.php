<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

send();
if(connection_aborted()){
	file_put_contents("flag.txt","closed connecntion",FILE_APPEND );
	exit();
}

function send(){
$db = new SQLite3("../database/queue.db");
$res = $db -> query("SELECT * FROM orders;");
$msg = "";
while ($row = $res->fetchArray()) {
	$msg = $msg.$row["id"].",in_queue".",".$row["drink"].":";

}
echo "data:".$msg."\n\n";
}
?> 
