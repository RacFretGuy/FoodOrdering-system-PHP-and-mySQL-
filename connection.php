<?php

function Connect()
{
	$dbhost = "localhost";
	$dbuser = "id15155015_root1";
	$dbpass = "Racfretguy123$";
	$dbname = "id15155015_r";

	//Create Connection
	$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname) or die($conn->connect_error);

	return $conn;
}
?>