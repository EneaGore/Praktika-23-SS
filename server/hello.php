<?php
header('content-type: application/json');
header('CPEE-CALLBACK: true');
// TODO : add a function that after reading the headers, can create some kind of queue, what kind of queue tho
// TODO: well, callback queue i guess, but how does that work with multiple users. lets test by logging
// but does that make sense, this loop can only handle one call back at a time, and it only creates a new callback
// the moment that one of them its returned, so the solution is... one at atime, easy 
//

//file_put_contents("db.txt", "hello callback");
//header( 'Location: https://lehre.bpm.in.tum.de/~ge72git/async/my_test.html' );
$test = array();
$test['headers'] = getallheaders(); // all the headers defined above come here
$test['content'] = $_REQUEST; // here go the arguments
$call_log = $test["headers"]["Cpee-Callback"]; 

file_put_contents("../database/call_log.txt","$call_log \r\n");

//echo var_dump($test);
//echo ($test["headers"]["Accept-Language"]);
//echo ($test["headers"]["Cpee-Callback"]);

//$test['foo'] = 1;
//$test['bar'] = 2;
//
// print json_encode($test);
// DATABASE sqlite, avilable on the server, or right it into a file, which php is not allowed to do or somehing idf



//readfile("my_test.html");
//include("my_test.html");
// WRITE to file, yey
// echo file_get_contents("<!DOCTYPE html>  <html> <body>   <h1>Test for the redirect</h1>  </body>	</html> ");:
//echo(uniqid());

/*
<!DOCTYPE html>
<html>
<body>
<h1> this is not a love song </h1>
</body>
</html>
 */

// file_put_contents("db.txt","".uniqid()."\r\n", FILE_APPEND);
//file_put_contents('remember.json', json_encode($test, JSON_PRETTY_PRINT));


// i guess the process engine doesn do the redirecting for you, you do,
// and then the call back gotta be saved
/*
$command = escapeshellcmd('python3 tes_printt.py');
$output = shell_exec($command);
echo $output;
//  header('CPEE-CALLBACK: true');
 */
exit;
?>

