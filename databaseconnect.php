 <!-- A universal file for connecting the system to the database-->
<?php

$host = "localhost";
$user = "root";
$pwd ="";
$db="material_tracking";

$con=  new mysqli($host, $user, $pwd, $db);

if ($con->connect_error){
	die ("Connection failed:". $con->connect_error);
}



?>