<!DOCTYPE html>
<html> 
<body>
<?php
$user = $_POST['user'];
$pass = $_POST['pass'];

if($user == "sock"
&& $pass == "cucker")
{
        include("../../../my_gpt3.php");
}
?>
            <form method="POST" action="secure.php">
            User <input type="text" name="user"></input><br/>
            Pass <input type="password" name="pass"></input><br/>
            <input type="submit" name="submit" value="Go"></input>
            </form>

</body>
</html>
