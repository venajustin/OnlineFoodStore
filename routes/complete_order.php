<?php
session_start();

if (!isset($_SESSION["is_employee"]) || !$_SESSION["is_employee"]) {
    header ("Location: ../templates/home.php");
    exit();
}


require "../../credentials.php";
function test_data($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
$oid = test_data($_POST["order_id"]);

$conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
if (!$conn) {
    echo "error connecting to db";
}

$sql = "UPDATE order_history
        SET  completed = 1
        WHERE order_id = $oid";

$results = mysqli_query($conn, $sql);
if (!$results) {
    echo "error updating db";
}

header("Location: ../templates/pendingorders.php");
exit();

?>