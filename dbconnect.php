


<?php


$server = "us-cdbr-iron-east-03.cleardb.net";
$username = "bde7f09b9dcdf2";
$password = "6ad90408";
$db ="heroku_13fa82f4049612d";

$conn = new mysqli($server, $username, $password, $db);
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}
?>