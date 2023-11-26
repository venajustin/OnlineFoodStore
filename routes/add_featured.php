<?php
session_start();

if (!isset($_SESSION["is_employee"]) || !$_SESSION["is_employee"]) {
    header("Location: " . "../templates/home.php");
    exit();

}

function test_data($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function db_error() {
       
    $_SESSION["cart_message"] = "Could not place order, database error.";
    header('Location: '.$uri.'/OnlineFoodStore/templates/cart.php');
    exit();
    
}

require "../../credentials.php";

$conn = mysqli_connect($hostname, $dbuser, $dbpass, $dbname);
if (!$conn) { 
    die("Connection failed: " . mysqli_connect_error());
    db_error();
}

if (isset($_POST["itemid"])) {
    $iid = test_data($_POST["itemid"]);

    $sql = "SELECT is_featured
            FROM items
            WHERE item_id = $iid";
        
    $results = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($results);
    $is_featured = $row["is_featured"];
    
    $is_featured = $is_featured ? 0 : 1; 

    $sql = "UPDATE items
            SET is_featured = $is_featured
            WHERE item_id = $iid";
    $results = mysqli_query($conn, $sql);
    
}

header("Location: " . "../templates/managerpage.php");
exit();


?>